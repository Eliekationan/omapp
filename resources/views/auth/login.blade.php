@extends('layouts.login')

@section('content')
<div  class="login-page">
    <div class="form">
        <div class="logo-section">
            <img width="100" src="{{asset('images/background-image.png')}}" alt="">
        </div>
        <div class="d-flex align-items-center justify-content-end">
            <div style="width:70%" class="form-head text-white">
                <h5>Bienvenue sur OMAPP</h5>
                {{-- <h6><i style="font-size: 12px">Excellente application de gestion d'organisations et mutuelles</i></h6> --}}
            </div>
        </div>
      <form class="login-form" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="d-flex align-items-center justify-content-between">
            <label for="email" class="form-label text-white">Email</label>
            <div style="width:70%" class="input-zone">
                <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="username"/>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <label for="password" class="form-label text-white">Password</label>
            <div style="width:70%" class="input-zone">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"/>
                @error('password')
                    <span class="invalid-feedback " role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="d-md-flex justify-content-end">
            <div  class="submit-btn" >
                <button type="submit" class="sub-btn" style="">login</button>
            </div>
            <div class="register-btn" >
                <a onclick="location.href='{{route('register')}}'" class="btn reg-btn">Creer un compte</a>
            </div>
            {{-- <p class="message">Not registered? <a href="#">Create an account</a></p> --}}
        </div>
      </form>
    </div>
  </div>

{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<style>
    .submit-btn{
            width: 33%;
            margin-right:12px; 
        }
        .register-btn{
            width: 35%;
        }
    @media screen and (max-width: 1064px) {
        .submit-btn{
            display: flex !important;
            width: 100%;
            justify-content: flex-end !important;
        }
        .register-btn{
            margin-top: 12px;
            display: flex !important;
            width: 100%;
            justify-content: flex-end !important;
        }
        .sub-btn{
            width: 70% !important;
        }
        .reg-btn{
            width: 70% !important;
        }
}
</style>

@endsection
