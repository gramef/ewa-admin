<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCancellationFieldsToBookings extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('cancellation_fee', 10, 2)->nullable()->after('booking_status_id');
            $table->text('cancellation_reason')->nullable()->after('cancellation_fee');
            $table->timestamp('cancelled_at')->nullable()->after('cancellation_reason');
            $table->string('cancelled_by', 20)->nullable()->after('cancelled_at'); // 'customer' or 'vendor'
            $table->boolean('cancellation_fee_waived')->default(false)->after('cancelled_by');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'cancellation_fee',
                'cancellation_reason',
                'cancelled_at',
                'cancelled_by',
                'cancellation_fee_waived',
            ]);
        });
    }
}
