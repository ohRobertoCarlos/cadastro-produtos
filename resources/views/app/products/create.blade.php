@extends('app.layouts.basic')

@section('title','Cadastrar Produto')

@section('content')
    <div class="container mt-5 col-6">
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

                <select class="form-select" name="tag">
                    <option >Selecione uma Tag</option>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>


            </section>

            <button class="btn btn-primary mt-3" type="submit">Cadastrar</button>
        </form>
    </div>
@endsection
