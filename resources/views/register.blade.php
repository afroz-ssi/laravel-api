@extends('layouts.main')
@section('title', 'User Login Page')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="form"
                    style="margin-top:20px; border-radius: 15px 50px;padding:20px; box-shadow: 0px 1px 10px 0px #dadada; border:3px dotted dodgerblue;">
                    <form class="" id="registerForm">
                        <h3>User Registration Using Laravel Api</h3>
                        <h5 id="msg" class="text-success text-center"></h5>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="username" placeholder="Enter Name" />
                            <span class="text-danger error username_error"></span>
                        </div>
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
                        <div class="form-group">
                            <label for="name">Confirm Password</label>
                            <input type="text" class="form-control" name="password_confirmation"
                                placeholder="Enter Confirm Password" />
                            <span class="text-danger error password_confirmation_error"></span>
                        </div>

                        <div class="form-group" style="display:flex; justify-content:space-between;">
                            <button type="submit" id="regBtn" class="btn btn-success btn-xl">Create account</button>
                            <span class="text-center">Already account?<a href="{{ route('login') }}"> Login Here</a></span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3"></div>

        </div>

    </div>
@endsection
