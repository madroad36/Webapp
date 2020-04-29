<?php
namespace App\Repositories;

use App\Models\Slider;

class SliderRepository extends  BaseRepository
{
    public function __construct(Slider $slider)
    {
        $this->model = $slider;
    }
}