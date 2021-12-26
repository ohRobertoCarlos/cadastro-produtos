@extends('app.layouts.basic')

@section('title','Products List')

@section('content')
<div class=" mt-4 container">
    <table class="table table-dark table-hover align-center">
        <thead>
            <tr scope="col">
                <th scope="row">
                    Name
                </th>

                <th scope="row">
                    ID
                </th>

                <th scope="row">
                    Tags
                </th>

                <th scope="row">Deletar</th>
                <th scope="row">Editar</th>
            </tr>
        </thead>
        <tbody>

                @foreach ($products as $product)
                <tr>
                    <td scope="row">{{ $product->name }}</td>
                    <td scope="row">{{ $product->id }}</td>


                    <td scope="row">
                        @foreach ($product->tags as $tag)
                            #{{$tag->name}}
                        @endforeach
                    </td>

                    <td scope="row">
                        <a href="{{ route('products.edit', ['product' => $product->id]) }}" class="btn btn-primary">
                            Editar
                        </a>
                    </td>

                    <td scope="row">
                        <form id="form" method="post" action="{{ route('products.destroy', ['product' => $product->id]) }}">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger" type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
                @endforeach
        </tbody>
    </table>

    <a href="{{ route('products.create') }}" class="btn btn-success">
        Cadastrar Produto
    </a>

    <a href="{{ route('tags.create') }}" class="btn btn-warning">
        Cadastrar Tag
    </a>
</div>
@endsection
