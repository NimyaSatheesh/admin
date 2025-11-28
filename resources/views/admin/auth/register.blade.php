@extends('admin.layouts.guest')

@section('content')

<h2 class="fw-bold text-center fs-18">Sign Up</h2>
<p class="text-muted text-center mt-1 mb-4">New to our platform? Sign up now! It only takes a minute.</p>

    <div class="px-4">
        <form method="POST" action="{{ route('register.store') }}" class="authentication-form">
        @csrf

            <div class="mb-3">
                <label class="form-label" for="example-name">Name</label>
                <input type="name" id="name" name="name" class="form-control" placeholder="Enter your name">
                @error('name')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="example-email">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email">
                @error('email')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="example-password">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password">
            </div>
            <div class="mb-3">
                <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="checkbox-signin">
                        <label class="form-check-label" for="checkbox-signin">I accept Terms and Condition</label>
                </div>
            </div>

            <div class="mb-1 text-center d-grid">
                <button class="btn btn-primary" type="submit">Sign Up</button>
            </div>
        </form>
  

    @push('content')
    <p class="mb-0 text-center">I already have an account <a href="{{route('login')}}" class="text-reset fw-bold ms-1">Sign In</a></p>

    @endpush
@endsection