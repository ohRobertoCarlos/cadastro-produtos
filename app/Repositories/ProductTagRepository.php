<?php

namespace App\Repositories;

class ProductTagRepository extends Repository
{

    public function create(array $array)
    {
        return $this->model::create($array);
    }

    public function updateWhere(array $array, $productID, $newTagId)
    {
        $retorno =  $this->model::where('product_id',$array['product_id'])->where('tag_id',$array['tag_id']);

        if($productTagModel = $retorno->first())
        {
            $productTagModel->product_id = $productID;
            $productTagModel->tag_id = $newTagId;
            $productTagModel->update();

            return true;
        }elseif($array['tag_id'] == null){
            $this->create([
                'product_id' => $productID,
                'tag_id' => $newTagId
            ]);

            return true;
        }

        return false;
    }

    public function deleteWhere(array $array)
    {
        $retorno =  $this->model::where('product_id',$array['product_id'])->where('tag_id',$array['tag_id']);

        if($productTagModel = $retorno->first())
        {
            $productTagModel->delete();

            return true;
        }

        return false;
    }

    public function findWhere(array $array)
    {
        $productTagObj = $this->model->where('product_id', $array['product_id'])
                                            ->where('tag_id',$array['tag_id']);
        dd($productTagObj);
    }
}
