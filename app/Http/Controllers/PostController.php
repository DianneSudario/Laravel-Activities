<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {  
        // Only authenticated user is allowed to create/update and delete a post
        // Using construct function here in PostController
        // It will protect all the routes from navigating in address bar
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** Dianne F. Sudario **/
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /** Dianne F. Sudario **/
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /** Dianne F. Sudario **/
        $request->validate([
            'title' => 'required|unique:posts|max:255',
            'description' => 'required'
        ]);
        
        if($request->hasfile('img')){

            $filenameWithExt = $request->file('img')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);  
            $extension = $request->file('img')->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $path = $request->file('img')->storeAs('public/img', $fileNameToStore);
        } else {
            $fileNameToStore = '';
        }
        
        

        //dd($request);
        $post = new Post();
        $post->fill($request->all());
        $post->img = $fileNameToStore;
        if($post->save()){
            $message = "Storing Data Successfully!";
        }
        
        return redirect('/posts')->with('message', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        /** Dianne F. Sudario **/
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        /** Dianne F. Sudario **/
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|unique:posts|max:255',
            'description' => 'required'
        ]);
        
         /** Dianne F. Sudario **/
        $post = Post::find($id);
        $post->fill($request->all());
        $post->save();
        
        return redirect('/posts');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /** Dianne F. Sudario **/
        $post = Post::find($id);
        $post->delete();
        
        return redirect('/posts');
    }
}