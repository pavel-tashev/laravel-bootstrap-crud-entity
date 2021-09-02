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
                </div>
            @endif

            <form method="POST" action="/users/{{$user->id}}/edit">
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
                    <select name="roles[]" id="roles" class="form-control selectpicker" data-live-search="true"
                            multiple>
                        @foreach($roles as $role)
                            <option value="{{$role->id}}" {{
                                in_array(
                                    $role->id,
                                    array_map(function($role) { return $role['id']; }, $user->roles->toArray())
                                ) ? 'selected' : ''
                            }}>{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-success" type="Submit" >Save</button>
                <a href="/users" class="btn btn-danger float-right">Close</a>
            </form>
        </div>
    </div>

    <script>
        window.onload = function() {
            $('.selectpicker').selectpicker();
        };
    </script>
@endsection