<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PurgeStaleData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'purge:stale-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove stale transactions, wallets, payments, payouts, and notifications older than 1 year';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $oneYearAgo = Carbon::now()->subYear();

        $deletedTx = DB::table('wallet_transactions')
            ->where('created_at', '<', $oneYearAgo)
            ->delete();
        $this->info("Deleted {$deletedTx} wallet transactions older than 1 year.");

        // Delete wallets older than 1 year that have no active transactions
        $deletedWallets = DB::table('wallets')
            ->where('created_at', '<', $oneYearAgo)
            ->where('updated_at', '<', $oneYearAgo)
            ->whereNotIn('id', function ($query) {
                $query->select('wallet_id')->from('wallet_transactions');
            })
            ->delete();
        $this->info("Deleted {$deletedWallets} unused wallets older than 1 year.");

        $deletedPayments = DB::table('payments')
            ->where('created_at', '<', $oneYearAgo)
            ->delete();
        $this->info("Deleted {$deletedPayments} payments older than 1 year.");

        $deletedPayouts = DB::table('e_provider_payouts')
            ->where('created_at', '<', $oneYearAgo)
            ->delete();
        $this->info("Deleted {$deletedPayouts} provider payouts older than 1 year.");

        $deletedBookings = DB::table('bookings')
            ->where('created_at', '<', $oneYearAgo)
            ->delete();
        $this->info("Deleted {$deletedBookings} bookings older than 1 year.");

        $deletedNotifs = DB::table('notifications')
            ->where('created_at', '<', $oneYearAgo)
            ->delete();
        $this->info("Deleted {$deletedNotifs} notifications older than 1 year.");

        $deletedSubs = DB::table('e_provider_subscriptions')
            ->where('created_at', '<', $oneYearAgo)
            ->where('active', false)
            ->delete();
        $this->info("Deleted {$deletedSubs} inactive subscriptions older than 1 year.");

        $this->info("Stale data purge completed successfully!");
        return 0;
    }
}
