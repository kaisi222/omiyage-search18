@extends('layouts.app')

@section('content')
    <h1>Likeランキング</h1>
    @include('items.items', ['items' => $items])
@endsection