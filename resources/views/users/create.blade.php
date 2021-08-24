@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><strong>Add a new user</strong></div>

                    <div class="card-body">
                        <form method="POST" action="/users">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter a name for your user">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="email" id="email" placeholder="Enter a email for your user">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="roles" id="roles" placeholder="Enter roles for your user">
                            </div>
                            <button class="btn btn-primary" type="Submit" >Add User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection