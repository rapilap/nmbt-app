<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Rent;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // private $cartItems = [];

    public function index()
    {
        // Mengambil semua data dari tabel 'carts'
        $cartItems = Cart::all();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        // Kirim data ke view
        return view('cart', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal
        ]);
    }

    public function destroy($id)
    {
        $cartItem = Cart::find($id); // Cari item berdasarkan ID
    
        if ($cartItem) {
            $cartItem->delete(); // Hapus item dari database
            return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
        }

        return redirect()->route('cart.index')->with('error', 'Item tidak ditemukan.');
    }

    public function update(Request $request,$id)
    {
        $cartItem = Cart::find($id);

        if ($cartItem) {
            if ($request->quantity < 1) {
                return redirect()->route('cart.index')->with('error', 'Jumlah barang tidak boleh kurang dari 1.');
            }
    
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
    
            return redirect()->route('cart.index')->with('success', 'Jumlah barang berhasil diperbarui.');
        }
    
        return redirect()->route('cart.index')->with('error', 'Item tidak ditemukan.');
    }

    public function calculatePrice(Request $request)
    {
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));
        $pricePerDay = 5000;

        if ($endDate->gte($startDate)) {
            $days = $startDate->diffInDays($endDate);
            $totalPrice = $days * $pricePerDay;
        } else {
            return back()->with('error', 'Tanggal akhir harus lebih besar atau sama dengan tanggal mulai.');
        }

        return view('cart.index', [
            'days' => $days,
            'totalPrice' => $totalPrice,
        ]);
    }

}
