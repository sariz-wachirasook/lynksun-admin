<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

class LinksController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try {

            return response()->json([
                'message' => 'Hello World'
            ], 200);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function show(string $id)
    {
        try {

            return response()->json([
                'message' => 'Hello World'
            ], 200);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function store(Request $request)
    {
        try {

            return response()->json([
                'message' => 'Hello World'
            ], 200);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function update(Request $request, string $id)
    {
        try {

            return response()->json([
                'message' => 'Hello World'
            ], 200);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function destroy(string $id)
    {
        try {

            return response()->json([
                'message' => 'Hello World'
            ], 200);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
}
