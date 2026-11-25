<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kredensial;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // =======================
        // 📊 STATS
        // =======================
        $total = Kredensial::count();
        $approved = Kredensial::where('status', 'approved')->count();
        $pending = Kredensial::where('status', 'pending')->count();
        $rejected = Kredensial::where('status', 'rejected')->count();

        // =======================
        // 📊 BAR CHART (7 hari terakhir)
        // =======================
        $labels = [];
        $submit = [];
        $setujui = [];
        $tolak = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);

            $labels[] = $date->format('D');

            $submit[] = Kredensial::whereDate('created_at', $date)->count();
            $setujui[] = Kredensial::whereDate('created_at', $date)
                ->where('status', 'approved')->count();
            $tolak[] = Kredensial::whereDate('created_at', $date)
                ->where('status', 'rejected')->count();
        }

        // =======================
        // 🧾 LOG AKTIVITAS
        // =======================
        $logs = Kredensial::latest()->take(7)->get()->map(function ($item) {

            // bikin role variatif
            $roles = ['ADMIN', 'VERIFIKATOR', 'USER'];
            $role = $roles[array_rand($roles)];

            if ($item->status == 'approved') {
                $aksi = 'Setujui Kredensial';
                $status = 'success';
            } elseif ($item->status == 'rejected') {
                $aksi = 'Tolak Kredensial';
                $status = 'warning';
            } else {
                $aksi = 'Submit Kredensial';
                $status = 'success';
            }

            return [
                'user' => $item->submitted_by ?? 'Unknown',
                'role' => $role,
                'aksi' => $aksi,
                'target' => $item->negara,
                'waktu' => Carbon::parse($item->created_at)->format('H:i'),
                'status' => $status
            ];
        });

        return view('pages.admin.dashboard', compact(
            'total',
            'approved',
            'pending',
            'rejected',
            'labels',
            'submit',
            'setujui',
            'tolak',
            'logs'
        ));
    }
}