<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Winner">
    <meta name="keyword" content="winner, gestion, vente, unites, Responsive, Fluid">
    <title>Login</title>

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link href="{{ asset('css/style-responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/jquery.gritter.css') }}" rel="stylesheet" /> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" />
    {{-- <link href="https://fonts.googleapis.com/css2?family=PT+Serif&display=swap" rel="stylesheet"> --}}


</head>

<body>
    <div id="login-page">
        <div class="container">
            <form class="form-login" action="{{ route('login.authenticate') }}" method="POST">
                @csrf
                <h2 class="form-login-heading">Login</h2>
                <div class="login-wrap">
                    <div class="form-group">
                        @if (\Session::has('message'))
                            <div style="text-align: center" class="alert alert-danger">{{ \Session::get('message') }}
                            </div>
                        @endif
                        <label for="username">Username</label>
                        <input type="text" class="form-control btn-round" name="username" placeholder="Username"
                            autofocus>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control btn-round" name="password" placeholder="Password">
                    </div>
                    <button style="background: #0063AA;" class="btn btn-block text-white btn-round" href=""
                        type="submit"><i class="fa fa-lock"></i> SIGN IN</button>
                    <label class="checkbox">
                        <span class="pull-right">
                            <a href="#"> Forgot Password?</a>
                        </span>
                    </label> <br>
                    <hr>
                    <div class="registration">
                        Don't have an account yet?<br />
                        <a class="" href="#">
                            Create an account
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal"
        class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Forgot Password ?</h4>
                </div>
                <div class="modal-body">
                    <p>Entrez votre adresse e-mail ci-dessous pour réinitialiser votre mot de passe.</p>
                    <form method="POST">
                        <input type="text" name="recup_mail" placeholder="Email" autocomplete="off"
                            class="form-control placeholder-no-fix btn-round"> <br>
                        <input class="btn btn-info" type="submit" name="recup_submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src=" {{ asset('lib/jquery.backstretch.min.js') }}"></script>
    <script>
        $.backstretch("{{ asset('img/login.jpg') }}", {
            speed: 500
        });
    </script>
</body>

</html>
