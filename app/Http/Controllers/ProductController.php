<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Tag;
use App\Models\ProductTag;

use App\Repositories\ProductRepository;
use App\Repositories\ProductTagRepository;
use App\Repositories\TagRepository;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $repository;

    public function __construct(Product $model)
    {
        $this->repository = new ProductRepository($model);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->repository->productsWithTags()->get();

        return view('app.products.list', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tagsModel = new TagRepository(new Tag());
        $tags = $tagsModel->all();
        return view('app.products.create',['tags' => $tags]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2',
            'tag' => 'required|integer'
        ],[
            'required' => 'o campo :attribute é requirido',
            'name.min' => 'o campo nome do produto tem no mínimo 4 caracteres',
            'integer' => 'selecione uma tag'
        ]
        );

        $productExists = $this->repository->where('name',$request->name);

        if(count($productExists) > 0)
            return redirect()->route('products.create');

        $product = $this->repository->store($request);

        $repo = new ProductTagRepository(new ProductTag());
        $repo->create(['product_id' => $product->id, 'tag_id' => $request->input('tag')]);

        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = $this->repository->find($id);
        $tagsObj = new TagRepository(new Tag);
        $tags = $tagsObj->all();

        return view('app.products.edit',['product' => $product, 'tags' => $tags]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:2',
            'tag' => 'required|exists:tags,id',
        ],[
            'required' => 'o campo :attribute é requerido',
            'name.min' => 'O nome do produto deve ter no mínimo 3 caracteres',
            'exists' => 'o campo :attribute não existe'
        ]);

        $productObj = $this->repository->find($id);
        $oldTagId = $productObj->tags->first();
        $newTagId = $request->input('tag');
        $productId = $id;

        if($productObj->name != $request->input('name'))
        {
            $productObj->name = $request->input('name');
            $productObj->save();
        }

        $repoProductTag = new ProductTagRepository(new ProductTag());
        $repoProductTag
            ->updateWhere(['product_id' => $id,
             'tag_id' => $oldTagId
            ],$productId, $newTagId
        );

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tagId = $this->repository->find($id)->tags[0]->id;
        $repoProductTag = new ProductTagRepository(new ProductTag());
        $repoProductTag
            ->deleteWhere(['product_id' => $id,
             'tag_id' => $tagId
            ]);

        $this->repository->find($id)->delete();

        return redirect()->route('products.index');
    }
}
