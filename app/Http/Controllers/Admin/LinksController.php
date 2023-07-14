<?php

namespace App\Http\Controllers\Admin;

use App\Models\Links;
use Illuminate\Http\Request;

class LinksController extends Controller
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

        $items = Links::query();

        if ($search) {
            $items = $items->where("title", "LIKE", "%{$search}%");
        }

        if ($sort && $order) {
            $items = $items->orderBy($sort, $order);
        }

        $items = $items->paginate($per_page);

        return view('pages.admin.links.index', [
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
        return view('pages.admin.links.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required",
            "url" => "required",
        ]);

        $item = new Links();
        $item->title = $request->title;
        $item->url = $request->url;
        $item->save();

        return redirect()->route('admin.links.index')->with('success', 'Link created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Links::find($id);

        return view('pages.admin.links.show', [
            'item' => $item,
        ]);
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
        $item = Links::find($id);

        if ($item) {
            $item->delete();
        }

        return redirect()->route('admin.links.index')->with('success', 'Link deleted successfully.');
    }
}
