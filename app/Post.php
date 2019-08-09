<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Post extends Model
{

  use Sluggable;
  use SluggableScopeHelpers;

  public function sluggable()
  {

    return [
      'slug' => [
        'source' => 'title'
      ]
    ];

  }

  protected $fillable = ['category_id', 'photo_id', 'title', 'body'];

  protected $primaryKey = 'id';

  public function user()
  {

    return $this->belongsTo('App\User');

  }

  public function photo()
  {

    return $this->belongsTo('App\Photo');

  }

  public function category()
  {

    return $this->belongsTo('App\Category');

  }

  public function comments()
  {

    return $this->hasMany('App\Comment');

  }

  public function likes()
  {

    return $this->hasMany('App\Like');

  }

  public function dislikes()
  {

    return $this->hasMany('App\Dislike');

  }

  // public function photoPlaceholder()
  // {
  //
  //   return 'http://placehold.it/700x200';
  //
  // }

}
