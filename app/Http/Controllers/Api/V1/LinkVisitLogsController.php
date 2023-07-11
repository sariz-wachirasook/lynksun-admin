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

    public function show(string $id)
    {
        try {
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
}
