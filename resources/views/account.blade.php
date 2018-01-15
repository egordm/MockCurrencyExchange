@extends('layouts.default')

@section('content')
    <section class="section section-gray text-center">
        <h1>{{Auth::user()->name}}</h1>
            <form method="POST" action="/account">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="new-name">new Name:</label>
                    <input type="text" class="form-control" id="new-name" name="new-name" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>

    </section>

@endsection
