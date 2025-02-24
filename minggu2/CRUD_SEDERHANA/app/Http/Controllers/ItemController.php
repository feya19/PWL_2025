<?php

namespace App\Http\Controllers; // Menentukan namespace controller

use App\Models\Item; // Mengimpor model Item
use Illuminate\Http\RedirectResponse; // Mengimpor kelas RedirectResponse
use Illuminate\Http\Request; // Mengimpor kelas Request
use Illuminate\View\View; // Mengimpor kelas View

class ItemController extends Controller // Mendefinisikan kelas ItemController yang merupakan turunan dari Controller
{
    public function index(): View // Menampilkan daftar semua item
    {
        $items = Item::all(); // Mengambil semua item dari database
        return view('items.index', compact('items')); // Menampilkan tampilan 'items.index' dan mengirimkan variabel $items
    }

    public function create(): View // Menampilkan formulir untuk membuat item baru
    {
        return view('items.create'); // Menampilkan tampilan 'items.create'
    }

    public function store(Request $request): RedirectResponse // Menyimpan item yang baru dibuat
    {
        $request->validate([ // Memvalidasi data formulir
            'name' => 'required', // Field 'name' harus diisi
            'description' => 'required', // Field 'description' harus diisi
        ]);

        Item::create($request->only(['name', 'description'])); // Membuat item baru berdasarkan data formulir
        return redirect()->route('items.index')->with('success', 'Item berhasil ditambahkan.'); // Mengarahkan kembali ke halaman indeks dengan pesan sukses
    }

    public function show(Item $item): View // Menampilkan detail item tertentu
    {
        return view('items.show', compact('item')); // Menampilkan tampilan 'items.show' dan mengirimkan variabel $item
    }

    public function edit(Item $item): View // Menampilkan formulir untuk mengedit item tertentu
    {
        return view('items.edit', compact('item')); // Menampilkan tampilan 'items.edit' dan mengirimkan variabel $item
    }

    public function update(Request $request, Item $item): RedirectResponse // Memperbarui item yang dipilih
    {
        $request->validate([ // Memvalidasi data formulir
            'name' => 'required', // Field 'name' harus diisi
            'description' => 'required', // Field 'description' harus diisi
        ]);

        $item->update($request->only(['name', 'description'])); // Memperbarui item berdasarkan data formulir
        return redirect()->route('items.index')->with('success', 'Item berhasil diperbarui.'); // Mengarahkan kembali ke halaman indeks dengan pesan sukses
    }

    public function destroy(Item $item): RedirectResponse // Menghapus item yang dipilih
    {
       $item->delete(); // Menghapus item dari database
       return redirect()->route('items.index')->with('success', 'Item berhasil dihapus.'); // Mengarahkan kembali ke halaman indeks dengan pesan sukses
    }
}
