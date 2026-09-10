<?php

namespace App\Http\Controllers;

use App\Models\CommunicationLog;
use Illuminate\Http\Request;

class CommunicationLogController extends Controller
{
    public function index(Request $request)
    {
        $query = CommunicationLog::with(['booking', 'caller', 'receiver', 'eProvider'])->latest();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('caller_role')) {
            $query->where('caller_role', $request->caller_role);
        }
        if ($request->filled('booking_id')) {
            $query->where('booking_id', $request->booking_id);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('phone_dialed', 'like', "%{$s}%")
                  ->orWhereHas('caller', function ($cq) use ($s) {
                      $cq->where('name', 'like', "%{$s}%")->orWhere('phone_number', 'like', "%{$s}%");
                  })
                  ->orWhereHas('eProvider', function ($pq) use ($s) {
                      $pq->where('name', 'like', "%{$s}%");
                  });
            });
        }

        $logs = $query->paginate(20);

        $stats = [
            'total_calls' => CommunicationLog::where('type', 'phone_call')->count(),
            'today_calls' => CommunicationLog::where('type', 'phone_call')->whereDate('created_at', today())->count(),
            'client_calls' => CommunicationLog::where('caller_role', 'client')->count(),
            'vendor_calls' => CommunicationLog::where('caller_role', 'vendor')->count(),
        ];

        return view('communication_logs.index', compact('logs', 'stats'));
    }

    public function show(int $id)
    {
        $log = CommunicationLog::with(['booking', 'caller', 'receiver', 'eProvider'])->findOrFail($id);
        return view('communication_logs.show', compact('log'));
    }
}
