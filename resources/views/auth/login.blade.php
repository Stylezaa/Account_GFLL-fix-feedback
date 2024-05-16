@extends('master.auth')
@section('title','LOGIN')
@section('content')
<section class="form-02-main">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="_lk_de">
            <div class="form-03-main">
              <div class="logo">
                <img src="assets/images/user.png">
              </div>
              <form method="POST" action="{{ route('login') }}">
                @csrf
                    <div class="form-group">
                        <input id="email" type="email" name="email" class="form-control _ge_de_ol @error('email') is-invalid @enderror"  placeholder="Enter Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input id="password" type="password" name="password" class="form-control _ge_de_ol @error('password') is-invalid @enderror" type="text" placeholder="Enter Password" required autocomplete="current-password">
                        @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                    <div class="checkbox form-group">
                        <div class="form-check" style="color: white">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="">
                            Remember me
                        </label>
                        </div>
                        <a href="#"></a>
                    </div>

                    <div class="form-group">
                        {{-- <div class="_btn_04"> --}}
                            <button type="submit" class="_btn_04">
                                {{ __('Login') }}
                            </button>
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        {{-- <a href="#">Login</a> --}}
                        {{-- </div> --}}
                    </div>
              </form>
              <div class="form-group nm_lk"><p></p></div>

              <div class="form-group pt-0">
                <div class="_social_04">
                  <ol>
                    <li><i class="fa fa-facebook"></i></li>
                    <li><i class="fa fa-twitter"></i></li>
                    <li><i class="fa fa-google-plus"></i></li>
                    <li><i class="fa fa-instagram"></i></li>
                    <li><i class="fa fa-linkedin"></i></li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
    
@endsection
