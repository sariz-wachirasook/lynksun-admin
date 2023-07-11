<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\LinkVisitLogs;
use Illuminate\Http\Request;

class LinkVisitLogsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @OA\Get(
     *      path="/api/v1/link-visit-logs",
     *      operationId="getLinkVisitLogsList",
     *      tags={"LinkVisitLogs"},
     *      summary="Get list of link visit logs",
     *      description="Returns list of link visit logs",
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
            $perPage = $request->get('per_page', 10) ?? $this->perPage;

            $items = LinkVisitLogs::query()->paginate($perPage);

            return response()->json($items, 200);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/link-visit-logs/{id}",
     *      operationId="getLinkVisitLogsById",
     *      tags={"LinkVisitLogs"},
     *      summary="Get link visit logs information",
     *      description="Returns link visit logs data",
     *      @OA\Parameter(
     *          name="id",
     *          description="LinkVisitLogs Id",
     *          required=true,
     *          in="path",
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
            $item = LinkVisitLogs::query()->find($id);

            if (!$item) {
                return response()->json([
                    'message' => 'not found'
                ], 404);
            }

            return response()->json($item, 200);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
}
