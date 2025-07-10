<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\SmtpSetting;
Use Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        if (\Schema::hasTable('smtp_settings')) {
            # code...
            $smtpsetting = SmtpSetting::first();

            if ($smtpsetting) {
                # code...
                $data = [
                    'driver' => $smtpsetting->mailer,
                    'host' => $smtpsetting->host,
                    'port' => $smtpsetting->port,
                    'username' => $smtpsetting->username,
                    'password' => $smtpsetting->password,
                    'encryption' => $smtpsetting->encryption,
                    'from' => [
                        'address' => $smtpsetting->from_address,
                        'name' => 'Aduca'
                    ]
                ];
                Config::set('mail',$data);
            }

        }//End If
    }
}
