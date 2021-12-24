@extends('app.layouts.basic')

@section('title','Tags List')

@section('content')
<div class=" mt-4 container">
    <table class="table table-dark table-hover">
        <thead>
            <tr scope="col">

                <th scope="row">
                    Tag
                </th>

                <th scope="row">
                    ID
                </th>

                <th scope="row">
                    Editar
                </th>

                <th scope="row">
                    Excluir
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tags as $tag)
            <tr>
                <td scope="row">{{ $tag->name }}</td>
                <td scope="row">{{ $tag->id }}</td>

                <td scope="row">
                    <a href="{{ route('tags.edit',['tag' => $tag->id]) }}" class="btn btn-primary">
                        Editar
                    </a>
                </td>

                <td scope="row">
                    <form id="form" method="post" action="{{ route('tags.destroy', ['tag' => $tag->id]) }}">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-danger" type="submit">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('tags.create') }}" class="btn btn-success">
        Cadastrar Tag
    </a>

    <a href="{{ route('products.create') }}" class="btn btn-warning">
        Cadastrar Produto
    </a>
</div>
@endsection
