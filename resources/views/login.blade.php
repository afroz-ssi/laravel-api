@extends('layouts.main')
@section('title', 'User Login Page')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="form"
                    style="margin-top:20px; border-radius: 50px 15px;padding:20px; box-shadow: 0px 1px 10px 0px #dadada; border:3px dotted dodgerblue;">
                    <form class="" id="LoginForm">
                        <h3>User Login Using Laravel Api</h3>
                        <h5 id="msg" class="text-success text-center"></h5>
                        <h5 id="error" class="text-danger text-center"></h5>


                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" placeholder="Enter Email" />
                            <span class="text-danger error email_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="pass">Password</label>
                            <input type="text" class="form-control" name="password" placeholder="Enter Password" />
                            <span class="text-danger error password_error"></span>
                        </div>


                        <div class="form-group" style="display:flex; justify-content:space-between;">
                            <button type="submit" id="loginBtn" class="btn btn-success btn-xl">Login</button>
                            <span class="text-center">Create account ?<a href="{{ route('register') }}"> Here</a></span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3"></div>

        </div>

    </div>
@endsection
