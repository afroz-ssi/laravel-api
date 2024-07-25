@extends('layouts.main')
@section('title', 'User Profile Page')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="form"
                    style="margin-top:20px; border-radius: 15px 50px;padding:20px; box-shadow: 0px 1px 10px 0px #dadada; border:3px dotted dodgerblue;">
                    <h1 class="text-center">User Profile</h1>
                    <h2 class="text-center" id="loading"></h2>
                    <div class="profile" style="display:none; justify-content:space-around;">
                        <div>
                            <h3>Welcome <b id="name"></b></h3>
                            <span>
                                <p>Email : <b id="email"></b> <b id="v_email" class="text-success">(Unverified)</b>
                                </p>
                            </span>
                            <p>Last update : <b id="update"></b></p>
                            <a id="update_profile">Update profile</a>
                        </div>
                        <h3 class="logout mr-left">Logout</h3>
                        <h3 class="refresh btn btn-success">Refresh token</h3>
                    </div>
                    <b>
                        <p id="msg" class="text-success text-center"></p>
                    </b>
                    <form action="" id="updateProfileForm" style="display: none;">
                        <input type="hidden" class="id_error form-control" name="id" id="id" />
                        <div class="form-group">
                            <label for="Name">Name</label>
                            <input type="text" class="name_error form-control" placeholder="Name" name="name"
                                id="name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="email_error form-control" placeholder="Email" name="email"
                                id="email">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" id="updateProfBtn">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3"></div>

        </div>

    </div>
@endsection
