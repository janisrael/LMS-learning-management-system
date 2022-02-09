<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

$factory->define(Model::class, function (Faker $faker) {
  return [
    'name' => Str::random(10),
    'email' => Str::random(10).'@gmail.com',
    'password' => Hash::make('password'),
    ];
});
