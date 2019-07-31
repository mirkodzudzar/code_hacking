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

    public static function noImage()
    {

      return "no_image";

    }



}
