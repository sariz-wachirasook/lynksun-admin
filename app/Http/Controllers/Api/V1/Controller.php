<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @OA\Info(
     *      version="1.0.0",
     *      x={
     *          "logo": {
     *              "url": "https://via.placeholder.com/190x90.png?text=L5-Swagger"
     *          }
     *      },
     *      title="L5 OpenApi",
     *      description="L5 Swagger OpenApi description",
     *      @OA\Contact(
     *          email="sariz.wachirasook@gmail.com"
     *      ),
     *     @OA\License(
     *         name="Apache 2.0",
     *         url="https://www.apache.org/licenses/LICENSE-2.0.html"
     *     )
     * )
     */
    public function __construct(
        public $perPage = 10
    ) {
    }

    public function exceptionResponse($e)
    {
        if (isset($e->status)) {
            if ($e->status == 422) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        return response()->json([
            'message' => "Internal Server Error"
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
