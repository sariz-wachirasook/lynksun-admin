<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Links;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location;

class LinksController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
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
            $request->validate([
                'url' => 'required|url',
            ]);

            $user = $request->user();
            $shortUrl = $this->shortenUrl();
            $expiresAt = now()->addHours(24);

            $link = Links::create([
                'url' => $request->url,
                'short_url' => $shortUrl,
                'expires_at' => $user ? null : $expiresAt,
                'user_id' => $user ? $user->id : null,
            ]);


            return response()->json($link, 200);
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

    private function shortenUrl()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $length = 6;
        $shortUrl = '';

        // Generate a random string with specified length
        for ($i = 0; $i < $length; $i++) {
            $randomIndex = rand(0, strlen($characters) - 1);
            $shortUrl .= $characters[$randomIndex];
        }

        // Check if the generated short URL already exists in the database
        // If it exists, recursively call the method to generate a new one
        if (Links::where('short_url', $shortUrl)->exists()) {
            return $this->shortenUrl();
        }

        return $shortUrl;
    }
}
