<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventaris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventarisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $inventaris = Inventaris::with('category')
            ->where('id_user', $user->id)
            ->withCount([
                'stocks as stok_aktif' => function ($query) {
                    $query->where('status', 1);
                },
                'stocks as stok_tidak_aktif' => function ($query) {
                    $query->where('status', 0);
                }
            ])
            ->get();
        // dd($inventaris);

        $categories = Category::all();
        $totalBarang = $inventaris->count();

        $stokAktif = $inventaris->sum('stok_aktif');
        $stokTidakAktif = $inventaris->sum('stok_tidak_aktif');
        $totalStok = $stokAktif + $stokTidakAktif;

        $viewPath = 'inventaris.index';

        if ($user) {
            if ($user->role === 'admin_LM') {
                $viewPath = 'admin.inventaris.index';
            } elseif ($user->role === 'admin_dekanat') {
                $viewPath = 'dekanat.inventaris.index';
            }
        }

        return view($viewPath, compact(
            'inventaris',
            'categories',
            'totalBarang',
            'totalStok',
            'stokAktif',
            'stokTidakAktif'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.inventaris.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventaris $inventaris)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventaris $inventaris)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventaris $inventaris)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventaris $inventaris)
    {
        //
    }
}
