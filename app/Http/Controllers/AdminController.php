<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Comment;
use App\Photo;
use App\User;

class AdminController extends Controller
{
    public function index()
    {

      $usersCount = User::count();
      $postsCount = Post::count();
      $photosCount = Photo::count();
      $categoriseCount = Category::count();
      $commentsCount = Comment::count();

      return view('admin.index', compact('usersCount', 'postsCount', 'photosCount', 'categoriseCount', 'commentsCount'));

    }
}
