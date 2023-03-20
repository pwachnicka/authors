<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function showAllAuthors()
    {
        return response()->json(Author::all());
    }

    public function showOneAuthor(int $id)
    {
        return response()->json(Author::find($id));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|alpha',
            'email' => 'required|email|unique:authors',
            'location' => 'required|alpha',
            'latest_article_published' => 'required'
        ]);

        $author = Author::create($request->all());
        return response()->json($author, 201);
    }

    public function update(int $id, Request $request)
    {
        $author = Author::findOrFail($id);
        $author->update($request->all());

        return response()->json($author, 200);
    }

    public function delete(int $id)
    {
        Author::findOrFail($id)->delete();
        return response('Delete succesfully', 200);
    }
}
