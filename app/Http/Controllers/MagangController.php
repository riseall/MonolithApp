<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoremagangRequest;
use App\Http\Requests\UpdatemagangRequest;
use App\Models\magang;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\MyModelNotFoundException;

class MagangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $magang = magang::with('mahasiswa', 'perusahaan', 'dosen', 'laporan')->get();

        return new JsonResponse([
            'message' => 'Berhasil Menampilkan data Magang',
            'data' => $magang
        ]);
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
    public function store(StoremagangRequest $request)
    {
        $validateData = $request->validated();
        $magang = magang::query()->create($validateData);

        return response()->json([
            'message' => 'Berhasil Menambahkan Data Magang',
            'data' => $magang
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $magang = magang::query()->find($id);

        return response()->json([
            'message' => 'Data Magang',
            'data' => $magang
        ], Response::HTTP_OK);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatemagangRequest $request, string $id)
    {
        $magang = magang::query()->find($id);
        if (empty($magang)) {
            throw new MyModelNotFoundException('magang');
        }

        $magang->update($request->safe()->all());
        return response()->json([
            'message' => 'Data Magang berhasil diupdate',
            'data' => $magang
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $magang = magang::query()->find($id);
        if (empty($magang)) {
            throw new MyModelNotFoundException('magang');
        }

        $magang->delete();
        return response()->json([
            'message' => 'Data Magang berhasil dihapus',
            'data' => $magang
        ], Response::HTTP_OK);
    }
}
