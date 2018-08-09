<?php
/**
 * Created by PhpStorm.
 * User: chinwe.jing
 * Date: 2018/8/9
 * Time: 10:38
 */

namespace App\Repositories;

use App\Exceptions\CreateCarouselErrorException;
use Illuminate\Database\QueryException;
use App\Models\Carousel;

class CarouselRepository
{
    public $model = null;

    /**
     * CarouselRepository constructor.
     * @param Carousel $carousel
     */
    public function __construct(Carousel $carousel)
    {
        $this->model = $carousel;
    }

    /**
     * @param array $data
     * @return Carousel
     * @throws CreateCarouselErrorException
     */
    public function createCarousel(array $data) : Carousel
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $e) {
            throw new CreateCarouselErrorException($e);
        }
    }
}