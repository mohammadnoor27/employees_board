@extends('layouts.app')
@section('content')

<div class="main-content">
    <div class="wrap-content container" id="container">
        <!-- start: PAGE TITLE -->
        <section id="page-title">
            <div class="row">
                <div class="col-sm-8">
                    <h1 class="mainTitle">Employee | Edit Contact Details</h1>
                </div>
            </div>
        </section>
        <!-- end: PAGE TITLE -->
        <!-- start: BASIC EXAMPLE -->
        <div class="container-fluid container-fullw bg-white">
            <div class="row">
                <div class="col-md-12">
                    <form
                        action="{{ route('new.employee') }}"
                        id="user_edit_form" method="post" class="form-horizontal">
                        @csrf
                        @if ($message = Session::get('edit_user_status'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                        @endif
                        <input type="hidden" name="id" value="{{$data->id}}"/>

                        <div class="form-body">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                You have some errors. Please check below.
                            </div>
                            <div class="alert alert-success display-hide">
                                <button class="close" data-close="alert"></button>
                                User added successfully, you can add new one or close this form.
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Is active ?</label>
                                <div class="col-md-12">
                                    @if($data->is_active == 1)
                                    <input type="checkbox" name="employee_is_active" value="{{$data->is_active}}" checked>
                                    @else
                                    <input type="checkbox" name="employee_is_active" value="{{$data->is_active}}">
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Name <span class="required">
                                    * </span>
                                </label>

                                <div class="col-md-12">
                                    <input type="text" name="name" data-required="1" class="form-control" value="{{$data->name}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Email <span class="required">
                                    * </span>
                                </label>

                                <div class="col-md-12">
                                    <input type="email" name="email" data-required="1" class="form-control" value="{{$data->email}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Phone Number <span class="required">
                                    * </span>
                                </label>

                                <div class="col-md-12">
                                    <input type="text" name="phone_number" data-required="1" class="form-control" value="{{$data->phone_number}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Job Title <span class="required">
                                    * </span>
                                </label>

                                <div class="col-md-12">
                                    <input type="text" name="job_title" data-required="1" class="form-control" value="{{$data->job_title}}"/>
                                </div>
                            </div>
                            <div class="h-100 d-flex align-items-center justify-content-center">
                                <button type="submit" class="btn btn-primary btn-sm"
                                        style="padding-left: 2.5rem; padding-right: 2.5rem;">Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
