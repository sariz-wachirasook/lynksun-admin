<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Links;
use App\Models\LinkVisitLogs;
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
            // TODO: parameter
            $perPage = $request->get('per_page', 10) ?? $this->perPage;

            $items = Links::query()->select([
                'links.id',
                'links.url',
                'links.short_url',
                DB::raw('COUNT(link_visit_logs.id) as visit_count'),
            ])->leftJoin('link_visit_logs', 'link_visit_logs.link_id', '=', 'links.id')
                ->groupBy('links.id')
                ->orderBy('links.id', 'desc');

            $items = $items->paginate($perPage);

            return response()->json($items, 200);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function show(string $id)
    {
        try {
            $item = Links::query()->select([
                'links.id',
                'links.url',
                'links.short_url',
                'links.created_at',
                'links.updated_at',
                DB::raw('COUNT(link_visit_logs.id) as visit_count'),  
            ])->leftJoin('link_visit_logs', 'link_visit_logs.link_id', '=', 'links.id')
                ->groupBy('links.id')
                ->findOrFail($id);

            return response()->json($item, 200);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function open(string $shortUrl)
    {
        try {
            $link = Links::where('short_url', $shortUrl)->firstOrFail();

            LinkVisitLogs::create([
                'link_id' => $link->id,
                'ip' => request()->ip(),
            ]);

            return redirect($link->url);
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
            // TODO: only members can update their own links
            // 

            $request->validate([
                'url' => 'required|url',
            ]);

            $link = Links::findOrFail($id);

            $link->update([
                'url' => $request->url,
            ]);

            return response()->json($link, 200);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function destroy(string $id)
    {
        try {
            // TODO: only members can delete their own links
            // 

            $link = Links::findOrFail($id);

            $link->delete();

            return response()->json([
                'message' => 'Link deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    private function shortenUrl()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $length = 8;
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
