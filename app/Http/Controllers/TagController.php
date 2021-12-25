<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\ProductTag;

use Illuminate\Http\Request;

use App\Repositories\TagRepository;
use App\Repositories\ProductTagRepository;

class TagController extends Controller
{
    private $repository;

    public function __construct(Tag $model)
    {
        $this->repository = new TagRepository($model);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = $this->repository->all();

        return view('app.tags.list', ['tags' => $tags]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app.tags.create');
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
            'name.min' => 'Uma tag tem no mínimo 2 caracteres',
        ]);

        $this->repository->store($request);

        return redirect()->route('tags.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = $this->repository->find($id);
        return view('app.tags.edit', ['tag' => $tag]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $tagObj = $this->repository->find($id);
        $tagObj->name = $request->input('name');
        $tagObj->update();

        return redirect()->route('tags.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = $this->repository->find($id);
        $repoProductTag = new ProductTagRepository(new ProductTag());

        foreach($tag->products as $product)
        {
            $repoProductTag
                ->deleteWhere(['product_id' => $product->id,
                 'tag_id' => $tag->id
                ]);
        }

        $tag->delete();

        return redirect()->route('tags.index');
    }
}
