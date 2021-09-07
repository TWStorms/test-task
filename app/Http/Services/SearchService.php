<?php

namespace App\Http\Services;

use Illuminate\Pipeline\Pipeline;

/**
 * Class SearchService
 *
 * @package App\Http\Services
 */
class SearchService
{

    /**
     * Search Service <BOOST>
     *
     * @param $model
     * @param $filter
     *
     * @return mixed
     */
    public function search($model, $filter)
    {
        return app(Pipeline::class)
            ->send($model->query())
            ->through($filter)
            ->thenReturn();
    }
}
