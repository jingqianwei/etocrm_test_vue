<?php

namespace Tests\Unit\Carousels;

use App\Models\Carousel;
use App\Repositories\CarouselRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarouselUnitTest extends TestCase
{
    /**
     * A basic test example.
     * @return void
     * @throws \App\Exceptions\CreateCarouselErrorException
     */
    public function testExample()
    {
        $data = [
            'title' => $this->faker->word,
            'link' => $this->faker->url,
            'src' => $this->faker->url,
        ];

        $carouselRepo = new CarouselRepository(new Carousel);
        $carousel = $carouselRepo->createCarousel($data);

        $this->assertInstanceOf(Carousel::class, $carousel);
        $this->assertEquals($data['title'], $carousel->title);
        $this->assertEquals($data['link'], $carousel->link);
        $this->assertEquals($data['image_src'], $carousel->src);
        //$this->assertTrue(true);
    }
}
