<?php
/*
 * File name: AppServiceProvider.php
 * Last modified: 2021.09.15 at 13:28:01
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Providers;

use Exception;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Stripe\Stripe;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // Auto-start trial when vendor is accepted
        \App\Models\EProvider::observe(\App\Observers\EProviderObserver::class);

        try {
            $mailDriver = setting('mail_driver', env('MAIL_MAILER', 'smtp'));
            $mailHost = setting('mail_host', env('MAIL_HOST', 'mail.ewaofficialapp.com'));
            $mailPort = setting('mail_port', env('MAIL_PORT', 465));
            $mailEncryption = setting('mail_encryption', env('MAIL_ENCRYPTION', 'ssl'));
            $mailUsername = setting('mail_username', env('MAIL_USERNAME'));
            $mailPassword = setting('mail_password', env('MAIL_PASSWORD'));
            $mailFromAddress = setting('mail_from_address', env('MAIL_FROM_ADDRESS', 'support@ewaofficialapp.com'));
            $mailFromName = setting('mail_from_name', env('MAIL_FROM_NAME', 'EWA Hair'));

            config([
                'mail.default' => $mailDriver,
                'mail.mailers.smtp.transport' => 'smtp',
                'mail.mailers.smtp.host' => $mailHost,
                'mail.mailers.smtp.port' => $mailPort,
                'mail.mailers.smtp.encryption' => $mailEncryption,
                'mail.mailers.smtp.username' => $mailUsername,
                'mail.mailers.smtp.password' => $mailPassword,
                'mail.from.address' => $mailFromAddress,
                'mail.from.name' => $mailFromName,

                // Legacy keys for backwards compatibility
                'mail.driver' => $mailDriver,
                'mail.host' => $mailHost,
                'mail.port' => $mailPort,
                'mail.encryption' => $mailEncryption,
                'mail.username' => $mailUsername,
                'mail.password' => $mailPassword,
            ]);

            config(['services.mailgun.domain' => setting('mailgun_domain')]);
            config(['services.mailgun.secret' => setting('mailgun_secret')]);

            config(['services.sparkpost.secret' => setting('sparkpost_secret')]);
            config(['services.sparkpost.options.endpoint' => setting('sparkpost_options_endpoint')]);

            config(['services.facebook.client_id' => setting('facebook_app_id')]);
            config(['services.facebook.client_secret' => setting('facebook_app_secret')]);
            config(['services.facebook.redirect' => url('login/facebook/callback')]);
            config(['services.twitter.client_id' => setting('twitter_app_id')]);
            config(['services.twitter.client_secret' => setting('twitter_app_secret')]);
            config(['services.twitter.redirect' => url('login/twitter/callback')]);
            config(['services.google.client_id' => setting('google_app_id')]);
            config(['services.google.client_secret' => setting('google_app_secret')]);
            config(['services.google.redirect' => url('login/google/callback')]);

            config(['services.stripe.key' => setting('stripe_key')]);
            config(['services.stripe.secret' => setting('stripe_secret')]);
            Stripe::setApiKey(setting('stripe_secret'));
            Stripe::setClientId(setting('stripe_key'));
            config(['services.razorpay.key' => setting('razorpay_key')]);
            config(['services.razorpay.secret' => setting('razorpay_secret')]);

            config(['services.fcm.key' => setting('fcm_key', '')]);
            config(['services.fcm.project_id' => setting('firebase_project_id', '')]);
            config(['services.fcm.service_account_json_path' => setting('firebase_service_account_json_path', '')]);

            config(['paypal.mode' => setting('paypal_mode', '0') != '0' ? 'live' : 'sandbox']);
            config(['paypal.currency' => Str::upper(setting('default_currency_code', 'USD'))]);

            config(['paypal.sandbox.username' => setting('paypal_username')]);
            config(['paypal.sandbox.password' => setting('paypal_password')]);
            config(['paypal.sandbox.secret' => setting('paypal_secret')]);
            config(['paypal.sandbox.app_id' => "APP-80W284485P519543T"]);

            config(['paypal.live.username' => setting('paypal_username')]);
            config(['paypal.live.password' => setting('paypal_password')]);
            config(['paypal.live.secret' => setting('paypal_secret')]);
            config(['paypal.live.app_id' => setting('paypal_app_id')]);

            config(['app.timezone' => setting('timezone', 'UTC')]);
            date_default_timezone_set(setting('timezone', 'UTC'));
        } catch (Exception $e) {

        }
    }
}
