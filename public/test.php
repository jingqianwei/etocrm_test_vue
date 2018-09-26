<?php
/**
 * Created by PhpStorm.
 * User: chinwe.jing
 * Date: 2018/9/25
 * Time: 18:07
 */
require __DIR__.'/../vendor/autoload.php';

use App\utils\Scraper;
use Clue\React\Buzz\Browser;
use React\Filesystem\Filesystem;

$loop = \React\EventLoop\Factory::create();

$scraper = new Scraper(
    new Browser($loop), Filesystem::create($loop), __DIR__ . '/images'
);

$scraper->scrape([
    'https://www.pexels.com/photo/adorable-animal-blur-cat-617278/',
    'https://www.pexels.com/photo/kitten-cat-rush-lucky-cat-45170/',
    'https://www.pexels.com/photo/adorable-animal-baby-blur-177809/',
    'https://www.pexels.com/photo/adorable-animals-cats-cute-236230/',
    'https://www.pexels.com/photo/relaxation-relax-cats-cat-96428/',
]);

$loop->run();