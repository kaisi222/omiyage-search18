@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">ダッシュボード</div>

                <?php /*
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ Auth::user()->name }}はログイン中です。
                </div>
                */ ?>

                <div class="panel-body">
                    @section('content')
                        @include('items.items')
                        {!! $items->render() !!}
                    @endsection
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
