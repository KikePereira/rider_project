<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;


class HomeController extends Controller
{
    public function index()
    {
        $routes = Route::where('visibility', 'public')
                        ->orderBy('created_at', 'desc')
                        ->paginate(5);
        return view('home', compact('routes'));
    }

    public function likes()
    {
        $routes = Route::where('visibility', 'public')
                        ->withCount('likes')
                        ->orderByDesc('likes_count')
                        ->paginate(5);

        return view('home', compact('routes'));
    }

    public function comments()
{
    $routes = Route::where('visibility', 'public')
                    ->withCount('comments')
                    ->orderByDesc('comments_count')
                    ->paginate(5);

    return view('home', compact('routes'));
}
    
    
    public function search(Request $request)
    {
        $user = $request->input('nickname');
    
        $routes = Route::where('visibility', 'public')
                        ->whereHas('user', function ($query) use ($user) {
                            $query->where('nickname', 'like', '%' . $user . '%');
                        })
                        ->orderBy('created_at', 'desc')
                        ->paginate(5);
    
        return view('home', compact('routes'));
    }
    
}
