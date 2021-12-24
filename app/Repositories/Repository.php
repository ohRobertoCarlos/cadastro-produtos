<?php

namespace App\Repositories;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function store(Request $request)
    {
        return $this->model::create($request->all());
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

}
