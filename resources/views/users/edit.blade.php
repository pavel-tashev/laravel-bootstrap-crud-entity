@extends('app')

@section('content')
    <a href="/users" class="btn btn-primary mb-2">List of Users</a>
    <div class="card">
        <div class="card-header"><strong>Edit user</strong></div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br />
            @endif

            <form method="POST" action="/users/{{$user->id}}">
                {{csrf_field()}}
                {{method_field('PUT')}}
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter a name..."
                           value="{{$user->name}}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="Enter an email..."
                           value="{{$user->email}}">
                </div>
                <div class="form-group">
                    <label for="roles">Roles</label>
                    <input type="text" class="form-control" name="roles" id="roles" placeholder="Enter roles..."
                           value="{{$user->roles}}">
                </div>
                <button class="btn btn-success" type="Submit" >Save</button>
                <a href="/users" class="btn btn-danger float-right">Cancel</a>
            </form>
        </div>
    </div>
@endsection