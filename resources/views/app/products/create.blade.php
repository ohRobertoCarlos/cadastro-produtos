@extends('app.layouts.basic')

@section('title','Cadastrar Produto')

@section('content')
    <div class="container mt-5 col-8">
        @if ($errors->has('name') || $errors->has('tag') )
            <div class="alert alert-danger">
                {{ $errors->first('name') }}
                {{ $errors->first('tag') }}
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <label class="form-label" for="name">Nome</label>
            <input id="product_name" name="name" class="form-control" type="text" required="required">

            <section class="m-3">
                @foreach ($tags as $tag)
                <div>
                    <input type="checkbox" name="tag[]" value="{{ $tag->id }}" id="{{ $tag->name }}">
                    <label class="form-label" for="{{ $tag->name }}"> {{ $tag->name }}</label>
                </div>
                @endforeach
            </section>

            <button class="btn btn-primary mt-3" type="submit">Cadastrar</button>
        </form>
    </div>
@endsection
