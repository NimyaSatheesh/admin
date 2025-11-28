
@extends('admin.layouts.guest')

@section('content')
   
    <h2 class="fw-bold text-center fs-18">Sign In</h2>
    <p class="text-muted text-center mt-1 mb-4">Enter your email address and password to access admin panel.</p>

    <div class="px-4">
        <form method="POST" action="{{ route('login') }}" class="authentication-form">
            @csrf

            <div class="mb-3">
                    <label class="form-label" for="example-email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" :value="old('email')" placeholder="Enter your email">
                    @error('email')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
            </div>
            <div class="mb-3">
                    <a href="auth-password.html" class="float-end text-muted text-unline-dashed ms-1">Reset password</a>
                    <label class="form-label" for="example-password">Password</label>
                    <input type="password" id="password"  name="password" class="form-control" placeholder="Enter your password">
                    @error('password')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
            </div>
            <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="checkbox-signin">
                        <label class="form-check-label" for="checkbox-signin">Remember me</label>
                    </div>
            </div>

            <div class="mb-1 text-center d-grid">
                <button class="btn btn-primary" type="submit">Sign In</button>
            </div>
        </form>
     
    @push('content')
    <p class="mb-0 text-center">New here? <a href="{{route('register')}}" class="text-reset fw-bold ms-1">Sign Up</a></p>

    @endpush

@endsection
