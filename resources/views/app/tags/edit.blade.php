@extends('app.layouts.basic')

@section('title','Cadastrar Tag')

@section('content')
    <div class="container mt-5 col-8">
        @if ($errors->has('name'))
            <div class="alert alert-danger">
                {{ $errors->first('name') }}
            </div>
        @endif
        <form action="{{ route('tags.update',['tag' => $tag->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <label class="form-label" for="tag_name">Nome</label>
            <input id="tag_name" name="name" class="form-control" type="text" value="{{$tag->name}}" required="required">

            <button class="btn btn-primary mt-3" type="submit">Atualizar</button>
        </form>
    </div>
@endsection
