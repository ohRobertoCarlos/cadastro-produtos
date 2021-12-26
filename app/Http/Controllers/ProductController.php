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
        ],[
            'required' => 'o campo :attribute é requirido',
            'name.min' => 'o campo nome do produto tem no mínimo 4 caracteres'
        ]
        );

        $productExists = $this->repository->where('name',$request->name);

        if(count($productExists) > 0)
            return redirect()->route('products.create');

        $product = $this->repository->store($request);
        $repo = new ProductTagRepository(new ProductTag());

        if($request->input('tag') != null)
        {
            foreach($request->input('tag') as $tag)
            {
                $repo->create(['product_id' => $product->id, 'tag_id' => $tag]);
            }
        }

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
        $request->validate(['name' => 'required|min:2','tag' => 'exists:tags,id'],[
            'required' => 'o campo :attribute é requerido',
            'name.min' => 'O nome do produto deve ter no mínimo 2 caracteres',
            'exists' => 'o campo :attribute não existe'
        ]);
        $repoProductTag = new ProductTagRepository(new ProductTag());
        $product = $this->repository->find($id);
        $oldTags = $product->tags;

        if($product->name != $request->input('name'))
        {
            $product->name = $request->input('name');
            $product->save();
        }
        // Removendo tags caso o usuário remova alguma tag
        if($request->input('tag') == null)
        {
            if(count($oldTags) > 0)
            {
                foreach($oldTags as $oldTag)
                {
                    $repoProductTag
                        ->deleteWhere(['product_id' => $product->id, 'tag_id' => $oldTag->id]);
                }
            }
        }
        // Se haver alguma tag no request
        if($request->input('tag') != null)
        {   //deletar tags se retiradas
            if(count($oldTags) > count($request->input('tag')))
            {
                foreach($oldTags as $oldTag)
                {   // Verificar se a tag antiga está no request atual, se não, será apagada.
                    if(!in_array($oldTag->id, $request->input('tag')))
                        $repoProductTag->deleteWhere(['product_id' => $product->id, 'tag_id' => $oldTag->id]);
                }
            }

            foreach($request->input('tag') as $tagId)
            {   // checando se existem tags antigas
                if(count($oldTags) > 0)
                {
                    foreach($oldTags as $oldTag)
                    {
                        if($tagId != $oldTag->id)
                        {
                            $repoProductTag
                            ->updateWhere(
                                ['product_id' => $product->id,'tag_id' => $oldTag->id]
                                ,$product->id, $tagId
                            );
                        }
                    }
                }else
                {  // Adicionando tags à produtos por não haver tags antigas
                     $repoProductTag->create(['product_id' => $product->id, 'tag_id' => $tagId]);
                }
            }
        }

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
        $product = $this->repository->find($id);
        $repoProductTag = new ProductTagRepository(new ProductTag());

        foreach($product->tags as $tag)
        {
            $repoProductTag
                ->deleteWhere(['product_id' => $product->id,
                 'tag_id' => $tag->id
                ]);
        }

        $product->delete();

        return redirect()->route('products.index');
    }
}
