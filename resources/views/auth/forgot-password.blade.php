<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}">
    <!-- Page Title  -->
    <title>Lease Sentry | {{ $title }}</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{ asset('assets/css/dashlite.css?ver=3.0.3') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/theme.css?ver=3.0.3') }} ">
</head>

<body class="nk-body bg-white npc-default pg-auth">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                        <div class="brand-logo pb-4 text-center">
                            <a href="html/index.html" class="logo-link">
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
                                        <h5 class="nk-block-title">Reset password</h5>
                                        <div class="nk-block-des">
                                            <p>Jika anda lupa password, kami akan mengirimkan link untuk mengatur ulang
                                                password ke email anda.</p>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('forgot-password.send') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="email">Email</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="email"
                                                class="form-control form-control-lg @error('email')
                                                is-invalid
                                            @enderror"
                                                id="email" name="email"
                                                placeholder="Contoh: myemail123@gmail.com">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-primary btn-block">Kirim Link ke Email</button>
                                    </div>
                                </form>
                                <div class="form-note-s2 text-center pt-4">
                                    <a href="{{ route('login') }}"><strong>Kembali ke halaman login</strong></a>
                                </div>
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
    @error('email')
        <script>
            let message = "{{ $message }}"
            NioApp.Toast(`<h5>Error</h5><p>${message}</p>`, 'error', {
                position: 'top-right',
            });
        </script>
    @enderror
    @if (session()->has('success'))
        <script>
            let message = @json(session('success'));
            NioApp.Toast(`<h5>Berhasil</h5><p>${message}</p>`, 'success', {
                position: 'top-right',
            });
        </script>
    @endif

</html>
