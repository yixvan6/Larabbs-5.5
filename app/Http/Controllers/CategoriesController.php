<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Category;
use App\Models\User;
use App\Models\Link;

class CategoriesController extends Controller
{
    public function show(Category $category, Request $request, User $user, Link $link)
    {
        $topics = Topic::where('category_id', $category->id)->orderWith($request->order)->paginate();
        $active_users = $user->getActiveUsers();
        $links = $link->getFromCached();

        return view('topics.index', compact('topics', 'category', 'active_users', 'links'));
    }
}
