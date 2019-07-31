<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'role_id' => $faker->numberBetween(1, 3),
        'photo_id' => 1,
        'is_active' => 0,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10)
    ];
});

$factory->define(App\Post::class, function(Faker\Generator $faker){

  return [

    'category_id' => $faker->numberBetween(1, 6),
    'photo_id' => 1,
    'title' => $faker->sentence(1, 11),
    'body' => $faker->paragraphs(rand(10, 15), true),
    'slug' => $faker->slug()

  ];

});

$factory->define(App\Role::class, function(Faker\Generator $faker){

  return [

    'name' => $faker->randomElement(['administrator', 'author', 'subscriber'])

  ];

});

$factory->define(App\Category::class, function(Faker\Generator $faker){

  return [

    'name' => $faker->randomElement(['PHP', 'Programming', 'JavaScript', 'Life', 'Travel', 'Coffie'])

  ];

});

$factory->define(App\Photo::class, function(Faker\Generator $faker){

  return [

    'file' => App\Photo::noImage()

  ];

});

$factory->define(App\Comment::class, function(Faker\Generator $faker){

  return [

    'post_id' => $faker->numberBetween(1, 10),
    'is_active' => 1,
    'author' => $faker->name,
    'photo' => App\Photo::noImage(),
    'email' => $faker->safeEmail,
    'body' => $faker->paragraphs(1, true)

  ];

});

$factory->define(App\CommentReply::class, function(Faker\Generator $faker){

  return[

    'comment_id' => $faker->numberBetween(1, 10),
    'is_active' => 1,
    'author' =>$faker->name,
    'photo' => App\Photo::noImage(),
    'email' => $faker->safeEmail,
    'body' => $faker->paragraphs(1, true)

  ];

});
