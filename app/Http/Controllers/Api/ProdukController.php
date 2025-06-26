<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        return response()->json(Produk::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'kategori' => 'nullable|string',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
        ]);

        $produk = Produk::create($request->all());
        return response()->json(['message' => 'Produk berhasil ditambahkan', 'data' => $produk], 201);
    }

    public function show($id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }
        return response()->json($produk);
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        $produk->update($request->all());
        return response()->json(['message' => 'Produk berhasil diperbarui', 'data' => $produk]);
    }

    public function destroy($id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        $produk->delete();
        return response()->json(['message' => 'Produk berhasil dihapus']);
    }
}
