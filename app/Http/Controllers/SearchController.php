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
        
        if (!$query) {
            return response()->json([]);
        }

        $query = trim($query);

        if (strlen($query) < 3) {
            return response()->json([]);
        }

        // Use ILIKE for case-insensitive search in both the title and the body
        $questions = Question::where(function ($q) use ($query) {
            // Search by title using ILIKE
            $q->where('title', 'ILIKE', "%$query%")
              // Search by body using ILIKE
              ->orWhereHas('post', function ($postQuery) use ($query) {
                  $postQuery->where('body', 'ILIKE', "%$query%");
              });
        })
        ->orWhereHas('tags', function ($tagQuery) use ($query) {
            // Full-text search (FTS) on tags name (using to_tsvector)
            $tagQuery->whereRaw("to_tsvector('english', name) @@ plainto_tsquery('english', ?)", [$query]);
        })
        ->with('post', 'tags')  // Include related posts and tags
        ->get();

        return response()->json($questions);
    }
}

