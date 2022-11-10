<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Models\User;
use DB;
use App\Http\Requests;

class PostsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except'=> ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $posts = Post::All();
        //return Post::where('title', 'Second thesis')->get();
        //$posts = DB::select('SELECT * FROM posts');
        //$posts = Post::orderBy('title','desc')->take(1)->get();
        //$posts = Post::orderBy('title','desc')->get();

        $posts = Post::orderBy('created_at','desc')->paginate(2);
        return view('posts.index')-> with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this -> validate($request , [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        // Handle File upload
        if($request->hasFile('cover_image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_image' )->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just Ext
            $extension = $request->file('cover_image' )->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $filename. '_'.time().'.'.$extension;
            //upload image
            $path = $request->file('cover_image')->storeAs('public/images/',$fileNameToStore);
        }
        else{
            $fileNameToStore = 'noimage.jpg';
        }


        //create a new post

        $post = new Post();
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->User()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();

        return redirect('/posts')-> with('success','Post created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = Post::find($id);

        //check for the correct user

        if(auth()->user()->id != $post->user_id){
            return redirect('/posts')->with('error', 'unauthorized Page');
        }
        return view('posts.edit')->with('post', $post);
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

        $this -> validate($request , [
            'title' => 'required',
            'body' => 'required'
        ]);
        // Handle File upload
        if($request->hasFile('cover_image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_image' )->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just Ext
            $extension = $request->file('cover_image' )->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $filename. '_'.time().'.'.$extension;
            //upload image
            $path = $request->file('cover_image')->storeAs('public/images/',$fileNameToStore);
        }
        //updating post

        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_image')){
            $post->cover_image =$fileNameToStore;
        }
        $post->save();

        return redirect('/posts')-> with('success','Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        //check for the correct user

        if(auth()->user()->id != $post->user_id){
            return redirect('/posts')->with('error', 'unauthorized Page');
        }
        if($post->cover_image != 'noimage.jpg'){
            //Delete the image
            Storage::delete('/public/images/'. $post->cover_image);
        }

        $post->delete();
        return redirect('/posts')->with('success','Post deleted successfully');
    }
}
