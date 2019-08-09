<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Like extends Model
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

    protected $fillable = [
      'user_id',
      'post_id',
      'slug',
      'email'
    ];

    public function post()
    {

      return $this->belongsTo('App\Post');

    }
}
