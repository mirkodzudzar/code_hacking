<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Post;
use App\Http\Requests\PostsCreateRequest;
use App\Http\Requests\PostsEditRequest;
use App\Photo;
use App\Category;
use Illuminate\Support\Facades\Session;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id')->all();

        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsCreateRequest $request)
    {
        $input = $request->all();

        $user = Auth::user();

        if($file = $request->file('photo_id'))
        {

          $name = time() . $file->getClientOriginalName();

          $file->move('images', $name);

          $photo = Photo::create(['file' => $name]);

          $input['photo_id'] = $photo->id;

        }
        else
        {

          $input['photo_id'] = Photo::id_of_no_photo;

        }

        $user->posts()->create($input);

        Session::flash('created_post', 'The '.$request->title.' post has been created!');

        return redirect('/admin/posts');
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        $categories = Category::pluck('name', 'id')->all();

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostsEditRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        $input = $request->all();

        if($file = $request->file('photo_id'))
        {

          if($post->photo->id !== 1)
          {

            unlink(public_path() . $post->photo->file);

            $post->photo->delete();

          }

          $name = time() . $file->getClientOriginalName();

          $file->move('images', $name);

          $photo = Photo::create(['file' => $name]);

          $input['photo_id'] = $photo->id;

        }
        else
        {

          $input['photo_id'] = $post->photo->id;

        }

        Auth::user()->posts()->whereId($id)->first()->update($input);

        Session::flash('updated_post', 'The '.$request->title.' post has been updated!');

        return redirect('/admin/posts');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      $post = Post::findOrFail($id);

      if($post->photo->id !== 1)
      {

        unlink(public_path() . $post->photo->file);

        $post->photo->delete();

      }

      $post->delete();

      Session::flash('deleted_post', 'The '.$post->title.' post has been deleted!');

      return redirect('admin/posts');

    }

    public function post($slug)
    {

      $post = Post::findBySlugOrFail($slug);

      $comments = $post->comments()->whereIsActive(1)->get();

      return view('post', compact('post','comments'));

    }
}
