<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->query("search");
        $sort = request()->query("sort");
        $order = request()->query("order");
        $per_page = request()->query("per_page") ?? 10;

        $items = User::query();

        if ($search) {
            $items = $items->where("name", "LIKE", "%{$search}%");
        }

        if ($sort && $order) {
            $items = $items->orderBy($sort, $order);
        }

        $items = $items->paginate($per_page);

        return view('pages.admin.users.index', [
            'items' => $items,
            'search' => $search,
            'sort' => $sort,
            'order' => $order,
            'per_page' => $per_page,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
