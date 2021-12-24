<?php

namespace App\Repositories;

class ProductRepository extends Repository
{

    public function productsWithTags()
    {
        return $this->model::with(['tags']);
    }

    public function where($field,$valor,$operator = '=')
    {
        return $this->model::where($field,$operator,$valor)->get();
    }

}
