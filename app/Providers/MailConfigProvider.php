<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class MailConfigProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // get email view data in provider class
        view()->composer('email', function ($view) {

            if(isset(Auth::user()->id)) {

                $setting = Setting::where('name', 'smtp')->first();

                if (!is_null($setting)) {
                    $smtp_setting = json_decode($setting['value']);

                    $config = [
                        'driver'     => 'smtp',
                        'host'       => $smtp_setting->host,
                        'port'       => $smtp_setting->port,
                        'username'   => $smtp_setting->user,
                        'password'   => $smtp_setting->password,
                        'encryption' => $smtp_setting->security,
                        'from'       => array('address' => 'KijangMas Bandung', 'name' => 'Ela Wangi'),
                    ];
                    Config::set('mail', $config);
                }

            }
        });
    }
}
