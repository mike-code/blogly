<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function get(\Illuminate\Http\Request $request)
    {
        $entries = \App\Models\BlogEntry::orderBy('created_at', 'desc')->paginate(10);

        return response()->json($entries);
    }

    public function delete(\Illuminate\Http\Request $request, string $id)
    {
        \App\Models\BlogEntry::destroy($id);
    }

    public function add(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'title'        => 'required|max:255',
            'content'      => 'required',
        ]);

        \App\Models\BlogEntry::create([
            'author_id'    => (int)\Auth::user()->id,
            'author_name'  => \Auth::user()->name,
            'title'        => $request->title,
            'content'      => $request->content,
            'is_published' => (bool)$request->is_published ?? false,
        ]);
    }
}
