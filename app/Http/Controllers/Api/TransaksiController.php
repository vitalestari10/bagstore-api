<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produks,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $total = 0;
            $items = [];

            foreach ($request->items as $item) {
                $produk = \App\Models\Produk::find($item['produk_id']);
                $subtotal = $produk->harga * $item['qty'];
                $total += $subtotal;

                $items[] = [
                    'produk_id' => $produk->id,
                    'qty' => $item['qty'],
                    'subtotal' => $subtotal,
                ];
            }

            $transaksi = Transaksi::create([
                'kode' => 'TRX' . time(),
                'user_id' => auth()->id(),
                'tanggal' => Carbon::now(),
                'total' => $total,
            ]);

            foreach ($items as $item) {
                $item['transaksi_id'] = $transaksi->id;
                TransaksiDetail::create($item);
            }

            DB::commit();
            return response()->json(['message' => 'Transaksi berhasil disimpan', 'data' => $transaksi], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal simpan transaksi', 'error' => $e->getMessage()], 500);
        }
    }
}
