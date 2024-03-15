<?php

namespace App\Http\Controllers;

use App\Models\AbsenKeluar;
use App\Models\AbsenMasuk;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function masuk()
    {
        $id = Auth::user() ? Auth::user()->id : null;
        $data = AbsenMasuk::with('mahasiswa')->where('mahasiswa_id', '=', $id)->get();

        if (count($data) > 0) {
            return response()->json(['data' => $data]);
        } else {
            return response()->json(['message' => 'No data found']);
        }
    }
    public function keluar()
    {
        $id = Auth::user() ? Auth::user()->id : null;
        $data = AbsenKeluar::with('mahasiswa')->where('mahasiswa_id', '=', $id)->get();

        if (count($data) > 0) {
            return response()->json(['data' => $data]);
        } else {
            return response()->json(['message' => 'No data found']);
        }
    }
}
