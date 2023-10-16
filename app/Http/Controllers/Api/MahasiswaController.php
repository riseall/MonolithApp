<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\MyModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMahasiswaRequest;
use App\Http\Requests\UpdateMahasiswaRequest;
use App\Models\Mahasiswa;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Storage;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::all();
        return new JsonResponse(
            [
                'message' => 'Data Mahasiswa',
                'data' => $mahasiswa
            ],
            Response::HTTP_OK
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMahasiswaRequest $request)
    {

        $validateData = $request->validated();
        $createdMahasiswa = Mahasiswa::query()->create($validateData);

        // Inisialisasi variabel $fileNama
        $fileNama = null;

        //Unggah foto dan simpan referensi
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fileNama = $foto->getClientOriginalName();
            $foto->move(public_path('foto_mahasiswa'), $fileNama);
        }

        //Simpan referensi foto pada database
        $createdMahasiswa->update(['foto' => 'foto_mahasiswa/' . $fileNama]);

        return response()->json([
            'message' => 'Berhasil Menambahkan Mahasiswa',
            'data' => $createdMahasiswa
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $mahasiswa = Mahasiswa::query()->find($id);
        if (empty($mahasiswa)) {
            throw new MyModelNotFoundException('mahasiswa');
        }

        return response()->json([
            'message' => 'Data Mahasiswa',
            'data' => $mahasiswa
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMahasiswaRequest $request, string $id)
    {
        $mahasiswa = Mahasiswa::query()->find($id);
        if (empty($mahasiswa)) {
            throw new MyModelNotFoundException('mahasiswa');
        }

        $mahasiswa->update($request->safe()->all());
        return response()->json([
            'message' => 'Data Mahasiswa berhasil diupdate',
            'data' => $mahasiswa
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mahasiswa = Mahasiswa::query()->find($id);
        if (empty($mahasiswa)) {
            throw new MyModelNotFoundException('mahasiswa');
        }

        $mahasiswa->delete();
        return response()->json([
            'message' => 'Data Mahasiswa berhasil dihapus',
            'data' => $mahasiswa
        ], Response::HTTP_OK);
    }
}