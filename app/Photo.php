<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    const id_of_no_photo = 1;

    protected $fillable = ['file'];

    protected $uploads = '/images/';

    public function getFileAttribute($photo)
    {

      return $this->uploads . $photo;

    }

    public function user()
    {

      return $this->hasOne('App\User');

    }

    public function post()
    {

      return $this->hasOne('App\Post');

    }

    public static function idOfNoPhoto()
    {

      return 'no_image';

    }

    public static function noPostImage()
    {

      return "http://placehold.it/700x200";

    }

    public static function noImage()
    {

      return 'http://denrakaev.com/wp-content/uploads/2015/03/no-image.png';

    }



}
