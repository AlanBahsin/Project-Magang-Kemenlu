<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kredensial;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kredensial::latest();

        // 🔍 SEARCH
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('negara', 'like', "%{$request->search}%")
                  ->orWhere('username', 'like', "%{$request->search}%")
                  ->orWhere('submitted_by', 'like', "%{$request->search}%");
            });
        }

        // 🔽 FILTER STATUS
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // 📄 PAGINATION (12)
        $data = $query->paginate(12)->withQueryString();

        return view('pages.admin.laporan.index', compact('data'));
    }

    // 🔥 EXPORT PDF
    public function exportPdf()
    {
        $data = Kredensial::latest()->get();

        $pdf = Pdf::loadView('pages.admin.laporan.pdf', compact('data'));

        return $pdf->download('laporan-akses.pdf');
    }
    public function exportExcel()
{
    $data = Kredensial::latest()->get();

    $filename = "laporan-akses.csv";

    $headers = [
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate",
        "Expires" => "0"
    ];

    $columns = ['No','Negara','Username','Status','Tanggal'];

    $callback = function() use ($data, $columns) {
        $file = fopen('php://output', 'w');

        fputcsv($file, $columns);

        foreach ($data as $i => $d) {
            fputcsv($file, [
                $i+1,
                $d->negara,
                $d->username,
                $d->status,
                $d->tanggal
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}