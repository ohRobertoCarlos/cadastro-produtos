@extends('app.layouts.basic')

@section('title','Editar Produto')

@section('content')
    <div class="container mt-5 col-6">
        @if ($errors->has('name') || $errors->has('tag') )
            <div class="alert alert-danger">
                {{ $errors->first('name') }}
                {{ $errors->first('tag') }}
            </div>
        @endif
        <form action="{{ route('products.update', ['product' => $product->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <label class="form-label" for="product_name">Nome</label>
            <input id="product_name" name="name" class="form-control" type="text" value="{{ $product->name }}" required="required">
            <section class="m-3">

                <select class="form-select" name="tag">
                    <option >Selecione uma Tag</option>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}" {{ ($product->tags[0]->id ?? old('id')) == $tag->id ? 'selected' : '' }}>{{ $tag->name }}</option>
                    @endforeach
                </select>


            </section>

            <button class="btn btn-primary mt-3" type="submit">Atualizar</button>
        </form>
    </div>
@endsection
