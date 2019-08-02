<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Post;

class PostCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::all();

        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $user = Auth::user();

      $data = [

        'post_id' => $request->post_id,
        'author' => $user->name,
        'email' => $user->email,
        'photo' => $user->photo ? $user->photo->file : '',
        'body' => $request->body

      ];

      Comment::create($data);

      $request->session()->flash('comment_message', 'Your message has been submited and it\'s waiting for moderation!');

      return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        $comments =  $post->comments;

        return view('admin.comments.show', compact('comments'));
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
        $comment = Comment::findOrFail($id);

        $comment->update($request->all());

        Session::flash('comment_updated', $comment->is_active == 1 ? 'Aproved!' : 'Un-aproved!');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $comment = Comment::findOrFail($id);

        $comment->delete();

        Session::flash('comment_updated', 'The comment by '.$comment->author.' has been deleted!');

        return redirect()->back();
    }
}
