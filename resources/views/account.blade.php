@extends('layouts.form')

@section('navbar_class', 'fixed-top navbar-transparent')

@section('content')
	<h3 class="title">
		<small>Hello</small><br>
		<span>{{Auth::user()->name}}</span>
	</h3>

	{!! Form::open(['route' => 'account.post']) !!}
	<div class="form-group {{$errors->has('name') ? 'has-danger' : ''}}">
		{{ Form::label('name', 'Name', ['class' => 'control-label']) }}
		{{ Form::text('name', Auth::user()->name, ['class' => 'form-control'])}}
		{!! $errors->first('name', '<p class="form-control-feedback">:message</p>') !!}
	</div>
	<div class="form-group {{$errors->has('password') ? 'has-danger' : ''}}">
		{{ Form::label('password', 'Current password', ['class' => 'control-label']) }}
		{{ Form::password('password', ['class' => 'form-control'])}}
		{!! $errors->first('password', '<p class="form-control-feedback">:message</p>') !!}
	</div>
	<div class="form-group {{$errors->has('new_password') ? 'has-danger' : ''}}">
		{{ Form::label('new_password', 'New password', ['class' => 'control-label']) }}
		{{ Form::password('new_password', ['class' => 'form-control'])}}
		{!! $errors->first('new_password', '<p class="form-control-feedback">:message</p>') !!}
	</div>
	<div class="form-group {{$errors->has('new_password_confirmation') ? 'has-danger' : ''}}">
		{{ Form::label('new_password_confirmation', 'Confirm password', ['class' => 'control-label']) }}
		{{ Form::password('new_password_confirmation', ['class' => 'form-control'])}}
		{!! $errors->first('new_password_confirmation', '<p class="form-control-feedback">:message</p>') !!}
	</div>
	<div class="form-group">
		{{Form::submit('Change', ['class' => 'btn btn-primary btn-block btn-round'])}}
	</div>
	{!! Form::close() !!}
@endsection
