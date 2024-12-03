<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        DB::table('settings')->delete();
        DB::table('settings')->insert([
            ['key' => 'website_name', 'value' => 'LMS'],
            ['key' => 'logo', 'value' => 'default-logo.png'],
            ['key' => 'favicon', 'value' => 'default-favicon.ico'],
            ['key' => 'phone', 'value' => '00201065029927'],
            ['key' => 'address_line1', 'value' => '123 Main Street'],
            ['key' => 'address_line2', 'value' => 'Suite 101'],
            ['key' => 'city', 'value' => 'Cairo'],
            ['key' => 'state', 'value' => 'Cairo Governorate'],
            ['key' => 'zip_code', 'value' => '12345'],
            ['key' => 'country', 'value' => 'Egypt'],
            ['key' => 'school_email', 'value' => 'waellhamwii@gmail.com'],
            ['key' => 'timezone', 'value' => 'Antarctica/Palmer'],
            ['key' => 'date_format', 'value' => '15 May 2016'],
            ['key' => 'time_format', 'value' => '12 Hours'],
            
            // mail Settings
            ['key' => 'currency_symbol', 'value' => '$'],
            ['key' => 'php_mail_from_address', 'value' => 'phpmail@example.com'],
            ['key' => 'php_mail_password', 'value' => 'password123'],
            ['key' => 'php_mail_from_name', 'value' => 'PHP Mail Service'],

            
            ['key' => 'smtp_from_address', 'value' => 'smtp@example.com'],
            ['key' => 'smtp_password', 'value' => 'password456'],
            ['key' => 'smtp_from_name', 'value' => 'SMTP Service'],
            ['key' => 'smtp_host', 'value' => 'smtp.example.com'],
            ['key' => 'smtp_port', 'value' => '587'],
            ['key' => 'mail_encryption', 'value' => 'tls'],

            // social Settings
            ['key' => 'facebook', 'value' => 'https://www.facebook.com/profile.php?id=100025933565494'],
            ['key' => 'twitter', 'value' => 'https://www.twitter.com'],
            ['key' => 'youtube', 'value' => 'https://www.youtube.com'],
            ['key' => 'linkedin', 'value' => 'https://www.linkedin.com/in/wael-hamwi-660499223/'],
            ['key' => 'github', 'value' => '   https://github.com/WaelHamwi'],

            // SEO Settings
            ['key' => 'meta_title', 'value' => 'Welcome to LMS'],
            ['key' => 'meta_keywords', 'value' => 'LMS, Learning Management System, Online Education'],
            ['key' => 'meta_description', 'value' => 'The best platform for online learning, courses, and education. Join our LMS today!'],



        ]);
    }
}
