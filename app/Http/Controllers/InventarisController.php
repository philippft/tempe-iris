<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventaris;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InventarisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $search     = request('search');
        $categoryId = request('category');

        $inventaris = Inventaris::with('category')
            ->where('id_user', $user->id)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");

                    if (is_numeric($search)) {
                        $q->orWhere('id', $search);
                    }
                });
            })
            ->when($categoryId, function ($query, $categoryId) {
                $query->where('id_category', $categoryId);
            })
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

        $categories  = Category::all();
        $totalBarang = $inventaris->count();

        $stokAktif      = $inventaris->sum('stok_aktif');
        $stokTidakAktif = $inventaris->sum('stok_tidak_aktif');
        $totalStok      = $stokAktif + $stokTidakAktif;

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
            'stokTidakAktif',
            'search',
            'categoryId'
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
            'nama'         => 'required|string|max:255',
            'id_category'  => 'required|exists:categories,id',
            'stok_awal'    => 'required|integer|min:1',
            'status_stok'  => 'required|in:0,1',
            'deskripsi'    => 'nullable|string',
            'image'        => 'required|image|mimes:jpeg,png,jpg|max:5120',
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
                'status'        => $request->status_stok,
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
        $user     = Auth::user();
        $viewPath = 'inventaris.show';

        $statusTampilan = $request->query('status');
        // dd($statusTampilan);

        $jumlahStok = 0;
        $statusStok = null;
        if ($statusTampilan === '1') {
            $jumlahStok = $inventaris->stocks()->where('status', 1)->count();
            $statusStok = 'aktif';
        } elseif ($statusTampilan === '0') {
            $jumlahStok = $inventaris->stocks()->where('status', 0)->count();
            $statusStok = 'tidak aktif';
        }
        // dd($inventaris->stocks);

        $inventaris->load([
            'detailPeminjaman.surat.user',
            'detailPeminjaman.surat.kegiatan',
        ]);

        $listPeminjam = $inventaris->detailPeminjaman
            ->map(fn ($detail) => $detail->surat?->user)
            ->filter()
            ->unique('id');
        // dd($listPeminjam);

        if ($user) {
            if ($user->role === 'admin_LM') {
                $viewPath = 'admin.inventaris.show';
            } elseif ($user->role === 'admin_dekanat') {
                $viewPath = 'dekanat.inventaris.show';
            }
        }

        return view($viewPath, compact('inventaris', 'jumlahStok', 'statusStok', 'listPeminjam'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventaris $inventaris)
    {
        $categories = Category::all();

        return view('admin.inventaris.edit', compact('inventaris', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventaris $inventaris)
    {
        $request->validate([
            'nama'        => 'required|string|max:255',
            'id_category' => 'required|exists:categories,id',
            'deskripsi'   => 'nullable|string',
            'stok_awal'   => 'nullable|integer|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $updateData = $request->except([
            '_token',
            '_method',
            'image',
            // 'stok_awal',
            // 'status_stok'
        ]);

        // MANAJEMEN FILE GAMBAR
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

            if ($inventaris->image) {
                $oldPath = str_replace('storage/', '', $inventaris->image);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            Storage::disk('public')->putFileAs('images', $file, $fileName);
            $updateData['image'] = 'storage/images/' . $fileName;
        } else {
            $updateData['image'] = $inventaris->image;
        }

        $inventaris->update($updateData);

        if ($request->filled('stok_awal')) {
            $tambahan = (int) $request->stok_awal;

            for ($i = 1; $i <= $tambahan; $i++) {
                Stock::create([
                    'id_inventaris' => $inventaris->id,
                    'status'        => 1,
                ]);
            }
        }

        return redirect()->route('admin.inventaris.show', $inventaris)
            ->with('success', "Data inventaris {$inventaris->nama} berhasil diperbarui!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventaris $inventaris)
    {
        DB::beginTransaction();

        try {
            $sedangDipinjam = DB::table('stocks')
                ->where('id_inventaris', $inventaris->id)
                ->where('status', 0)
                ->exists();

            if ($sedangDipinjam) {
                return redirect()->back()->with('error', "Gagal menghapus! Beberapa kepingan unit {$inventaris->nama} saat ini sedang aktif dipinjam oleh organisasi.");
            }

            if ($inventaris->image) {
                $imagePath = str_replace('storage/', '', $inventaris->image);
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }

            DB::table('detail_peminjaman')->where('id_inventaris', $inventaris->id)->delete();
            DB::table('stocks')->where('id_inventaris', $inventaris->id)->delete();

            $inventaris->delete();

            DB::commit();

            $routeRedirect = auth()->user()->role === 'dekanat' ? 'dekanat.inventaris.index' : 'admin.inventaris.index';

            return redirect()->route($routeRedirect)
                ->with('success', "Inventaris {$inventaris->nama} beserta seluruh kepingan unit dan riwayatnya berhasil dihapus permanen.");
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal menghapus inventaris: ' . $e->getMessage());
        }
    }
}