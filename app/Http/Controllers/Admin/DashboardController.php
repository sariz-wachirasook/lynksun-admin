<?php

namespace App\Http\Controllers\Admin;

use App\Models\Links;
use App\Models\LinkVisitLogs;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function __invoke()
    {
        $total_users = User::count();
        $total_links = Links::count();
        $total_visits = LinkVisitLogs::count();
        $today_visits = LinkVisitLogs::whereDate('created_at', today())->count();

        return view('pages.admin.dashboard.index', [
            'total_users' => $total_users,
            'total_links' => $total_links,
            'total_visits' => $total_visits,
            'today_visits' => $today_visits,
        ]);
    }

    public function getChartData(Request $request)
    {
        $visits = [];

        for ($i = 0; $i <= 31; $i++) {
            $date = Carbon::now()->subDays(31 - $i)->format('Y-m-d');

            $visits[$i] = LinkVisitLogs::query()->select([
                DB::raw('COUNT(link_visit_logs.id) as count'),
            ])
                ->whereDate('link_visit_logs.created_at', $date)
                ->first();

            $visits[$i]['date'] = $date;
        }

        return response()->json([
            'items' => $visits
        ]);
    }
}
