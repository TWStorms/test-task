<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

namespace App\Http\Filters;

use Closure;

/**
 * Class Filter
 *
 * @package App\Http\Filters
 */
abstract class Filter implements IFilter
{

    /**
     * Filter Params
     *
     * @var string|int|array|bool
     */
    protected $args;

    /**
     * Applying Filter On
     *
     * @var object
     */
    protected $query;

    /**
     * Filter Handler
     *
     * @param $query
     * @param Closure $next
     *
     * @return object
     */
    public function handle($query, Closure $next)
    {

        $this->query = $query;

        if(count(request()->all()) < 1)
            return $this->query;

        collect(request()->all())->map(function ($args, $method) use ($next, $query) {

            if(method_exists($this, $method) && !empty($args)) {
                $this->args = $args; $this->{$method}();
            }

            else
                $next($query);

        });

        return $this->query;
    }
}
