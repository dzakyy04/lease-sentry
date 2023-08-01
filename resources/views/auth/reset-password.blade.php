<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}">
    <!-- Page Title  -->
    <title>Lease Sentry | Reset Password</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{ asset('assets/css/dashlite.css?ver=3.0.3') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/theme.css?ver=3.0.3') }} ">
</head>

<body class="nk-body bg-white npc-default pg-auth">
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-wrap nk-wrap-nosidebar">
                <div class="nk-content">
                    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                        <div class="brand-logo text-center">
                            <a href="#" class="logo-link">
                                <img class="logo-light logo-img logo-img-lg"
                                    src="{{ asset('assets/images/logo-kpknl.png') }}" alt="logo">
                                <img class="logo-dark logo-img logo-img-lg"
                                    src="{{ asset('assets/images/logo-kpknl.png') }}" alt="logo-dark">
                            </a>
                        </div>
                        <div class="card">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Reset Password</h4>
                                        <div class="nk-block-des">
                                            <p>Silahkan atur ulang password anda.</p>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('reset-password.action') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="email">Email</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="text"
                                                class="form-control form-control-lg @error('email')
                                                is-invalid
                                            @enderror"
                                                id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email anda">
                                            @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">Password baru</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a href="#" class="form-icon form-icon-right passcode-switch lg"
                                                data-target="password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password"
                                                class="form-control form-control-lg @error('password')
                                                error
                                            @enderror"
                                                id="password" name="password"
                                                placeholder="Masukkan password baru anda">
                                            @error('password')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password_confirmation">Konfirmasi
                                                Password</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a href="#" class="form-icon form-icon-right passcode-switch lg"
                                                data-target="password_confirmation">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password"
                                                class="form-control form-control-lg @error('password_confirmation')
                                                error
                                            @enderror"
                                                id="password_confirmation" name="password_confirmation"
                                                placeholder="Masukkan konfirmasi password">
                                            @error('password_confirmation')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-primary btn-block">Reset
                                            Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/bundle.js?ver=3.0.3') }}"></script>
    <script src="{{ asset('assets/js/scripts.js?ver=3.0.3') }}"></script>
    <script src="{{ asset('assets/js/example-toastr.js?ver=3.0.3') }}"></script>
    @if (session()->has('error'))
        <script>
            let message = @json(session('error'));
            NioApp.Toast(`<h5>Error</h5><p>${message}</p>`, 'error', {
                position: 'top-right',
            });
        </script>
    @endif

</html>
