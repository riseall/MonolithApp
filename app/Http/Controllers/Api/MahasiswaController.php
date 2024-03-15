<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\MyModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMahasiswaRequest;
use App\Http\Requests\UpdateMahasiswaRequest;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('keywords');
        $mahasiswa = Mahasiswa::where('nama', 'like', '%' . $search . '%')
            ->orWhere('nim', 'like', '%' . $search . '%')
            ->orWhere('kelas', 'like', '%' . $search . '%')
            ->get();
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
        $validateData['user_id'] = $request->get('user_id');
        $createdMahasiswa = Mahasiswa::query()->create($validateData);

        // Inisialisasi variabel $fileNama
        $fileNama = null;

        //Unggah foto dan simpan referensi
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fileNama = $foto->getClientOriginalName();
            $foto->move(public_path('foto_mahasiswa'), $fileNama);
        } else {
            $fileNama = 'pas_foto_kosong.png';
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

        // Inisialisasi variabel $fileNama
        $fileNama = null;

        //Unggah foto dan simpan referensi
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fileNama = $foto->getClientOriginalName();
            $foto->move(public_path('foto_mahasiswa'), $fileNama);
        } else {
            $mahasiswa->foto;
        }

        //Simpan referensi foto pada database
        $mahasiswa->update(['foto' => 'foto_mahasiswa/' . $fileNama]);

        if (empty($mahasiswa)) {
            throw new MyModelNotFoundException('mahasiswa');
        }

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

        // Hapus file foto jika ada
        if (!empty($mahasiswa->foto)) {
            $filePath = public_path($mahasiswa->foto);
            if (File::exists($filePath)) {
                if (basename($filePath) !== 'pas_foto_kosong.png') {
                    File::delete($filePath);
                }
            }
        }

        $mahasiswa->delete();
        return response()->json([
            'message' => 'Data Mahasiswa berhasil dihapus',
            'data' => $mahasiswa
        ], Response::HTTP_OK);
    }
}