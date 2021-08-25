@extends('app')

@section('content')
    <a href="users/create" class="btn btn-primary mb-2">Create User</a>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Roles</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->roles }}</td>
                    <td>
                        {{--<a href="users/{{$user->id}}" class="btn btn-primary">Show</a>--}}
                        <a href="users/{{$user->id}}/edit" class="btn btn-primary">Edit</a>
                        <form action="/users/{{$user->id}}" method="POST" class="d-inline">
                            {{ csrf_field() }}
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection