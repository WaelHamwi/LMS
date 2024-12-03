<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
       
        $settings =  \DB::table('settings')->pluck('value', 'key')->toArray();
        if (isset($settings['timezone'])) {
            Config::set('app.timezone', $settings['timezone']);
        }
        //dd($settings);
        $mailSettings = [
            'smtp_from_address' => 'mail.from.address',
            'smtp_from_name' => 'mail.from.name',
            'mail_host' => 'mail.mailers.smtp.host',
            'mail_port' => 'mail.mailers.smtp.port',
            'mail_username' => 'mail.mailers.smtp.username',
            'mail_password' => 'mail.mailers.smtp.password',
            'mail_encryption' => 'mail.mailers.smtp.encryption',
        ];
    
        foreach ($mailSettings as $key => $configKey) {
            if (isset($settings[$key])) {
                Config::set($configKey, $settings[$key]);
            }
        }
      

        View::share('settings', $settings);
    }
}
