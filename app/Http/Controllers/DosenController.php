<?php

namespace App\Http\Controllers;

use App\Exceptions\MyModelNotFoundException;
use App\Http\Requests\StoredosenRequest;
use App\Http\Requests\UpdatedosenRequest;
use App\Models\dosen;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('keywords');
        $dosen = dosen::where('nama', 'like', '%' . $search . '%')
            ->orWhere('nip', 'like', '%' . $search . '%')
            ->orWhere('alamat', 'like', '%' . $search . '%')
            ->get();

        return new JsonResponse(
            [
                'message' => 'Data dosen ditampilkan',
                'data' => $dosen
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
    public function store(StoredosenRequest $request)
    {
        $validateData = $request->validated();
        $createLaporan = dosen::query()->create($validateData);

        return response()->json([
            'message' => 'Berhasil Menambahkan Laporan',
            'data' => $createLaporan
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(dosen $dosen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(dosen $dosen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatedosenRequest $request, string $id)
    {
        $dosen = dosen::query()->find($id);

        if (empty($dosen)) {
            throw new MyModelNotFoundException('dosen');
        }

        $dosen->nip = $request->nip;
        $dosen->nama = $request->nama;
        $dosen->telepon = $request->telepon;
        $dosen->alamat = $request->alamat;
        $dosen->save();

        return response()->json([
            'message' => 'Data dosen berhasil diupdate',
            'data' => $dosen
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dosen = dosen::query()->find($id);
        if (empty($dosen)) {
            throw new MyModelNotFoundException('dosen');
        }

        $dosen->delete();
        return response()->json([
            'message' => 'Data dosen berhasil dihapus',
            'data' => $dosen
        ], Response::HTTP_OK);
    }
}
