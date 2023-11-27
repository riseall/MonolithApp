<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAbsenMasukRequest;
use App\Http\Requests\UpdateAbsenMasukRequest;
use App\Models\AbsenMasuk;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AbsenMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $absenmasuk = AbsenMasuk::all();

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
    public function destroy(AbsenMasuk $absenMasuk)
    {
        //
    }
}
