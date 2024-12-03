# 🎉 **Laravel LMS Installation and Setup** 🎉

# 1. Create Laravel project and generate application key
composer create-project --prefer-dist laravel/laravel lms "10.*"
php artisan key:generate

# 2. Set up database environment variables
echo "
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lms_db
DB_USERNAME=root
DB_PASSWORD=
" > .env

# 3. Install Laravel Breeze with Livewire support
composer require laravel/breeze --dev
php artisan breeze:install
# Select Livewire during installation
php artisan migrate

# 4. Run PHPUnit tests
phpunit

# 5. Create seeders and seed the database
php artisan make:seeder UsersTableSeeder
php artisan db:seed

# 6. Create additional models, migrations, requests, and controllers
php artisan make:model PendingUser -m
php artisan make:model AcademicLevel -m
php artisan make:request StoreAcademicLevels
php artisan make:interface AcademicLevelRepositoryInterface
php artisan make:controller AcademicLevelsController

# 7. Install and configure Toastr for notifications
composer require yoeunes/toastr
php artisan vendor:publish --provider="Yoeunes\Toastr\ToastrServiceProvider"

# 8. Set up classrooms
php artisan make:migration create_classrooms_table --create=classrooms
php artisan migrate
php artisan make:model Classroom
php artisan make:request StoreClassrooms

# 9. Create and migrate sections table
php artisan make:migration create_sections_table --create=sections
php artisan make:model Section

# 10. Add blood types and seed them
php artisan make:model Blood -m
php artisan make:seeder BloodSeeder
php artisan db:seed --class=BloodSeeder

# 11. Create and seed nationalities
php artisan make:model Nationality -m
php artisan make:seeder NationalitySeeder
php artisan db:seed --class=NationalitySeeder

# 12. Add student parents table
php artisan make:migration create_student_parents_table --create=student_parents
php artisan make:model StudentParent

# 13. Add religions and seed them
php artisan make:model Religion -m
php artisan make:seeder ReligionSeeder
php artisan db:seed --class=ReligionSeeder

# 14. Seed parent data
php artisan db:seed --class=ParentSeeder

# 15. Create Livewire components for student-parent management
php artisan make:livewire StudentParentManager
php artisan make:livewire AddParent

# 16. Add attachments table
php artisan make:migration create_attachments_table
php artisan make:model Attachment

# 17. Create other models, migrations, and seeders
php artisan make:model Gender -m
php artisan make:model Specialization -m
php artisan make:model Teacher -m
php artisan make:controller TeacherController
php artisan make:seeder GenderSeeder
php artisan make:seeder SpecializationSeeder
php artisan make:seeder TeacherSeeder
php artisan make:request StoreTeachers
php artisan make:migration create_teacher_section_table

# 18. Create students table and model
php artisan make:migration create_students_table --create=students
php artisan make:model Student

# 19. Rollback and reapply migrations (if needed)
php artisan migrate:rollback --path=/database/migrations/2024_11_06_151322_create_processing_fees_table.php
php artisan migrate --path=/database/migrations/2024_11_06_151322_create_processing_fees_table.php

# 20. Add more models and migrations for fees and invoices
php artisan make:model Fees -m
php artisan make:request StoreFeesRequest
php artisan make:migration create_fee_invoices_table --create=fee_invoices
php artisan make:model FeeInvoice

# 21. Add and seed student accounts
php artisan make:migration create_student_accounts_table
php artisan make:seeder StudentSeeder
php artisan make:migration create_receipt_students_table
php artisan make:model ReceiptStudent
php artisan make:controller ReceiptStudentController --resource
php artisan make:request StoreReceiptStudentRequest

# 22. Create fund accounts and subjects
php artisan make:migration create_fund_accounts_table
php artisan make:model attendances -m
php artisan make:migration create_subjects_table --create=subjects
php artisan make:model Subject -m
php artisan make:request SubjectRequest

# 23. Add exams and questions
php artisan make:migration create_exams_table
php artisan make:migration create_questions_table

# 24. Zoom integration (install and remove packages as needed)
composer require macsidigital/laravel-zoom
php artisan vendor:publish --provider="MacsiDigital\Zoom\Providers\ZoomServiceProvider"
composer remove macsidigital/laravel-zoom
composer require jubaer/zoom-laravel
composer remove jubaer/zoom-laravel

# 25. Create libraries and settings
php artisan make:migration create_libraries_table
php artisan make:model Library
php artisan make:migration create_settings_table
php artisan make:model Setting
php artisan make:controller SettingController
php artisan make:seeder SettingsSeeder
php artisan make:provider SettingsServiceProvider

# 26. Add events and calendar Livewire component
php artisan make:model Event -m
php artisan make:livewire Calendar

# 27. Seed teacher data
php artisan db:seed --class=TeacherSeeder

# 28. Additional setup and maintenance commands
php artisan make:controller TeacherDashboardController
php artisan make:middleware MultiGuardMiddleware
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
#   L M S  
 