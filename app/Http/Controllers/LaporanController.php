<?php

namespace App\Http\Controllers;

use App\Exceptions\MyModelNotFoundException;
use App\Http\Requests\StorelaporanRequest;
use App\Http\Requests\UpdatelaporanRequest;
use App\Models\laporan;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $laporan = laporan::with('mahasiswa')->get();

        return new JsonResponse(
            [
                'message' => 'Data Laporan',
                'data' => $laporan
            ],
            Response::HTTP_OK
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorelaporanRequest $request)
    {
        $validateData = $request->validated();
        $validateData['mahasiswa_id'] = $request->get('mahasiswa_id');
        $createLaporan = laporan::query()->create($validateData);

        // Inisialisasi variabel $fileNama
        $fileNama = null;

        //Unggah foto dan simpan referensi
        if ($request->hasFile('laporan')) {
            $file = $request->file('laporan');
            $fileNama = $file->getClientOriginalName();
            $file->move(public_path('data_laporan'), $fileNama);
        }

        //Simpan referensi foto pada database
        $createLaporan->update(['laporan' => 'data_laporan/' . $fileNama]);

        return response()->json([
            'message' => 'Berhasil Menambahkan Laporan',
            'data' => $createLaporan
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $laporan = laporan::query()->find($id);
        if (empty($laporan)) {
            throw new MyModelNotFoundException('laporan');
        }

        return response()->json([
            'message' => 'Data Laporan',
            'data' => $laporan
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(laporan $laporan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatelaporanRequest $request, laporan $laporan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $laporan = laporan::query()->find($id);
        if (empty($laporan)) {
            throw new MyModelNotFoundException('laporan');
        }

        $laporan->delete();
        return response()->json([
            'message' => 'Data laporan berhasil dihapus',
            'data' => $laporan
        ], Response::HTTP_OK);
    }
}
