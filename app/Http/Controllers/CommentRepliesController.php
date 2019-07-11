<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\CommentReply;
use Illuminate\Support\Facades\Auth;
use App\Comment;
use Illuminate\Support\Facades\Session;

class CommentRepliesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    public function createreply(Request $request)
    {

      $user = Auth::user();

      $data = [

        'comment_id' => $request->comment_id,
        'author' => $user->name,
        'email' => $user->email,
        'photo' => $user->photo->file,
        'body' => $request->body
      ];

      CommentReply::create($data);

      $request->session()->flash('reply_message', 'Your reply has been submitted!');

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
        $comment = Comment::findOrFail($id);

        $replies = $comment->replies;

        return view('admin.comments.replies.show', compact('replies'));
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
        $reply = CommentReply::findOrFail($id);

        $reply->update($request->all());

        Session::flash('reply_updated', $reply->is_active == 1 ? 'Approved!' : 'Un-approved!');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reply = CommentReply::findOrFail($id);

        $reply->delete();

        Session::flash('reply_deleted', 'The reply by '.$reply->author.' has been deleted!');

        return redirect()->back();
    }
}
