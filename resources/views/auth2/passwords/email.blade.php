 @extends('layouts.authapp')

 @section('title')
     Reset Password
 @endsection

 @section('body')
     <div class="row justify-content-center">

         <div class="col-xl-10 col-lg-12 col-md-9">

             <div class="card o-hidden border-0 shadow-lg my-5">
                 <div class="card-body p-0">
                     @if (session('status'))
                         <div class="alert alert-success" role="alert">
                             {{ session('status') }}
                         </div>
                     @endif
                     <!-- Nested Row within Card Body -->
                     <div class="row">
                         <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                         <div class="col-lg-6">
                             <div class="p-5">
                                 <div class="text-center">
                                     <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                     <p class="mb-4">We get it, stuff happens. Just enter your email address below
                                         and we'll send you a link to reset your password!</p>
                                 </div>
                                 <form class="user" method="POST" action="{{ route('password.email') }}">
                                     @csrf

                                     <div class="row mb-3">
                                         <label for="email"
                                             class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                         <div class="col-md-6">
                                             <input id="email" type="email"
                                                 class="form-control @error('email') is-invalid @enderror" name="email"
                                                 value="{{ old('email') }}" required autocomplete="email" autofocus>

                                             @error('email')
                                                 <span class="invalid-feedback" role="alert">
                                                     <strong>{{ $message }}</strong>
                                                 </span>
                                             @enderror
                                         </div>
                                     </div>

                                     <div class="row mb-0">
                                         <div class="col-md-6 offset-md-4">
                                             <button type="submit" class="btn btn-primary">
                                                 {{ __('Send Password Reset Link') }}
                                             </button>
                                         </div>
                                     </div>
                                 </form>
                                 <hr>
                                 <div class="text-center">
                                     <a class="small" href="register.html">Create an Account!</a>
                                 </div>
                                 <div class="text-center">
                                     <a class="small" href="login.html">Already have an account? Login!</a>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>

         </div>

     </div>


     
 @endsection
