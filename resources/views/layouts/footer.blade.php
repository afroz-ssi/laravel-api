<script>
    let regBtn = document.getElementById('regBtn');
    let LoginBtn = document.getElementById('loginBtn');

    let URL = "http://127.0.0.1:8000/api/v1";
    $(document).ready(function() {

        // ====================================== User Registration  Start here =============

        $("#registerForm").submit(function(e) {
            e.preventDefault();
            let formData = $("#registerForm").serialize();
            regBtn.textContent = "Processing...";
            regBtn.disabled = true;
            $.ajax({
                url: `${URL}/registrations`,
                type: "POST",
                data: formData,
                success: function(response) {
                    $(".error").html("");
                    if (response.success === true && response.msg) {
                        $("#msg").text(response.msg);
                        $("#registerForm")[0].reset();
                    }
                },
                error: function(errors) {
                    regBtn.textContent = "Create account";
                    regBtn.disabled = false;
                    $(".error").html("");
                    ShowErrors(errors.responseJSON.errors);

                }
            })
        })
        // ====================================== User Login  Start here =============
        $("#LoginForm").submit(function(e) {
            e.preventDefault();
            let formData = $("#LoginForm").serialize();
            LoginBtn.textContent = "Login...";
            LoginBtn.disabled = true;
            $.ajax({
                url: `${URL}/login`,
                type: "POST",
                data: formData,
                success: function(response) {
                    LoginBtn.textContent = "Login";
                    LoginBtn.disabled = false;
                    $(".error").html("");
                    if (response.success === true) {
                        // $("#msg").text(response.msg);
                        localStorage.setItem("access_token", response.access_token);
                        $("#LoginForm")[0].reset();
                        window.open('profile', '_self');
                    } else {
                        $("#error").text(response.error);
                    }
                },
                error: function(errors) {
                    LoginBtn.textContent = "Login";
                    LoginBtn.disabled = false;
                    $(".error").html("");
                    ShowErrors(errors.responseJSON.errors);
                }
            })
        });


        //// ================= Logout  ===================
        $(".logout").on('click', function(e) {
            e.preventDefault();
            $.ajax({
                url: `${URL}/logout`,
                type: "GET",
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('access_token')
                },
                success: function(response) {
                    console.log(response);
                    if (response.success === true && response.msg) {
                        localStorage.removeItem("access_token");
                        window.open("/login", "_self");
                    } else if (response.success === false) {
                        alert(response.error);
                        localStorage.removeItem("access_token");
                        window.open("/login", "_self");
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            })
        })

        // ================================ Profile ==============

        let path = window.location.pathname;
        if (path == '/profile') {
            ProfileData();
        }
    });

    function ProfileData() {
        $(function() {
            $.ajax({
                url: `${URL}/profile`,
                type: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('access_token')
                },
                success: function(res) {
                    if (res && res.success == true) {
                        $("#loading").html('<h1>Loading...</h1>');
                        setTimeout(() => {
                            $("#loading").html('');
                            $(".profile").css('display', 'flex');
                            $('b#name').text(res.data.name);
                            $('b#email').text(res.data.email);
                            $('b#update').text(res.data.update_at);

                            $('input#id').val(res.data.id);
                            $('input#name').val(res.data.name);
                            $('input#email').val(res.data.email);

                            if (res.data.is_verified == 1) {
                                $('#v_email').text('(Verified)');
                            } else {
                                $('#v_email').text('(Unverified)');
                            }

                            // append email 
                            $('#v_email').attr('data-id', res.data.email);
                        }, 1000);
                    }
                },
                error: function(error) {
                    if (error.status === 401) {
                        console.log(error);
                        localStorage.removeItem("access_token");
                        window.open("/login", "_self");
                    }
                    // alert(error.responseJSON.message);
                }
            });
        })
    }
    // ======================== Show profile form ===========
    let updateProfileForm = document.getElementById('updateProfileForm');
    $("#update_profile").on('click', function() {
        // updateProfileForm.style.display = "inline";
        $("#updateProfileForm").toggle();
    });

    // ================== Verify email send ======================
    $("#v_email").on('click', function(e) {
        let email_id = $(this).attr('data-id');
        e.preventDefault();
        $.ajax({
            url: `${URL}/send-email-verify/${email_id}`,
            // url: `${URL}/send-email-verify/afrojbsc77@gmail.com`,
            type: "GET",
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('access_token')
            },
            success: function(res) {
                console.log(res);
                if (res.success == true) {
                    $("#msg").text(res.msg);
                    setTimeout(() => {
                        $("#msg").html("");
                    }, 5000);
                    // ProfileData();
                }
            },
            error: function(error) {
                console.log(error);
                if (error.status === 404 || error.status === 500) {
                    $("#msg").text(error.responseJSON.error);
                    $("#msg").css('color', 'red !important');
                }
            }
        });
    });


    // ===================== Update user profile ==============
    $("#updateProfileForm").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: `${URL}/update-profile`,
            type: "PUT",
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('access_token')
            },
            data: $("#updateProfileForm").serialize(),
            success: function(res) {
                if (res.success == true) {
                    $("#msg").text(res.msg);
                    setTimeout(() => {
                        $("#msg").html("");
                    }, 3000);
                    ProfileData();
                    updateProfileForm.style.display = "none";
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });


    // ===================== Refresh token ==========================
    $(".refresh").on('click', function() {
        $.ajax({
            url: `${URL}/refresh-token`,
            type: 'GET',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('access_token')
            },
            success: function(res) {
                if (res && res.success == true) {
                    localStorage.setItem('access_token', res.access_token);
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });


    function ShowErrors(errors) {
        $.each(errors, function(key, value) {
            $(`.${key}_error`).text(value);
        });
    }
</script>


</body>

</html>
