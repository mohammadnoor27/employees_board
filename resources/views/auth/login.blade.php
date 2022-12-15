@extends('layouts.app')
@section('content')

<body class="login">
<section class="vh-100">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="{{ asset('image/login_logo.svg') }}"
                     class="img-fluid"
                     alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <div class="col-sm-12">
                    <fieldset class="content-form">
                        <legend class="title-form">Login User</legend>
                        @if(Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{Session::get('error')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        @endif
                        <form action="{{ route('login.user') }}" method="post">
                            @csrf <!-- {{ csrf_field() }} -->

                            <div class="divider d-flex align-items-center my-4">
                                <p class="text-center fw-bold mx-3 mb-0">Sign In</p>
                            </div>

                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="email" name="email" id="form3Example3" class="form-control"
                                       placeholder="Enter a valid email address"/>
                                <label class="form-label" for="form3Example3">Email address</label>
                            </div>
                            @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <!-- Password input -->
                            <div class="form-outline mb-3">
                                <input type="password" name="password" id="form3Example4"
                                       class="form-control"
                                       placeholder="Enter password"/>
                                <label class="form-label" for="form3Example4">Password</label>
                            </div>
                            @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <div class="h-100 d-flex align-items-center justify-content-center">
                                <button type="submit" class="btn btn-primary btn-sm"
                                        style="padding-left: 2.5rem; padding-right: 2.5rem;">Login
                                </button>
                            </div>

                        </form>
                    </fieldset>
                </div>
            </div>
        </div>
</section>
</body>
@endsection
