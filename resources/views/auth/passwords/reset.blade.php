@extends('layouts.header')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <!-- Password uniqueness validation -->
                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @if (session('password_uniqueness_error'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ session('password_uniqueness_error') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')
<script>
    // Password validation
    document.getElementById('password').addEventListener('input', function() {
        var password = this.value;
        var confirm_password = document.getElementById('password-confirm').value;

        var uppercaseRegex = /[A-Z]/;
        var numberRegex = /\d/;
        var specialCharacterRegex = /[!@#$%^&*()_+{}\[\]:;<>,.?~\\-]/;

        var isUppercaseValid = uppercaseRegex.test(password);
        var isNumberValid = numberRegex.test(password);
        var isSpecialCharacterValid = specialCharacterRegex.test(password);

        if (!isUppercaseValid || !isNumberValid || !isSpecialCharacterValid) {
            // Password does not meet the criteria
            this.setCustomValidity('Password must include an uppercase letter, a number, and a special character.');
        } else {
            this.setCustomValidity('');
        }

        if (password !== confirm_password) {
            // Password and confirm password do not match
            document.getElementById('password-confirm').setCustomValidity('Passwords do not match.');
        } else {
            document.getElementById('password-confirm').setCustomValidity('');
        }
    });

    // Confirm password validation
    document.getElementById('password-confirm').addEventListener('input', function() {
        var password = document.getElementById('password').value;
        var confirm_password = this.value;

        if (password !== confirm_password) {
            // Password and confirm password do not match
            this.setCustomValidity('Passwords do not match.');
        } else {
            this.setCustomValidity('');
        }
    });
</script>
</script>
