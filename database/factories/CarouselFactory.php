<?php

use App\Models\Carousel;
use Faker\Generator as Faker;

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

$factory->define(Carousel::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'link' => $faker->url,
        'src' => $faker->url,
    ];
});
