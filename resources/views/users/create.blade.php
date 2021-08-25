@extends('app')

@section('content')
    <a href="/users" class="btn btn-primary mb-2">List of Users</a>
    <div class="card">
        <div class="card-header"><strong>Create a new user</strong></div>

        <div class="card-body">
            <form method="POST" action="/users">
                {{csrf_field()}}

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter a name..."
                           value="{{old('name')}}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="Enter an email..."
                           value="{{old('email')}}">
                </div>
                <div class="form-group">
                    <label for="roles">Roles</label>
                    <input type="text" class="form-control" name="roles" id="roles" placeholder="Enter roles..."
                           value="{{old('roles')}}">
                </div>
                <button class="btn btn-success" type="Submit" >Create User</button>
                <a href="/users" class="btn btn-danger float-right">Cancel</a>
            </form>
        </div>
    </div>
@endsection