<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::with('user', 'post')->get();
        return response()->json($comments);
    }

    public function store(StoreCommentRequest $request)
    {
        $user = Auth::user();

        
        $post = Post::with('user')->find($request->validated()['post_id']);
        $comment = Comment::create([
            'user_id' => Auth::id(),
            'user_name' => $user->name,
            'post_id' => $request->validated()['post_id'],
            'post_user_name' =>  $post->user->name,
            'content' => $request->validated()['content'],
        ]);

        return response()->json(['message' => 'Comment created successfully', 'comment' => $comment], 201);
    }

    public function show(Comment $comment)
    {
        return response()->json($comment->load('user', 'post'));
    }

    public function update(StoreCommentRequest $request, Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $comment = $comment->update([
            $post = Post::with('user')->find($comment->post_id),
            $comment->post_user_name = $post->user->name,
            $comment->content = $request->validated()['content'],
        ]);
        

        return response()->json(['message' => 'Comment updated successfully', 'comment' => $comment]);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json(['message' => 'Comment deleted successfully', 'comment' => $comment]);
    }
}
