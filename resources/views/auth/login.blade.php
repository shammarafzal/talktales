@extends('auth.layout.app')

@section('tab')
    <ul class="nav-border nav nav-pills" role="tablist">
        <li class="nav-item">
            <a class="nav-link active font-weight-semibold" data-toggle="tab" href="#LogIn_Tab" role="tab">Log In</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active p-3" id="LogIn_Tab" role="tabpanel">
            <form class="form-horizontal auth-form" method="post" action="{{ route('login') }}">
                @csrf
                <span class="text-sm" style="color: red">{{ $errors->first() }}</span>
                <div class="form-group mb-2">
                    <label for="name">Email</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="email" id="email" placeholder="Enter Email" value="{{ old('email') }}">
                    </div>
                </div><!--end form-group-->

                <div class="form-group mb-2">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
                    </div>
                </div><!--end form-group-->

                <div class="form-group row my-3">
                    <div class="col-sm-6">
                        <div class="custom-control custom-switch switch-success">
                            <input type="checkbox" class="custom-control-input" id="customSwitchSuccess">
                            <label class="custom-control-label text-muted" for="customSwitchSuccess">Remember me</label>
                        </div>
                    </div><!--end col-->
                </div><!--end form-group-->

                <div class="form-group mb-0 row">
                    <div class="col-12">
                        <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Log In <i class="fas fa-sign-in-alt ml-1"></i></button>
                    </div><!--end col-->
                </div> <!--end form-group-->
            </form><!--end form-->
        </div>
    </div>
@endsection
