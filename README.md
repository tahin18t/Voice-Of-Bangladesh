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

<h1 align="center">UI</h1>
<img width="1398" height="760" alt="image" src="https://github.com/user-attachments/assets/5676af26-242f-45db-9513-7e9a2e696ebb" />

<img width="852" height="910" alt="image" src="https://github.com/user-attachments/assets/8b7b7220-b6ca-4494-918b-79550cd31867" />
<img width="865" height="881" alt="image" src="https://github.com/user-attachments/assets/affa6c0b-7b7d-498d-a357-043d6629e382" />

<img width="666" height="907" alt="image" src="https://github.com/user-attachments/assets/d9fc97e0-88b3-4b98-8445-3e33121bc2d8" />

<img width="642" height="870" alt="image" src="https://github.com/user-attachments/assets/f7853436-1d13-4482-8118-62b76d630a38" />



![image alt](https://github.com/tahin18t/Voice-Of-Bangladesh/blob/2452cefa57e1cb404514b028d3e39f62f6521b78/UI%20(1).png)

![image alt](https://github.com/tahin18t/Voice-Of-Bangladesh/blob/2f2f073affceffea831ea13b1f935ca3e45bb9f4/UI%20(2).png)

![image alt](https://github.com/tahin18t/Voice-Of-Bangladesh/blob/2f2f073affceffea831ea13b1f935ca3e45bb9f4/UI%20(3).png)

![image alt](https://github.com/tahin18t/Voice-Of-Bangladesh/blob/2f2f073affceffea831ea13b1f935ca3e45bb9f4/UI%20(4).png)

![image alt](https://github.com/tahin18t/Voice-Of-Bangladesh/blob/24020c821ee6952549aa86208e1b50c2c925d423/UI%20(5).png)

![image alt](https://github.com/tahin18t/Voice-Of-Bangladesh/blob/a7266cd98dca601e824fe14734463322a3d66322/UI%20(6).png)

![image alt](https://github.com/tahin18t/Voice-Of-Bangladesh/blob/a7266cd98dca601e824fe14734463322a3d66322/UI%20(7).png)

![image alt](https://github.com/tahin18t/Voice-Of-Bangladesh/blob/806a24976a2f1bda14eea148136a22d7b4e00ccb/UI%20(8).png)

![image alt](https://github.com/tahin18t/Voice-Of-Bangladesh/blob/806a24976a2f1bda14eea148136a22d7b4e00ccb/UI%20(9).png)

![image alt](https://github.com/tahin18t/Voice-Of-Bangladesh/blob/806a24976a2f1bda14eea148136a22d7b4e00ccb/UI%20(10).png)
Database Image
![6192538939378305843](https://github.com/user-attachments/assets/455e0dbc-aa97-4719-abee-73a903d05970)
![6192538939378305844](https://github.com/user-attachments/assets/c3eecc23-b4fd-4a01-9e09-d2f5f776c516)
![6192538939378305845](https://github.com/user-attachments/assets/3aafbc3c-afbb-4bb4-a076-9b763df8d907)
![6192538939378305846](https://github.com/user-attachments/assets/2386bb15-4687-4168-b835-7a2630215ebf)

