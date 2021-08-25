@extends('app')

@section('content')
    <a href="/users" class="btn btn-primary mb-2">List of Users</a>
    <div class="card">
        <div class="card-header"><strong>Create a new user</strong></div>

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
                    <select name="roles[]" id="roles" class="form-control selectpicker" data-live-search="true" multiple>
                        @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-success" type="Submit" >Create User</button>
                <a href="/users" class="btn btn-danger float-right">Cancel</a>
            </form>
        </div>
    </div>

    <script>
        window.onload = function() {
            $('.selectpicker').selectpicker();
        };
    </script>
@endsection