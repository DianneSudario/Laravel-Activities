<?php

namespace App\Http\Controllers;

use App\Models\post;
use App\Models\User;
use Illuminate\Http\Request;
use SebastianBergmann\Environment\Console;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::id());
        $post = $user->posts()->orderBy('created_at', 'desc')->get();
        return view('posts.index', compact('post'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //go to create page id user is logged in

        // Get the currently authenticated user id
        $user_id = Auth::id();
        if ($user_id) {
            return view('posts.create');
        } else {
            return view('posts.alert');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate Data
        $request->validate([
            'title' => 'required|unique:posts|max:255',
            'description' => 'required'
        ]);

        if ($request->hasFile('img')) {
            $filenameWithExt = $request->file('img')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('img')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extention;

            $path = $request->file('img')->storeAs('public/img', $fileNameToStore);
        } else {
            $fileNameToStore = 'default';
        }

        //post data to database
        $post = new Post();
        $post->fill($request->all());
        $post->img = $fileNameToStore;
        $post->user_id = auth()->user()->id;
        $post->save();

        return redirect('/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(post $post)
    {
        //show data

        $post = Post::find($post->id);
        $comments = $post->comments;
        return view('posts.show', compact('post', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //return edit view if user is logged in
        $user_id = Auth::id();
        if ($user_id) {
            $post = Post::find($id);
            return view('posts.edit', compact('post'));
        } else {
            return view('posts.alert');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //update the value
        $post = Post::find($id);
        $post->title = $request->title;
        $post->description = $request->description;
        $post->save();

        return redirect('/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //delete data id user is logged in
        $user_id = Auth::id();
        if ($user_id) {
            $post = Post::find($id);
            $post->delete();
            return redirect('/posts');
        } else {
            return view('posts.alert');
        }
    }
}
