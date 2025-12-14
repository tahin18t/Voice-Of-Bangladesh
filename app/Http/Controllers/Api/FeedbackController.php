<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Assignment;
use App\Http\Requests\StoreFeedbackRequest;
use App\Http\Requests\UpdateFeedbackRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $query = Feedback::query()->with(['aiInsight', 'assignments', 'assignee', 'reporter']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('tracking_id')) {
            $query->where('tracking_id', $request->tracking_id);
        }

        $perPage = (int) $request->get('per_page', 15);
        $feedbacks = $query->latest()->paginate($perPage);
        return response()->json($feedbacks);
    }

    public function store(StoreFeedbackRequest $request)
    {
        $data = $request->validated();
        // Always trust authenticated user_id over request payload to prevent spoofing
        $data['user_id'] = $request->user()?->id;
        $data['tracking_id'] = $data['tracking_id'] ?? 'FB-' . strtoupper(Str::random(8));

        // Handle file uploads from either "files" or "attachments" inputs
        $uploaded = [];
        $files = $request->file('files', []);
        $attachments = $request->file('attachments', []);
        foreach ([$files, $attachments] as $fileSet) {
            foreach ($fileSet as $file) {
                $path = $file->store('feedbacks', 'public');
                $uploaded[] = Storage::url($path);
            }
        }
        if (!empty($uploaded)) {
            $data['attachments'] = $uploaded;
        }

        $feedback = Feedback::create($data);
        $feedback->load(['aiInsight', 'assignments']);

        return response()->json(['data' => $feedback], 201);
    }

    public function show($id)
    {
        $feedback = Feedback::with('aiInsight','assignments','assignee','reporter')->findOrFail($id);
        return response()->json($feedback);
    }

    public function update(UpdateFeedbackRequest $request, $id)
    {
        $feedback = Feedback::findOrFail($id);
        $data = $request->validated();

        // Attach any new files to the attachments array while keeping existing ones
        $uploaded = [];
        $files = $request->file('files', []);
        $attachments = $request->file('attachments', []);
        foreach ([$files, $attachments] as $fileSet) {
            foreach ($fileSet as $file) {
                $path = $file->store('feedbacks', 'public');
                $uploaded[] = Storage::url($path);
            }
        }

        if (!empty($uploaded)) {
            $existing = is_array($feedback->attachments) ? $feedback->attachments : [];
            $data['attachments'] = array_values(array_unique(array_merge($existing, $uploaded)));
        }

        $feedback->update($data);
        $feedback->load(['aiInsight', 'assignments']);

        return response()->json($feedback);
    }

    public function assign(Request $request, $id)
    {
        $feedback = Feedback::findOrFail($id);
        $request->validate(['assigned_to' => 'required|exists:users,id','note' => 'nullable|string']);

        $assignment = Assignment::create([
            'feedback_id' => $feedback->id,
            'assigned_by' => $request->user() ? $request->user()->id : null,
            'assigned_to' => $request->assigned_to,
            'note' => $request->note,
            'status' => 'assigned',
        ]);

        $feedback->assigned_to = $request->assigned_to;
        $feedback->status = 'in_progress';
        $feedback->save();

        return response()->json(['assignment' => $assignment, 'feedback' => $feedback], 201);
    }

    public function updateStatus(Request $request, $id)
    {
        $feedback = Feedback::findOrFail($id);
        $request->validate(['status' => 'required|in:pending,assigned,in_progress,resolved,closed']);
        $feedback->status = $request->status;
        $feedback->save();
        return response()->json($feedback);
    }

    public function track($trackingId)
    {
        $feedback = Feedback::with(['aiInsight', 'assignments', 'assignee', 'reporter'])
            ->where('tracking_id', $trackingId)
            ->firstOrFail();

        return response()->json(['data' => $feedback]);
    }
}
