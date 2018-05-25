@if (Auth::user()->is_liking($item->code))
    {!! Form::open(['route' => 'item_user.dont_like', 'method' => 'delete']) !!}
        {!! Form::hidden('itemCode', $item->code) !!}
        {!! Form::submit('解除', ['class' => 'btn btn-success']) !!}
    {!! Form::close() !!}
@else
    {!! Form::open(['route' => 'item_user.like']) !!}
        {!! Form::hidden('itemCode', $item->code) !!}
        {!! Form::submit('いいね', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
@endif