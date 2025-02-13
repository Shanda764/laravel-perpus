@extends('layouts.app')
@section('content')
<style>
    body {
        background: url('{{ asset('assets/img/skl.jpg') }}') no-repeat center center fixed;
        background-size: cover;
    }
</style>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg"
        style="width: 28rem; border-radius: 15px; overflow: hidden; backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.8);">
        <div class="card-header text-center bg-primary text-white py-4">
            <h3 class="mb-0">{{ __('Login') }}</h3>
        </div>

        <div class="card-body p-5">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                        placeholder="Enter your email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password" placeholder="Enter your password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary btn-block py-2">
                        {{ __('Login') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection