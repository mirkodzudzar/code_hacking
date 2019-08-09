<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\user;
use App\Post;
use App\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\Like;
use App\Dislike;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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

      $countComments = Comment::where('post_id', $post->id)->count();

      $countLikes = Like::where('slug', $post->slug)->count();

      $countDislikes = Dislike::where('slug', $post->slug)->count();

      return view('post', compact('post','comments', 'categories', 'countComments', 'countLikes', 'countDislikes'));

    }

    public function like($slug)
    {

      $loggedin_user = Auth::user();

      $post = Post::findBySlugOrFail($slug);

      $like_user = Like::where('user_id', '=', $loggedin_user->id)->where('post_id', '=', $post->id)->first();

      $dislike_user = Dislike::where('user_id', '=', $loggedin_user->id)->where('post_id', '=', $post->id)->first();

      if(empty($like_user->user_id) && empty($dislike_user->user_id))
      {

        // Both like and dislike button are empty. By clicking on like button, you creating new like
        $like = new Like;
        $like->user_id = Auth::user()->id;
        $like->email = Auth::user()->email;
        $like->post_id = $post->id;
        $like->slug = $post->slug;
        $like->save();

        Session::flash('liked_post', 'Post '.$post->title.' has been liked!');

        return redirect()->back();

      }
      elseif(!empty($like_user->user_id) && empty($dislike_user->user_id))
      {

        // Like button has been created before. By clicking on like button, you are canceling your like
        $like_user->delete();

        Session::flash('canceled_liked_post', 'Like has been canceled!');

        return redirect()->back();
      }
      else
      {

        // Dislike button has been created before. By clicking on like button, you are deleting dislike and creating like
        $dislike_user->delete();

        $like = new Like;
        $like->user_id = Auth::user()->id;
        $like->email = Auth::user()->email;
        $like->post_id = $post->id;
        $like->slug = $post->slug;
        $like->save();

        Session::flash('liked_post', 'Post '.$post->title.' has been liked!');

        return redirect()->back();

      }
    }

    public function dislike($slug)
    {

      $loggedin_user = Auth::user();

      $post = Post::findBySlugOrFail($slug);

      $like_user = Like::where('user_id', '=', $loggedin_user->id)->where('post_id', '=', $post->id)->first();

      $dislike_user = Dislike::where('user_id', '=', $loggedin_user->id)->where('post_id', '=', $post->id)->first();

      if(empty($like_user->user_id) && empty($dislike_user->user_id))
      {

        // Both like and dislike buttons are empty. By clicking on dislike button, you are creatink your dislike
        $dislike = new Dislike;
        $dislike->user_id = Auth::user()->id;
        $dislike->email = Auth::user()->email;
        $dislike->post_id = $post->id;
        $dislike->slug = $slug;
        $dislike->save();

        Session::flash('disliked_post', 'Post '.$post->title.' has been disliked!');

        return redirect()->back();

      }
      elseif(!empty($like_user->user_id) && empty($dislike_user->user_id))
      {

        // Like button has been created before. By clicking on dislike button, you are deleting like and creating like
        $like_user->delete();

        $dislike = new Dislike;
        $dislike->user_id = Auth::user()->id;
        $dislike->email = Auth::user()->email;
        $dislike->post_id = $post->id;
        $dislike->slug = $slug;
        $dislike->save();

        Session::flash('disliked_post', 'Post '.$post->title.' has been disliked!');

        return redirect()->back();

      }
      else
      {

        // Dislike button has been created before. By clicking on dislike button, you are canceling your dislike
        $dislike_user->delete();

        Session::flash('canceled_disliked_post', 'Dislike has been canceled!');

        return redirect()->back();

      }
    }
}
