<?php

namespace App\Http\Repositories;

use App\Models\Blog;

class BlogRepo extends BaseRepo
{

    /**
     * UserRepo constructor.
     */
    public function __construct()
    {
        parent::__construct(Blog::class);
    }
}
