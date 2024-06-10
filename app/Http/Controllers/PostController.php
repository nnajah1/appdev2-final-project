<?php

namespace App\Http\Controllers;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function store(PostRequest $request)
    {   
        $user = Auth::user();
        $validated = $request->validated();
        $post = Post::create([
            
            'user_id' => Auth::id(),
            'post_user_name' => $user->name,
            'content' => $validated['content'],
        ]);
        return response()->json(['message' => 'Post created successfully', 'post' => $post], 201);
    }

    public function show(Post $post)
    {
        return response()->json($post->load('user', 'comments', 'likes'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $user = Auth::user();
        $validated = $request->validated();
        if ($post->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $post = $post->update([
            $post->post_user_name = $user->name,
            $post->content = $validated['content'],
        ]);

        return response()->json(['message' => 'Post updated successfully', 'post' => $post]);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully', 'post' => $post]);
    }
}
