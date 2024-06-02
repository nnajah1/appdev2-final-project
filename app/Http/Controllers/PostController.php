<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['user', 'comments', 'likes'])->get();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',    
            'content' => 'required|string',
        ]);

        $post = Post::create($request->all());
        return response()->json(['message' => 'Post created successfully', 'post' => $post], 201);
    }

    public function show(Post $post)
    {
        return response()->json($post->load('user', 'comments', 'likes'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $post->update($request->all());
        return response()->json(['message' => 'Post updated successfully', 'post' => $post]);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully', 'post' => $post]);
    }
}
