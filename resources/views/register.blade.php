@extends ('layouts.form')

@section('navbar_class', 'fixed-top navbar-transparent')
@section('form_class', 'card-form-small')

@section('content')
    <h3 class="title">Register</h3>

    {!! Form::open(['route' => 'register.post', 'class' => 'register-form']) !!}
    <div class="form-group {{$errors->has('name') ? 'has-danger' : ''}}">
        {{ Form::label('name', 'Name', ['class' => 'control-label']) }}
        {{ Form::text('name', null, ['class' => 'form-control'])}}
        {!! $errors->first('name', '<p class="form-control-feedback">:message</p>') !!}
    </div>
    <div class="form-group {{$errors->has('email') ? 'has-danger' : ''}}">
        {{ Form::label('email', 'Email', ['class' => 'control-label']) }}
        {{ Form::text('email', null, ['class' => 'form-control'])}}
        {!! $errors->first('email', '<p class="form-control-feedback">:message</p>') !!}
    </div>
    <div class="form-group {{$errors->has('password') ? 'has-danger' : ''}}">
        {{ Form::label('password', 'Password', ['class' => 'control-label']) }}
        {{ Form::password('password', ['class' => 'form-control'])}}
        {!! $errors->first('password', '<p class="form-control-feedback">:message</p>') !!}
    </div>
    <div class="form-group">
        {{Form::submit('Register', ['class' => 'btn btn-primary btn-block btn-round'])}}
    </div>
    {!! Form::close() !!}
@endsection