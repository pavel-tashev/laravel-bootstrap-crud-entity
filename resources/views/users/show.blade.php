@extends('app')

@section('content')
    <a href="/users" class="btn btn-primary mb-2">List of Users</a>
    <div class="card">
        <div class="card-header"><strong>View user</strong></div>

        <div class="card-body">
            <form>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" disabled
                           placeholder="Enter a name..." value="{{$user->name}}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" id="email" disabled
                           placeholder="Enter an email..." value="{{$user->email}}">
                </div>
                <div class="form-group">
                    <label for="roles">Roles</label>
                    <input type="text" class="form-control" name="roles" id="roles" disabled
                           placeholder="Enter roles..." value="{{ $user->roles->pluck('name')->implode(', ') }}">
                </div>
            </form>

            <a href="/users/{{$user->id}}/edit" class="btn btn-primary">Edit</a>
            <form class="float-right" method="POST" action="/users/{{$user->id}}">
                {{csrf_field()}}
                {{method_field('DELETE')}}
                <button class="btn btn-danger" type="submit">Delete</button>
            </form>
        </div>
    </div>
@endsection