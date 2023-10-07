@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row d-flex justify-content-center my-4">
            <div class="col-md-6">
                <form action="{{ route('submitLogin') }}" method="post" id="loginForm" enctype="multipart/form-data">
                    @if (Session::has('status'))
                        <p class="alert alert-danger">{{ Session::get('status') }}</p>
                    @endif
                    <!-- Email input -->
                    @csrf
                    <div class="form-outline">
                        <input type="email" id="email" name="email" class="form-control" />
                        <label class="form-label" for="form2Example1">Email</label>
                    </div>

                    @error('email')
                        <span class="text-danger mb-4" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <!-- Password input -->
                    <div class="form-outline mt-4">
                        <input type="password" id="password" name="password" class="form-control" />
                        <label class="form-label" for="password">Password</label>
                    </div>

                    @error('password')
                        <span class="text-danger mb-4" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <!-- 2 column grid layout for inline styling -->
                    <div class="row my-4">
                        <div class="col">
                            <!-- Checkbox -->
                            <div class="form-check">
                                <input class="form-check-input" value="1" type="checkbox" name="remember"
                                    value="" id="form2Example31" />
                                <label class="form-check-label" for="form2Example31"> Remember me </label>
                            </div>
                        </div>
                    </div>

                    <!-- Submit button -->
                    {{-- <button type="button" class="btn btn-primary btn-block mb-4">Sign in</button> --}}
                    <input type="submit" class="btn btn-primary btn-block mb-4" value="Sign in">

                    <!-- Register buttons -->
                    <div class="text-center">
                        <p>Not a member? <a href="{{ route('register') }}">Register</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </div>
@endsection

