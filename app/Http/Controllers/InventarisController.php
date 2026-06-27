<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventaris;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InventarisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $inventaris = Inventaris::with('category')
            ->withCount([
                'stocks as stok_aktif' => function ($query) {
                    $query->where('status', 1);
                },
                'stocks as stok_tidak_aktif' => function ($query) {
                    $query->where('status', 0);
                }
            ])
            ->paginate(10);
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
        $categories = Category::all();
        return view('admin.inventaris.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'id_category' => 'required|exists:categories,id',
            'stok_awal' => 'required|integer|min:1',
            'status_stok' => 'required|in:0,1',
            'deskripsi' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $newRequest = $request->except(['_token', 'image', 'stok_awal', 'status_stok']);
        $newRequest['image'] = "";

        if ($request->file('image')) {
            $file = $request->file('image');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            // dd($fileName);

            Storage::disk('public')->putFileAs('images', $file, $fileName);
            $newRequest['image'] = 'storage/images/' . $fileName;
        }

        $newRequest['id_user'] = Auth::user()->id;
        $inventaris = Inventaris::create($newRequest);

        $jumlahStok = (int) $request->stok_awal;
        for ($i = 1; $i <= $jumlahStok; $i++) {
            Stock::create([
                'id_inventaris' => $inventaris->id,
                'status' => $request->status_stok,
            ]);
        }

        return redirect()
            ->route('admin.inventaris.index')
            ->with('message', "{$inventaris->nama} berhasil ditambahkan!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Inventaris $inventaris)
    {
        $user = Auth::user();
        $viewPath = 'inventaris.show';

        $statusTampilan = $request->query('status');
        // dd($statusTampilan);

        $jumlahStok = 0;
        if ($statusTampilan === '1') {
            $jumlahStok = $inventaris->stocks()->where('status', 1)->count();
            $statusStok = 'aktif';
        } elseif ($statusTampilan === '0') {
            $jumlahStok = $inventaris->stocks()->where('status', 0)->count();
            $statusStok = 'tidak aktif';
        }
        // dd($inventaris->stocks);

        // dd($jumlahStok);

        if ($user) {
            if ($user->role === 'admin_LM') {
                $viewPath = 'admin.inventaris.show';
            } elseif ($user->role === 'admin_dekanat') {
                $viewPath = 'dekanat.inventaris.show';
            }
        }

        // akan ambil relasi user juga lewat surat untuk menampilkan nama user yang meminjamkan barang

        return view($viewPath, compact('inventaris', 'jumlahStok', 'statusStok'));
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
