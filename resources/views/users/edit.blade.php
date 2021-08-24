@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><strong>Update user</strong></div>

                    <div class="card-body">
                        <form method="POST" action="/users/{{$user->id}}">
                            {{csrf_field()}}
                            {{method_field('PUT')}}
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter a name for your user" value="{{$user->name}}">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="email" id="email" placeholder="Enter a email for your user" value="{{$user->email}}">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="roles" id="roles" placeholder="Enter roles for your user" value="{{$user->roles}}">
                            </div>
                            <button class="btn btn-primary" type="Submit" >Save</button>
                        </form>
                    </div>
                </div>

                @if(count($errors))
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <li>
                                {{$error}}
                            </li>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection