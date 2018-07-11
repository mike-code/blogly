<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function getAll()
    {
        $entries = \App\Models\BlogEntry::orderBy('created_at', 'desc')->paginate(10);

        return response()->json($entries);
    }

    public function get(string $id)
    {
        $entry = \App\Models\BlogEntry::find($id);

        return response()->json($entry);
    }

    public function delete(\Illuminate\Http\Request $request, string $id)
    {
        \App\Models\BlogEntry::destroy($id);

        return response(null, 204);
    }

    public function update(\Illuminate\Http\Request $request, string $id)
    {
        $entry = \App\Models\BlogEntry::find($id);
        $data = collect($request)->only(['is_published'])->toArray();
        $entry->update($data);
    }

    public function add(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'title'        => 'required|max:255',
            'content'      => 'required',
        ]);

        $entry = \App\Models\BlogEntry::create([
            'author_id'    => (int)\Auth::user()->id,
            'author_name'  => \Auth::user()->name,
            'title'        => $request->title,
            'content'      => $request->content,
            'is_published' => (bool)$request->is_published ?? false,
        ]);

        return response()->json($entry, 201);
    }
}
