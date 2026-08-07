<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cancellation Policy Windows
    |--------------------------------------------------------------------------
    |
    | Tiered, time-based cancellation fee structure.
    | Each window defines a threshold (hours before appointment) and the
    | fee percentage charged if cancellation occurs within that window.
    |
    | Windows are evaluated from top to bottom — the FIRST match wins.
    | Order: most generous (longest notice) first → strictest (shortest) last.
    |
    */
    'windows' => [
        [
            'threshold_hours' => 48,
            'fee_percent'     => 0,
            'label'           => 'Free cancellation',
        ],
        [
            'threshold_hours' => 24,
            'fee_percent'     => 50,
            'label'           => 'Late cancellation fee (50%)',
        ],
        [
            'threshold_hours' => 0,
            'fee_percent'     => 100,
            'label'           => 'Last-minute cancellation (100%)',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | No-Show Fee
    |--------------------------------------------------------------------------
    |
    | Fee charged when a customer does not show up at all (booking_status = 7
    | after the appointment time has passed).
    |
    */
    'no_show_fee_percent' => 100,

    /*
    |--------------------------------------------------------------------------
    | Vendor-Initiated Cancellation
    |--------------------------------------------------------------------------
    |
    | When a vendor/provider cancels, the customer is never charged.
    |
    */
    'vendor_cancel_free' => true,
];
