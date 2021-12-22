@extends('app.layouts.basic')

@section('title','Products List')

@section('content')
<ul>
    @foreach ($products as $product)
        <li>
            <p>{{ $product->name }}</p>
        </li>
    @endforeach
</ul>
@endsection
