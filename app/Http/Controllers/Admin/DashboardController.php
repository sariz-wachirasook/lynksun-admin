<?php

namespace App\Http\Controllers\Admin;

use App\Models\Links;
use App\Models\LinkVisitLogs;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __invoke()
    {
        $total_users = User::count();
        $total_links = Links::count();
        $total_visits = LinkVisitLogs::count();

        return view('pages.admin.dashboard.index', [
            'total_users' => $total_users,
            'total_links' => $total_links,
            'total_visits' => $total_visits,
        ]);
    }
}
