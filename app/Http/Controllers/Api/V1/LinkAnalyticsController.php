<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Links;
use App\Models\LinkVisitLogs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location;

class LinkAnalyticsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTotalVisitCount(Request $request)
    {
        try {
            $user = $request->user();
            $totalVisitCount = LinkVisitLogs::query()->count();

            if ($user) {
                $totalVisitCount = LinkVisitLogs::query()->where('links.user_id', $user->id)
                    ->join('links', 'links.id', '=', 'link_visit_logs.link_id')
                    ->count();
            }

            return response()->json([
                'total_visit_count' => $totalVisitCount,
            ], 200);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function getTotalVisitsByDate(Request $request)
    {
        try {
            $user = $request->user();
            $visits = [];

            for ($i = 0; $i <= 365; $i++) {
                $date = Carbon::now()->subDays(365 - $i)->format('Y-m-d');

                $visits[$i] = LinkVisitLogs::query()->select([
                    DB::raw('COUNT(link_visit_logs.id) as count'),
                ])
                    ->whereDate('link_visit_logs.created_at', $date)
                    ->join('links', 'links.id', '=', 'link_visit_logs.link_id')
                    ->where('links.user_id', $user->id)
                    ->first();

                $visits[$i]['date'] = $date;
            }

            return response()->json($visits, 200);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function getMostVisitedLinks(Request $request)
    {
        try {
            $user = $request->user();
            $perPage = $request->get('per_page', 10) ?? $this->perPage;

            $items = Links::query()->select([
                'links.id',
                'links.url',
                'links.name',
                'links.short_url',
                DB::raw('COUNT(link_visit_logs.id) as visit_count'),
            ])->leftJoin('link_visit_logs', 'link_visit_logs.link_id', '=', 'links.id')
                ->groupBy('links.id')
                ->orderBy('visit_count', 'desc');

            if ($user) {
                $items = $items->where('links.user_id', $user->id);
            }

            $items = $items->paginate($perPage);

            return response()->json($items, 200);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
}
