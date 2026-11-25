<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kredensial;
use Illuminate\Http\Request;

class KredensialController extends Controller
{
    public function index(Request $request)
    {
        $query = Kredensial::query()->latest();

        // 🔍 SEARCH
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('negara', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('submitted_by', 'like', "%{$search}%");
            });
        }

        // 🔽 FILTER STATUS (FIX FINAL)
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // 🔥 PAGINATION
        $data = $query->paginate(10)->withQueryString();

        // 🌍 LIST NEGARA (A-Z biar rapi)
        $countries = collect([
'Afghanistan','Albania','Algeria','Andorra','Angola','Argentina','Armenia','Australia','Austria','Azerbaijan',
'Bahamas','Bahrain','Bangladesh','Barbados','Belarus','Belgium','Belize','Benin','Bhutan','Bolivia',
'Bosnia and Herzegovina','Botswana','Brazil','Brunei','Bulgaria','Burkina Faso','Burundi',
'Cambodia','Cameroon','Canada','Chad','Chile','China','Colombia','Costa Rica','Croatia','Cuba','Cyprus','Czech Republic',
'Denmark','Dominican Republic',
'Ecuador','Egypt','El Salvador','Estonia','Ethiopia',
'Finland','France',
'Gabon','Georgia','Germany','Ghana','Greece','Guatemala',
'Haiti','Honduras','Hungary',
'Iceland','India','Indonesia','Iran','Iraq','Ireland','Israel','Italy',
'Jamaica','Japan','Jordan',
'Kazakhstan','Kenya','Kuwait',
'Laos','Latvia','Lebanon','Libya','Lithuania','Luxembourg',
'Malaysia','Maldives','Mali','Malta','Mexico','Mongolia','Morocco','Myanmar',
'Nepal','Netherlands','New Zealand','Nigeria','North Korea','Norway',
'Oman',
'Pakistan','Panama','Paraguay','Peru','Philippines','Poland','Portugal',
'Qatar',
'Romania','Russia',
'Saudi Arabia','Singapore','Slovakia','Slovenia','South Africa','South Korea','Spain','Sri Lanka','Sudan','Sweden','Switzerland',
'Syria',
'Taiwan','Thailand','Tunisia','Turkey',
'Ukraine','United Arab Emirates','United Kingdom','United States','Uruguay','Uzbekistan',
'Venezuela','Vietnam',
'Yemen',
'Zambia','Zimbabwe'
])->sort()->values();

        return view('pages.admin.kredensial.index', compact('data','countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'negara' => 'required|string|max:100',
            'username' => 'required|string|max:100',
            'password' => 'required|string|min:3',
        ]);

        Kredensial::create([
            'negara' => $validated['negara'],
            'username' => $validated['username'],
            'password' => $validated['password'], // sementara plain (sesuai UI lu)
            'submitted_by' => auth()->user()->name ?? 'Admin',
            'tanggal' => now(),
            'status' => 'pending'
        ]);

        return back()->with('success', 'Data berhasil ditambahkan');
    }

    public function approve($id)
    {
        Kredensial::findOrFail($id)->update([
            'status' => 'approved'
        ]);

        return back()->with('success', 'Kredensial disetujui');
    }

    public function reject($id)
    {
        Kredensial::findOrFail($id)->update([
            'status' => 'rejected'
        ]);

        return back()->with('success', 'Kredensial ditolak');
    }

    public function destroy($id)
    {
        Kredensial::findOrFail($id)->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}