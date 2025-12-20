<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function suggestions(Request $request)
    {
        $name = $request->query('name');

        return response()->json(Tag::findSimilar($name));
    }
}
