<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no"/>

    <link rel="icon" type="image/png" href="{{ asset('backend/assets/img/favicon-16x16.png') }}" sizes="16x16">
    <link rel="icon" type="image/png" href="{{ asset('backend/assets/img/favicon-32x32.png') }}" sizes="32x32">

    <title>Login</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="{{ asset('backend/bower_components/uikit/css/uikit.almost-flat.min.css') }}"/>

    <link rel="stylesheet" href="{{ asset('backend/assets/css/login_page.min.css') }}">

    <style type="text/css">
        body.login_page {
            background-image: url({{ asset('backend/assets/img/login_bg.jpg') }});
            background-size: 100%;
            padding-top: 15%;
        }
    </style>

</head>
<body class="login_page">

    <div class="login_page_wrapper">
        <div class="md-card" id="login_card">
            <div class="md-card-content large-padding" id="login_form">
                <div class="login_heading">
                    <h2>Login</h2>
                </div>
                <form  method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="uk-form-row">
                        <label for="email">Email</label>
                        <input class="md-input @error('email') md-input-danger @enderror" type="text" id="email" name="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="uk-text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="uk-form-row">
                        <label for="password">Password</label>
                        <input class="md-input @error('password') md-input-danger @enderror" type="password" id="password" name="password" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="uk-text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="uk-margin-medium-top">
                        <span class="icheck-inline">
                            <input type="checkbox" data-md-icheck name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember" class="inline-label">Stay signed in</label>
                        </span>
                    </div>
                    <div>
                        <button type="submit" class="md-btn md-btn-primary md-btn-block md-btn-large">Sign In</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('backend/assets/js/common.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/uikit_custom.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/altair_admin_common.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/login.min.js') }}"></script>

</body>

</html>