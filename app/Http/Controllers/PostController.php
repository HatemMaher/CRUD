<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index(){
        $posts = Post::where('user_id', auth()->id())->latest()->get();
        return view('welcome', compact('posts'));
    }

    
    public function store(Request $request){
        $validated = $request->validate([
            'title' => 'required',
            'body'  => 'required'
        ]);

        $validated['title'] = strip_tags($validated['title']);
        $validated['body'] = strip_tags($validated['body']);
        $validated['user_id'] = auth()->id();

        Post::create([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'user_id' => auth()->id()
        ]);
        
        return redirect('/')->with('success', 'Post Added Succesfully');
    }

    public function edit(Post $post){
        if ($post->user_id !== auth()->id()){
            abort(403);
        }

        return view('edit', compact('post'));
    }

    public function update(Request $request, Post $post){
        if ($post->user_id !== auth()->id()){
            abort(403);
        }

        $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $post->update([
            'title' => strip_tags($request->title),
            'body' => strip_tags($request->body)
        ]);

        return redirect('/')->with('success', "Post Updated");
    }

    public function destroy(Post $post){
        if ($post->user_id !== auth()->id()){
            abort(403);
        }

        $post->delete();
        return redirect('/')->with('success', "Post deleted!");
    }

}
