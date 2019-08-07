<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\user;
use App\Post;
use App\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      //$year = Carbon::now()->year;

      $posts = Post::paginate(5);

      $categories = Category::all();

      $query = Input::get('query');

      if($query != '')
      {

        $post = Post::where('title', 'LIKE', '%' . $query . '%')->get();

        if(count($post) > 0)
        {

          return view('front.home', compact('posts', 'categories'))->withDetails($post)->withQuery($query);

        }

        return view('front.home', compact('posts', 'categories'))->withMessage('No posts found!');
      }

      return view('front.home', compact('posts', 'categories'));

    }

    public function post($slug)
    {

      $post = Post::findBySlugOrFail($slug);

      $comments = $post->comments()->whereIsActive(1)->get();

      $categories = Category::all();

      return view('post', compact('post','comments', 'categories'));

    }
}
