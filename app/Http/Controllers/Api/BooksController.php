<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class BooksController extends Controller
{

    public function getAllBooks()
    {
        return new BookResource(Book::all());
    }

    public function getById(int $id)
    {
        return new BookResource(Book::findOrFail($id));
    }

    public function addBook(Request $request)
    {
        $data = (array) json_decode($request->getContent());
        Book::create($data);
        return response()->json([
                        "message" => "book added"
                            ], 202);
    }
    
    public function updateBook(Request $request, int $id)
    {
        $data = (array) json_decode($request->getContent());
        Book::where('id', $id)->update($data);
        return response()->json([
                        "message" => "book updated"
                            ], 202);
    }

    public function deleteBook(int $id)
    {
        $book = Book::find($id);
        if ($book !== null) {
            $book->delete();
            return response()->json([
                        "message" => "book deleted"
                            ], 202);
        }

        return response()->json([
                    "message" => "book not found"
                        ], 404);
    }

    public function uploadCover(Request $request, int $id)
    {
        if($request->hasFile('cover')){
            $cover = $request->cover;
            $filename = $id . '.jpg';
            $request->cover->storeAs('covers', $filename, 'public');
            $book = Book::find($id);
            $book->link_to_cover = "/storage/covers/$filename";
            $book->save();
            return response()->json([
                        'message' => 'Cover uploaded with url ' . asset($book->link_to_cover)
                            ], 202);
        }
    }
}
