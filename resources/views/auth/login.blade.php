@extends('layout.master-mini')
@section('content')

<div class="content-wrapper d-flex align-items-center justify-content-center auth theme-one"
     style="background-image: url({{ url('assets/images/auth/login_1.jpg') }}); background-size: cover;">

  <div class="row w-100">
    <div class="col-lg-4 mx-auto">

      <div class="auto-form-wrapper">

        <form method="POST" action="{{ route('login') }}">
          @csrf

          <div class="form-group">
            <label class="label">Identifier</label>
            <div class="input-group">

              <input
                type="text"
                name="identifier"
                value="{{ old('identifier') }}"
                class="form-control"
                placeholder="Username / NIS / Email"
                required
              >

              <div class="input-group-append">
                <span class="input-group-text">
                  <i class="mdi mdi-account"></i>
                </span>
              </div>

            </div>
          </div>

          <div class="form-group">
            <label class="label">Password</label>
            <div class="input-group">

              <input
                type="password"
                name="password"
                class="form-control"
                placeholder="*********"
                required
              >

              <div class="input-group-append">
                <span class="input-group-text">
                  <i class="mdi mdi-lock"></i>
                </span>
              </div>

            </div>
          </div>

          {{-- error message --}}
          @if(session('error'))
            <div class="alert alert-danger">
              {{ session('error') }}
            </div>
          @endif

          @if($errors->any())
            <div class="alert alert-danger">
              {{ $errors->first() }}
            </div>
          @endif

          <div class="form-group">
            <button class="btn btn-primary submit-btn btn-block">
              Login
            </button>
          </div>

          <div class="form-group d-flex justify-content-between">
            <div class="form-check form-check-flat mt-0">
              <label class="form-check-label">
                <input type="checkbox" class="form-check-input" checked>
                Keep me signed in
              </label>
            </div>

            <a href="#" class="text-small forgot-password text-black">
              Forgot Password
            </a>
          </div>

        </form>

      </div>

      <ul class="auth-footer">
        <li><a href="#">Conditions</a></li>
        <li><a href="#">Help</a></li>
        <li><a href="#">Terms</a></li>
      </ul>

      <p class="footer-text text-center">
        copyright © 2018 Bootstrapdash. All rights reserved.
      </p>

    </div>
  </div>
</div>

@endsection