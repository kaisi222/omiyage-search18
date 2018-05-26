@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $user->name }}の登録情報の変更</div>
                
                    <div class="panel-body">

                        {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'put']) !!}

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">
                                {!! Form::label('name', '名前:') !!}
                            </label>
                                {!! Form::text('name') !!}
                        </div>
                        
                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">
                                {!! Form::label('email', 'メールアドレス:') !!}
                            </label>
                                {!! Form::text('email') !!}
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    変更
                                </button>
                            </div>
                        </div>
                        
                        {!! Form::close() !!}
    
                    </div>
                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection