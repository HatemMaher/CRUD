<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function index(): Response
    {
        $posts = Post::where('user_id', auth()->id())->latest()->get();

        return Inertia::render('Notes/Index', [
            'posts' => $posts,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        Post::create([
            'title' => strip_tags($validated['title']),
            'body' => strip_tags($validated['body']),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('notes.index')->with('success', 'Note saved.');
    }

    public function edit(Post $post): Response
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        return Inertia::render('Notes/Edit', [
            'post' => $post,
        ]);
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $post->update([
            'title' => strip_tags($validated['title']),
            'body' => strip_tags($validated['body']),
        ]);

        return redirect()->route('notes.index')->with('success', 'Note updated.');
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('notes.index')->with('success', 'Note deleted.');
    }
}
