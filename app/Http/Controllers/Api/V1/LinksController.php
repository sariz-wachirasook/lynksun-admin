<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Links;
use App\Models\LinkVisitLogs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location;

class LinksController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @OA\Get(
     *      path="/api/v1/links",
     *      operationId="getLinksList",
     *      tags={"Links"},
     *      summary="Get list of links",
     *      description="Returns list of links",
     *      security={
     *         {"bearer": {}}
     *      },
     *      @OA\Parameter(
     *          name="per_page",
     *          description="Number of items per page",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *              default=10
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *       @OA\Response(
     *          response=500,
     *          description="Internal Server Error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Internal Server Error"
     *              )
     *          )
     *       )
     *     )
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();

            $perPage = $request->get('per_page', 10) ?? $this->perPage;
            $search = $request->get('search', null);

            $items = Links::query()->select([
                'links.id',
                'links.url',
                'links.name',
                'links.short_url',
                DB::raw('COUNT(link_visit_logs.id) as visit_count'),
            ])->leftJoin('link_visit_logs', 'link_visit_logs.link_id', '=', 'links.id')
                ->groupBy('links.id')
                ->orderBy('links.id', 'desc');

            if ($search) {
                $items = $items
                    ->where('links.name', 'like', '%' . $search . '%');
            }

            if ($user) {
                $items = $items->where('links.user_id', $user->id);
            }

            $items = $items->paginate($perPage);

            return response()->json($items, 200);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/links/{id}",
     *      operationId="getLinkById",
     *      tags={"Links"},
     *      summary="Get link information",
     *      description="Returns link data",
     *      security={
     *         {"bearer": {}}
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          description="Link ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              default=1
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *       @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Not Found"
     *              )
     *          )
     *       ),
     *       @OA\Response(
     *          response=500,
     *          description="Internal Server Error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Internal Server Error"
     *              )
     *          )
     *       )
     *     )
     */
    public function show(string $id)
    {
        try {
            $user = request()->user();

            $item = Links::query()->select([
                'links.id',
                'links.name',
                'links.url',
                'links.short_url',
                'links.created_at',
                'links.updated_at',
                'links.user_id',
                DB::raw('COUNT(link_visit_logs.id) as visit_count'),
            ])->leftJoin('link_visit_logs', 'link_visit_logs.link_id', '=', 'links.id')
                ->groupBy('links.id')
                ->find($id);

            if ($user && $item && $item->user_id !== $user->id) {
                return response()->json(['message' => 'Not Found'], 404);
            }

            if ($user === null && $item->user_id !== null) {
                return response()->json(['message' => 'Not Found'], 404);
            }

            if (!$item) {
                return response()->json(['message' => 'Not Found'], 404);
            }

            return response()->json($item, 200);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/links/{id}/visits",
     *      operationId="getLinkVisits",
     *      tags={"Links"},
     *      summary="Get Summary of link visits",
     *      description="Get Summary of link visits",
     *      security={
     *         {"bearer": {}}
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          description="Link ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              default=1
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *       @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Not Found"
     *              )
     *          )
     *       ),
     *       @OA\Response(
     *          response=500,
     *          description="Internal Server Error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Internal Server Error"
     *              )
     *          )
     *       )
     *     )
     */
    public function visits(string $id)
    {
        try {
            $visits = [];

            // for 30 days check each
            for ($i = 0; $i <= 7; $i++) {
                $date = Carbon::now()->subDays(7 - $i)->format('Y-m-d');

                $visits[$i] = LinkVisitLogs::query()->select([
                    DB::raw('COUNT(link_visit_logs.id) as count'),
                ])->where('link_id', $id)
                    ->whereDate('created_at', $date)
                    ->first();

                $visits[$i]['date'] = $date;
            }

            return response()->json($visits, 200);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/links/open/{shortUrl}",
     *      operationId="openLink",
     *      tags={"Links"},
     *      summary="Open link",
     *      description="Redirects to the original link",
     *      @OA\Parameter(
     *          name="shortUrl",
     *          description="Short URL",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *              default="http://localhost:8000/abc123"
     *          )
     *      ),
     *      @OA\Response(
     *          response=302,
     *          description="Redirect to the original link",
     *       ),
     *       @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Not Found"
     *              )
     *          )
     *       ),
     *       @OA\Response(
     *          response=500,
     *          description="Internal Server Error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Internal Server Error"
     *              )
     *          )
     *       )
     *     )
     */
    public function open(string $shortUrl)
    {
        try {
            $link = Links::where('short_url', $shortUrl)->first();

            // if not found, return 404
            if (!$link) {
                return response()->json(['message' => 'Not Found'], 404);
            }

            // if expired, return 404
            if ($link->expired_at && $link->expired_at < Carbon::now()) {
                return response()->json(['message' => 'Not Found'], 404);
            }

            LinkVisitLogs::create([
                'link_id' => $link->id,
                'ip' => request()->ip(),
            ]);

            return redirect($link->url);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/links",
     *      operationId="createLink",
     *      tags={"Links"},
     *      summary="Create link",
     *      description="Returns link data",
     *      security={
     *         {"bearer": {}}
     *      },
     *      @OA\RequestBody(
     *          required=true,
     *          description="Link data",
     *          @OA\JsonContent(
     *              required={"url"},
     *              @OA\Property(
     *                  property="url",
     *                  type="string",
     *                  example="https://www.google.com"
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *       @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Not Found"
     *              )
     *          )
     *       ),
     *       @OA\Response(
     *          response=500,
     *          description="Internal Server Error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Internal Server Error"
     *              )
     *          )
     *       )
     *     )
     */
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
                'name' => $request->name ?? null,
                'expires_at' => $user ? null : $expiresAt,
                'user_id' => $user ? $user->id : null,
            ]);

            return response()->json($link, 200);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    /**
     * @OA\Put(
     *      path="/api/v1/links/{id}",
     *      operationId="updateLink",
     *      tags={"Links"},
     *      summary="Update link",
     *      description="Returns link data",
     *      security={
     *         {"bearer": {}}
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          description="Link ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *              default="1"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Link data",
     *          @OA\JsonContent(
     *              required={"url"},
     *              @OA\Property(
     *                  property="url",
     *                  type="string",
     *                  example="https://www.google.com"
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *       @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Not Found"
     *              )
     *          )
     *       ),
     *       @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="errors",
     *                  type="object",
     *                  example={
     *                      "url": {
     *                          "The url format is invalid."
     *                      }
     *                  }
     *              )
     *          )
     *       ),
     *       @OA\Response(
     *          response=500,
     *          description="Internal Server Error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Internal Server Error"
     *              )
     *          )
     *       )
     *    )
     */
    public function update(Request $request, string $id)
    {
        try {
            // TODO: only members can update their own links
            // 

            $request->validate([
                'url' => 'required|url',
            ]);

            $link = Links::find($id);

            if (!$link) {
                return response()->json(['message' => 'Not Found'], 404);
            }

            $link->update([
                'url' => $request->url,
            ]);

            if ($request->name) {
                $link->update([
                    'name' => $request->name,
                ]);
            }

            $item = Links::query()->select([
                'links.id',
                'links.name',
                'links.url',
                'links.short_url',
                'links.created_at',
                'links.updated_at',
                'links.user_id',
                DB::raw('COUNT(link_visit_logs.id) as visit_count'),
            ])->leftJoin('link_visit_logs', 'link_visit_logs.link_id', '=', 'links.id')
                ->groupBy('links.id')
                ->find($id);

            return response()->json($item, 200);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/links/{id}",
     *      operationId="deleteLink",
     *      tags={"Links"},
     *      summary="Delete link",
     *      description="Returns success message",
     *      security={
     *         {"bearer": {}}
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          description="Link ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *              default="1"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *       @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Not Found"
     *              )
     *          )
     *       ),
     *       @OA\Response(
     *          response=500,
     *          description="Internal Server Error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Internal Server Error"
     *              )
     *          )
     *       )
     *     )
     */
    public function destroy(string $id)
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return response()->json(['message' => 'Not Found'], 404);
            }

            $link = Links::findOrFail($id);

            $link->delete();

            return response()->json([
                'message' => 'Link deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/links/{slug}",
     *      operationId="showLinkBySlug",
     *      tags={"Links"},
     *      summary="Get link by slug",
     *      description="Returns link data",
     *      @OA\Parameter(
     *          name="slug",
     *          description="Link slug",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *              default="1"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="url",
     *                  type="string",
     *                  example="https://www.google.com"
     *              )
     *          )
     *       ),
     *       @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Not Found"
     *              )
     *          )
     *       ),
     *       @OA\Response(
     *          response=500,
     *          description="Internal Server Error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Internal Server Error"
     *              )
     *          )
     *       )
     *     )
     */
    public function showBySlug(string $slug)
    {
        try {
            $link = Links::where('short_url', $slug)->first();

            if (!$link) {
                return response()->json(['message' => 'Not Found'], 404);
            }

            LinkVisitLogs::create([
                'link_id' => $link->id,
                'ip' => request()->ip(),
            ]);

            return response()->json([
                'url' => $link->url,
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

        for ($i = 0; $i < $length; $i++) {
            $randomIndex = rand(0, strlen($characters) - 1);
            $shortUrl .= $characters[$randomIndex];
        }

        if (Links::where('short_url', $shortUrl)->exists()) {
            return $this->shortenUrl();
        }

        return $shortUrl;
    }
}
