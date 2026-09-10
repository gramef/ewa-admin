<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test {email? : Recipient email address}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email to verify SMTP configuration and diagnose connection issues';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $recipient = $this->argument('email') ?: setting('mail_from_address', 'support@ewaofficialapp.com');

        $this->info("=== EWA Mail Configuration Diagnostic ===");
        $this->table(['Setting', 'Value'], [
            ['Driver / Mailer', config('mail.default')],
            ['Host', config('mail.mailers.smtp.host')],
            ['Port', config('mail.mailers.smtp.port')],
            ['Encryption', config('mail.mailers.smtp.encryption') ?: 'none'],
            ['Username', config('mail.mailers.smtp.username')],
            ['From Address', config('mail.from.address')],
            ['From Name', config('mail.from.name')],
            ['Email Notifications Enabled', setting('enable_email_notifications', false) ? 'YES' : 'NO'],
            ['Target Recipient', $recipient],
        ]);

        if (!setting('enable_email_notifications', false)) {
            $this->warn("Note: 'enable_email_notifications' is currently set to NO/false in database.");
        }

        $this->info("\nAttempting to send test email to [{$recipient}] via SMTP...");

        try {
            Mail::raw("This is a test email from EWA Hair Platform sent at " . now()->toRfc2822String() . " to verify SMTP delivery.", function ($message) use ($recipient) {
                $message->to($recipient)
                    ->subject("EWA Hair Platform — SMTP Diagnostic Test Email");
            });

            $this->info("\nSUCCESS: Email was accepted by the SMTP server without errors!");
            $this->info("Please check the inbox and spam/junk folder for [{$recipient}].");
            return 0;
        } catch (\Throwable $e) {
            $this->error("\nFAILED to send email: " . $e->getMessage());
            $this->error("Exception type: " . get_class($e));

            $this->line("\n--- Troubleshooting Tips ---");
            if (str_contains(strtolower($e->getMessage()), 'connection could not be established') || str_contains(strtolower($e->getMessage()), 'connection refused')) {
                $this->line("1. Port/Encryption mismatch: If using port 465, encryption must be SSL. If using port 587, encryption must be TLS.");
                $this->line("2. Bluehost local host: Try setting Mail Host to 'localhost' if running directly on the cPanel server.");
            } elseif (str_contains(strtolower($e->getMessage()), '535') || str_contains(strtolower($e->getMessage()), 'authentication')) {
                $this->line("1. Password issue: Verify the password for username '" . config('mail.mailers.smtp.username') . "' in cPanel Email Accounts.");
            } elseif (str_contains(strtolower($e->getMessage()), 'sender') || str_contains(strtolower($e->getMessage()), 'from')) {
                $this->line("1. From Address: Ensure 'mail_from_address' matches a valid email created in your cPanel account.");
            }

            return 1;
        }
    }
}
