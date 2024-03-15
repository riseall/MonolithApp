<?php

namespace App\Http\Controllers;

use App\Exceptions\MyModelNotFoundException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('keywords');
        $user = User::where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')
            ->orWhere('role', 'like', '%' . $search . '%')
            ->get();

        return new JsonResponse(
            [
                'message' => 'Data User ditampilkan',
                'data' => $user
            ],
            Response::HTTP_OK
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:' . User::class,
            'password' => 'required', 'confirmed',
            'role' => 'required|string|max:255'
        ]);
        $createUser = User::query()->create($validateData);

        return response()->json([
            'message' => 'Berhasil Menambahkan Mahasiswa',
            'data' => $createUser
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::query()->find($id);

        if (empty($user)) {
            throw new MyModelNotFoundException('user');
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();

        return response()->json([
            'message' => 'Data user berhasil diupdate',
            'data' => $user
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::query()->find($id);
        if (empty($user)) {
            throw new MyModelNotFoundException('user');
        }

        $user->delete();
        return response()->json([
            'message' => 'Data User berhasil dihapus',
            'data' => $user
        ], Response::HTTP_OK);
    }
}
