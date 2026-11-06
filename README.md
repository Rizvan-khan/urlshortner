# multi tenant URL Shortener

A multi-company URL shortener built with Laravel. A SuperAdmin invites client companies, each company's Admin invites their team, and Admins/Members generate short URLs. Access to data is scoped by role.

# Tech Stack
PHP 8.2+ and Laravel (see composer.json for the exact version)
Mysql
Laravel Breeze (Blade) for login/logout, with registration removed
Plain Blade + simple HTML (no custom frontend framework)
PHPUnit for tests

# Local Setup
Requirements
PHP 8.2 or higher 
Composer
Node.js 18+ and npm (only needed to build Breeze's assets)

Steps 

# 1. Clone the repository
git clone https://github.com/Rizvan-khan/urlshortner.git 
cd url-shortener

# 2. Install PHP dependencies
composer install

# 3. Environment file
cp .env.example .env
php artisan key:generate

# 4. Create the Mysql database file
use Mysql database


# 5. Run migrations and the SuperAdmin seeder
php artisan migrate --seed

# 6. Build frontend assets
npm install
npm run build

# 7. Start the server
php artisan serve

The app is now available at http://localhost:8000.

Make sure these values are set in .env:

DB_CONNECTION=mysql
MAIL_MAILER=log


# Default SuperAdmin Login credential

The SuperAdmin is created by SuperAdminSeeder using raw SQL (DB::insert), not Eloquent.

Field	Value
Email	superadmin@rizzu.com
Password	password


# How Invitation Emails Work Locally

Emails are not actually sent. MAIL_MAILER=log writes each email to the log file instead.

Send an invitation from the app.
Open storage/logs/laravel.log and scroll to the bottom.
Copy the link that looks like http://localhost:8000/invitation/<token>.
Open it (preferably in an incognito window), set a name and password, and you are logged in as the invited user.


# Walkthrough (How to Test the Flow)
Log in as the SuperAdmin.
Go to Invite Client, enter a company name and the Admin's email, and submit. This creates the company and the invitation in a single transaction.
Take the invitation link from laravel.log and accept it in another browser. You are now the Admin of that company.
As Admin, go to Invite Member and invite a user with the role Admin or Member. Accept that link as well.
As Admin or Member, go to Generate and create a short URL from a long URL.
Open the short link (/s/{code}). It redirects to the original URL and the hit count increases.
Compare dashboards: the Admin sees all URLs of their company, the Member sees only their own, and the SuperAdmin sees all URLs across companies but has no Generate option.


# Database
companies: id, name, email (unique)
users: standard Laravel columns plus role and company_id (nullable; the SuperAdmin has no company)
invitations: company_id, invited_by, name, email, role, token (unique), expires_at, accepted_at
short_urls: company_id, user_id, original_url, code (unique), hits

# Tests use an in-memory mysql database and cover:

SuperAdmin cannot create short URLs
Admin and Member can create short URLs
Admin sees only their own company's short URLs
Member sees only their own short URLs
Short URLs are publicly resolvable and redirect to the original URL


# AI Usage Discloser
I used AI tools (Claude) for the following:

1. create blade files and tables
2. setup roles and permission permission and some logics
