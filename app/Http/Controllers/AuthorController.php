<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function showAllAuthors()
    {
        return response()->json(Author::all());
    }

    public function showOneAuthor(int $id)
    {
        $author = Author::find($id);

        if ($author === null) {
            return response()->json(['error' => 'Author not found!'], 404);
        }
        return response()->json(Author::find($id));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:authors|max:255',
            'github' => 'required|max:255',
            'twitter' => 'required|max:255',
            'location' => 'required|max:255',
            'latest_article_published' => 'required|max:255'
        ]);

        $author = Author::create($request->all());
        return response()->json($author, 201);
    }

    public function update(int $id, Request $request)
    {
        $this->validate($request, [
            'name' => 'max:255',
            'email' => 'email|unique:authors|max:255',
            'github' => 'max:255',
            'twitter' => 'max:255',
            'location' => 'max:255',
            'latest_article_published' => 'max:255'
        ]);

        $author = Author::findOrFail($id);
        $author->update($request->all());

        return response()->json($author, 200);
    }

    public function delete(int $id)
    {
        Author::findOrFail($id)->delete();
        return response()->json(['message' => 'Delete succesfully'], 200);
    }
}
