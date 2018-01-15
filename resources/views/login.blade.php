@extends ('layouts.default')

@section('content')
    <div class="col-sm-8 blog-main">
        <h1>Sign In</h1>

        <form action="/login" method="POST">
            {{csrf_field()}}


            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
@endsection