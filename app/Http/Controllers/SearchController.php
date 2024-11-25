<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Question;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        if (!$query) {
            return response()->json([]);
        }

        $questions = Question::where(function ($q) use ($query) {
            $q->where('title', 'ILIKE', "%$query%")
              ->orWhereHas('post', function ($postQuery) use ($query) {
                  $postQuery->whereRaw(
                      "to_tsvector('english', body) @@ plainto_tsquery('english', ?)",
                      [$query]
                  );
              });
        })->with('post')->get();

        return response()->json($questions);
    }
}

