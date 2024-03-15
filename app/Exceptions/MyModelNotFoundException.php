<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class MyModelNotFoundException extends Exception
{
    private string $model;

    private string $class;

    public function __construct(string $namaModel, $caller = null, private string|null $id = null)
    {
        parent::__construct('Model Not Found', Response::HTTP_NOT_FOUND);

        $this->model = $namaModel;
        $this->class = is_string($caller) ? $caller : 'Unknown Class';
    }

    public function render()
    {
        return response()->json([
            'message' => 'Model ' . $this->model . ' tidak ada'
        ], Response::HTTP_NOT_FOUND);
    }

    public function report()
    {
        Log::error('Model tidak ketemu, id dicari:' . $this->id . ', dipanggil dari:' . $this->class);
        return true;
    }
}
