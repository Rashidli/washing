<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Focus - Bootstrap Admin Dashboard </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="/admin_assets/images/favicon.png">
    <link href="/admin_assets/css/style.css" rel="stylesheet">

</head>

<body class="h-100">
<div class="authincation h-100">
    <div class="container-fluid h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6">
                <div class="authincation-content">
                    <div class="row no-gutters">
                        <div class="col-xl-12">
                            <div class="auth-form">
                                <h4 class="text-center mb-4">Sign in your account</h4>
                                <form action="{{route('admin_submit')}}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label><strong>Email</strong></label>
                                        <input type="email" name="email" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Password</strong></label>
                                        <input type="password" name="password" class="form-control">
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-block">Sign me in</button>
                                    </div>
                                </form>
                                @if(session('danger'))
                                    <div class="text-danger danger">{{session('danger')}}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--**********************************
    Scripts
***********************************-->
<!-- Required vendors -->
<script src="/admin_assets/vendor/global/global.min.js"></script>
<script src="/admin_assets/js/quixnav-init.js"></script>
<script src="/admin_assets/js/custom.min.js"></script>

</body>

</html>
