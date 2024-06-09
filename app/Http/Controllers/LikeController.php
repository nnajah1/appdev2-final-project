<?php

namespace App\Http\Controllers;
use App\Http\Requests\LikeRequest;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $likes = Like::all();
        return response()->json($likes);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(LikeRequest $request)
    {
        $user = Auth::user();
        $post = Post::with('user')->find($request->validated()['post_id']);
        $like = Like::create([
            'user_id' => Auth::id(),
            'user_name' => $user->name,
            'post_id' => $request->validated()['post_id'],
            'post_user_name' =>  $post->user->name,
        ]);
        
        return response()->json(['message' => 'Liked successfully', 'like' => $like], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $like = Like::findOrFail($id);
        return response()->json($like);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // $like = Like::findOrFail($id);
        // $like->update($request->all());
        // return response()->json($like);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $like = Like::findOrFail($id);
        $like->delete();
        return response()->json(['message' => 'unliked successfully', 'like' => $like]);
    }
}
