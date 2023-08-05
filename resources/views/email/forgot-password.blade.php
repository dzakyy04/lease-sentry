<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}">
    <!-- Page Title  -->
    <title>Payowasdal | Reset Password</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{ asset('assets/css/dashlite.css?ver=3.0.3') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/theme.css?ver=3.0.3') }} ">
    <link rel="stylesheet" href="{{ asset('assets/css/style-email.css') }}">
</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-wrap ">
                <div class="nk-content ">
                    <div class="container-fluid">
                        <table class="email-wraper">
                            <tr>
                                <td class="py-5">
                                    <table class="email-header">
                                        <tbody>
                                            <tr>
                                                <td class="text-center pb-4">
                                                    <a href="#">
                                                        <img class="email-logo"
                                                            src="{{ asset('assets/images/logo-kpknl.png') }}"
                                                            alt="logo">
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="email-body text-center">
                                        <tbody>
                                            <tr>
                                                <td class="px-3 px-sm-5 pt-3 pt-sm-5 pb-3">
                                                    <h2 class="email-heading">Reset Password</h2>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-3 px-sm-5 pb-2">
                                                    <p>Halo Pengguna Lease Sentry</p>
                                                    <p>Klik tombol dibawah untuk reset password anda.
                                                    </p>
                                                    <a href="{{ route('reset-password.view', $token) }}"
                                                        class="email-btn">RESET
                                                        PASSWORD</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-3 px-sm-5 pt-4">
                                                    <p>Jika anda tidak membuat permintaan ini, abaikan pesan ini.</p>
                                                    <p class="email-note">Ini adalah email yang dibuat
                                                        secara otomatis, tolong jangan balas email ini.
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <hr>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-3 px-sm-5 pb-3 pb-sm-5">
                                                    <p class="email-note">Jika anda mengalami masalah saat mengklik
                                                        tombol "RESET PASSWORD", salin dan tempel URL ini ke web browser
                                                        anda:
                                                        <a class="text-decoration-underline"
                                                            href="{{ route('reset-password.view', $token) }}">{{ route('reset-password.view', $token) }}</a>
                                                    </p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="email-footer">
                                        <tbody>
                                            <tr>
                                                <td class="text-center pt-4">
                                                    <p class="email-copyright-text">Copyright © 2023
                                                        KPKNL. Seluruh hak cipta dilindungi.
                                                    </p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript -->
    <script src="{{ asset('assets/js/bundle.js?ver=3.0.3') }}"></script>
    <script src="{{ asset('assets/js/scripts.js?ver=3.0.3') }}"></script>
</body>

</html>
