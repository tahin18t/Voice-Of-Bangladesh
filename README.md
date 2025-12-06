# Voice of Bangladesh

Voice of Bangladesh is an innovative digital governance initiative designed to bridge the communication gap between citizens and the Government of Bangladesh. This platform provides a transparent and efficient way for citizens to express their feedback, complaints, and suggestions while enabling government departments to respond intelligently through automated routing, categorization, and analysis powered by artificial intelligence. 
The system supports bilingual interaction (Bangla and English), mobile responsiveness, and advanced analytics to derive policy insights. By empowering both citizens and government officers with a unified digital interface, Voice of Bangladesh aims to enhance accountability, responsiveness, and citizen satisfaction while supporting the broader vision of a Smart and Digital Bangladesh.

Task Distribution:
| Name                       | ID               | Task    |
|----------------------------|------------------|---------|
| Md Shahriar Mannan Prottoy | 0242220005101490 | Fr1,FR2 |
| Mahtab Chowdhury           | 0242220005101076 | FR3,FR2 |
| Shahriar Sakhawat Tahin    | 0242220005101383 | FR4,FR2 |
| Md Shehabub Mobin Siam     | 0242220005101043 | FR7,FR2 |
| Abdulla Al Moin            | 0242220005101382 | FR6,FR2 |



Feature List:
functional Require ments:
1) Submit Feedback
2) Multi-lingual(English & Bengali)
3) Track Issues
4) Officer Portal
5) AI Intelligence
6) Login & Signup
7) Home Page

Installation Guide:
Prerequisites
PHP >= 8.1
Composer
MySQL or MariaDB
Node.js & NPM
Git
Step-by-Step Setup
# 1. Clone the repository
git clone https:https://github.com/tahin18t/Voice-Of-Bangladesh.git

# 2. Install PHP dependencies
composer install

# 3. Install frontend assets
npm install && npm run build

# 4. Copy the environment file
cp .env.example .env

# 5. Generate application key
php artisan key: generate

# 6. Configurethe  database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hims_db
DB_USERNAME=root
DB_PASSWORD=

# 7. Run migrations & seed initial data
php artisan migrate --seed

# 8. (Optional) Create a symbolic link for storage
php artisan storage: link

# 9. Start the development server
php artisan serve


# Project Output Overview:
1. Citizen Feedback Submission Interface

Fully responsive and bilingual (Bangla & English) web portal.

Allows citizens to submit:

  Complaints

  Suggestions

  Feedback

  Attachments

Captures detailed information: category, region, description, and files.

Optimized UI for mobile & desktop.

2. AI-Powered Categorization & Routing

AI model analyzes user feedback and:

Assigns categories

Forwards issues to correct governmental departments automatically

Improves:

Speed

Accuracy

Consistency

Significantly reduces manual workload.

3. Issue Tracking System

Citizens receive a unique Tracking ID.

Real-time status visibility:

Received

Under Review

In Process

Resolved

Ensures transparency & public accountability.

4. Officer Dashboard

Secure dashboard for government officials.

Features:

Manage & prioritize complaints

Update status

Generate reports

View analytics

Improves workflow efficiency and departmental coordination.

 5. User Authentication Module

Secure login/signup for:

Citizens

Government Officers

Includes:

Validation

Session handling

Role-based access control (RBAC)

Ensures privacy and data protection.

6. Analytical Insights & Visualization

Integrated analytics dashboard displays:

Complaint distribution (category-wise)

District/area-wise mapping

Patterns & frequency trends

Average resolution time

These insights assist policymakers in detecting recurring issues and planning interventions.

7. Modern Responsive Frontend

Technologies & tools used:

Google Fonts

Font Awesome Icons

AOS Animations

LeafletJS Interactive Maps

Clean and intuitive UI/UX

Fully responsive layout for all screen sizes

# Acknowledgement

We express our heartfelt gratitude to everyone who supported the development of Voice of Bangladesh.

# Project Supervisor

Md Mezbaul Islam Zion
Thank you for your expert guidance, valuable feedback, and constant motivation. Your mentorship shaped both the technical and strategic aspects of this project.

# Institutional Support

We thank Daffodil International University and the Department of Computer Science & Engineering for providing resources, an excellent academic environment, and the platform to execute this project.

# Team Contribution

This project is the result of the hard work and collaboration of every team member. Each individual's dedication played a crucial role in achieving the final outcome.

# Family & Friends

Thank you for your patience, understanding, and moral support throughout the development and documentation phases.

![image alt](https://github.com/tahin18t/Voice-Of-Bangladesh/blob/2452cefa57e1cb404514b028d3e39f62f6521b78/UI%20(1).png)

