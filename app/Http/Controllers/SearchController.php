<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Question;
use DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $tagId = $request->input('tag'); // Accept tag filter by ID from the frontend

        if (!$query && !$tagId) {
            return response()->json([]);
        }

        $questions = Question::where(function ($q) use ($query) {
            if ($query) {
                // Filter by title or body
                $q->where('title', 'ILIKE', "%$query%")
                  ->orWhereHas('post', function ($postQuery) use ($query) {
                      $postQuery->where('body', 'ILIKE', "%$query%");
                  });
            }
        })
        ->when($tagId, function ($q) use ($tagId) {
            // Filter by tag ID if provided
            $q->whereHas('tags', function ($tagQuery) use ($tagId) {
                $tagQuery->where('id', $tagId);
            });
        })
        ->orWhereHas('tags', function ($tagQuery) use ($query) {
            // Full-text search (FTS) on tags name (using to_tsvector)
            $tagQuery->whereRaw("to_tsvector('english', name) @@ plainto_tsquery('english', ?)", [$query]);
        })
        ->orWhereHas('author', function ($authorQuery) use ($query) {
            // Filter by author nickname (can be incomplete)
            $authorQuery->where('nickname', 'ILIKE', "%$query%");
        })
        ->when($tagId, function ($q) use ($tagId) {
            // Filter by tag ID if provided
            $q->whereHas('tags', function ($tagQuery) use ($tagId) {
                $tagQuery->where('id', $tagId);
            });
        })
        ->orWhereHas('author', function ($authorQuery) use ($query) {
            // Full-text search (FTS) on author name (using to_tsvector) (quicker but needs to be complete)
            $authorQuery->whereRaw("to_tsvector('simple', name) @@ plainto_tsquery('simple', ?)", [$query]);
        })
        ->when($tagId, function ($q) use ($tagId) {
            // Filter by tag ID if provided
            $q->whereHas('tags', function ($tagQuery) use ($tagId) {
                $tagQuery->where('id', $tagId);
            });
        })
        ->with('post', 'tags', 'author') // Eager load relationships
        ->get();

        return response()->json($questions);
    }
}

