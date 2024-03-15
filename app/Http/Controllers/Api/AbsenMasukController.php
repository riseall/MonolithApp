<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\MyModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAbsenMasukRequest;
use App\Http\Requests\UpdateAbsenMasukRequest;
use App\Models\AbsenMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AbsenMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('key');
        $absenmasuk = AbsenMasuk::where('hari', 'like', '%' . $search . '%')
            ->orWhere('tanggal', 'like', '%' . $search . '%')
            ->orWhere('waktu', 'like', '%' . $search . '%')
            ->orWhere('lokasi', 'like', '%' . $search . '%')
            ->with(['mahasiswa' => function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            }])
            ->get();

        return new JsonResponse(
            [
                'message' => 'Data Absensi',
                'data' => $absenmasuk
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
    public function store(StoreAbsenMasukRequest $request)
    {
        $validate = $request->validated();
        // Mendapatkan user yang sedang login
        // $user = Auth::user();
        // Menambahkan user_id ke data yang akan disimpan
        $validate['mahasiswa_id'] = $request->get('mahasiswa_id');
        $createdAbsen = AbsenMasuk::query()->create($validate);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = time() . '.' . $foto->getClientOriginalName();
            $foto->move(public_path('foto_absen'), $filename);
        }

        $createdAbsen->update(['foto' => 'foto_absen/' . $filename]);

        return response()->json([
            'message' => 'Berhasil menambahkan Data',
            'data' => $createdAbsen
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(AbsenMasuk $absenMasuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AbsenMasuk $absenMasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAbsenMasukRequest $request, AbsenMasuk $absenMasuk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $absenMasuk = AbsenMasuk::query()->find($id);
        if (empty($absenMasuk)) {
            throw new MyModelNotFoundException('mahasiswa');
        }

        $absenMasuk->delete();
        return response()->json([
            'message' => 'Data Absen Masuk berhasil dihapus',
            'data' => $absenMasuk
        ], Response::HTTP_OK);
    }
}
