# 🎉 **Laravel LMS Installation Instructions** 🎉

## 1. Navigate to the project folder:
cd lms

## 2. Install dependencies by running:
composer install

## 3. Set up your database connection in the .env file (ensure you have MySQL running on your local machine):
# Edit the .env file to match your local database settings
echo "
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lms_db
DB_USERNAME=root
DB_PASSWORD=
" > .env

## 4. Run the migrations to set up your database schema:
php artisan migrate

## 5. Seed the database with sample data:
php artisan db:seed

## 6. Install Laravel Breeze with Livewire for authentication and user management:
composer require laravel/breeze --dev
php artisan breeze:install
php artisan migrate

## 7. Run the development server with:
php artisan serve

## 8. Open your browser and go to http://localhost:8000 to see the app in action!

## 9. Create a `.env` file in the root directory and add the following variables:
### APP_KEY=base64:your_app_key_here
### DB_CONNECTION=mysql
### DB_HOST=127.0.0.1
### DB_PORT=3306
### DB_DATABASE=lms_db
### DB_USERNAME=root
### DB_PASSWORD=

# 🎉 You're all set up! 🎉

## 🌟 Create a new Laravel project with your desired configurations
composer create-project --prefer-dist laravel/laravel lms

## 🎯 Navigate into the project folder
cd lms

## 📦 Install necessary Laravel packages
composer require laravel/breeze --dev

## 🛠️ Install Breeze authentication system
php artisan breeze:install
php artisan migrate

## 🔧 Run the migrations to set up the database schema
php artisan migrate

## 💾 Seed the database with initial data
php artisan db:seed

## 🚀 Run the development server locally
php artisan serve

## 📦 Install Laravel Toastr for notifications
composer require yoeunes/toastr

## 🎯 Publish Toastr config and assets
php artisan vendor:publish --provider="Yoeunes\Toastr\ToastrServiceProvider"

## 🛠️ Set up models, migrations, and controllers
php artisan make:model PendingUser -m
php artisan make:model AcademicLevel -m
php artisan make:request StoreAcademicLevels
php artisan make:controller AcademicLevelsController

## 🚀 Install necessary front-end dependencies (Bootstrap, Livewire, etc.)
composer require livewire/livewire

## 🎉 Finished! Your development environment is set up!

# **Features and Technologies Used in the LMS** 🎉

## 🚀 **Technologies:**

- 🛠️ Laravel: PHP framework for backend development and routing.
- 🔐 Breeze Authentication: Provides simple user authentication.
- 📦 Livewire: Full-stack framework for Laravel for building dynamic interfaces.
- 📱 Toastr Notifications: Real-time notifications for user feedback.
- 💾 MySQL: Database management for persistent data storage.

## 🛒 **Features:**

- 🧑‍🏫 User Management: Login, registration, and password reset with Laravel Breeze.
- 📚 Course Management: Admin panel to create, update, and delete courses.
- 👩‍🏫 Academic Levels: Manage student academic levels in the system.
- 📝 Classrooms: Admin can create classrooms for students and assign them to courses.
- 🚀 Livewire Integration: Seamless user experience with Livewire for real-time updates and interaction.

## 🎯 **Additional Highlights:**

- 🔄 Database Seeding: Automatically populate your database with sample data.
- 🔔 Notifications: Toast notifications to enhance user experience.
- 💻 Real-time Admin Panel: Manage users, courses, classrooms, and more directly from the browser.
- 🎓 Educational Tool: Designed to streamline the process of managing an educational institution.
  
# This app provides a comprehensive Learning Management System (LMS) with modern features and cutting-edge technologies to facilitate a smooth educational experience! 🌟
