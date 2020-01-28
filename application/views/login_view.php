<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <base href="<?php echo site_url('/'); ?>">
    <meta charset="utf-8" />
    <title>KPN CROP | Cash Flow System</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="<?php echo base_url()?>/assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
    <link href="<?php echo base_url()?>/assets/plugins/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url()?>/assets/plugins/font-awesome/5.0/css/fontawesome-all.min.css" rel="stylesheet" />
    <link href="<?php echo base_url()?>/assets/plugins/animate/animate.min.css" rel="stylesheet" />
    <link href="<?php echo base_url()?>/assets/css/default/style.min.css" rel="stylesheet" />
    <link href="<?php echo base_url()?>/assets/css/default/style-responsive.min.css" rel="stylesheet" />
    <link href="<?php echo base_url()?>/assets/css/default/theme/default.css" rel="stylesheet" id="theme" />
    <!-- ================== END BASE CSS STYLE ================== -->

    <link href="<?= base_url()?>assets/fonts/aulianza-sans/aulianza-sans.css" rel="stylesheet">

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="<?php echo base_url()?>/assets/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
</head>
<body class="pace-top bg-white">
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade show"><span class="spinner"></span></div>
    <!-- end #page-loader -->
    
	<div class="login-cover">
	    <div class="login-cover-image" style="background-image: url(<?php echo base_url()?>/assets/img/login-bg/gama-tower.jpg)" data-id="login-cover-image"></div>
	    <div class="login-cover-bg"></div>
	</div>
	
	<!-- begin #page-container -->
	<div id="page-container" class="fade">
	    <!-- begin login -->
        <div class="login login-v2" data-pageload-addclass="animated fadeIn">
            <!-- begin brand -->
            <div class="login-header">
                <div class="brand">
                    <img src="<?= base_url()?>/assets/img/logo/kpn-logo.png" class="new-login-logo mb-1 mr-2"><b>KPN CORP</b>
                    <small>Cash Flow Web Applications</small>
                </div>
                <div class="icon">
                    <i class="fa fa-lock"></i>
                </div>
            </div>
            <!-- end brand -->
            <!-- begin login-content -->
            <div class="login-content">
                <form action="<?php echo site_url('login/aksi_login'); ?>" method="post">
                    <div class="form-group m-b-20">
                        <input type="username" type="text" name="username" class="form-control" placeholder="Username">
                    </div>
                    <div class="form-group m-b-20">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <div class="checkbox checkbox-css m-b-20">
                        <input type="checkbox" id="remember_checkbox" /> 
                        <label for="remember_checkbox">
                        	Remember Me
                        </label>
                    </div>
                    <div class="login-buttons">
                        <button type="submit" class="btn btn-success btn-block btn-lg">Login</button>
                    </div>
                    <div class="m-t-20">
                        Not a member yet? Click <a href="javascript:;">here</a> to register.
                    </div>
                </form>
            </div>
            <!-- end login-content -->
        </div>
        <!-- end login -->
        
        <ul class="login-bg-list clearfix">
			<li  class="active"><a href="javascript:;" data-click="change-bg" data-img="<?php echo base_url()?>/assets/img/login-bg/gama-tower.jpg" style="background-image: url(<?php echo base_url()?>/assets/img/login-bg/gama-tower.jpg)"></a></li>
            <li><a href="javascript:;" data-click="change-bg" data-img="<?php echo base_url()?>/assets/img/login-bg/xx.jpg" style="background-image: url(<?php echo base_url()?>/assets/img/login-bg/xx.jpg)"></a></li>
            <li><a href="javascript:;" data-click="change-bg" data-img="<?php echo base_url()?>/assets/img/login-bg/x.jpg" style="background-image: url(<?php echo base_url()?>/assets/img/login-bg/x.jpg)"></a></li>			
            <li><a href="javascript:;" data-click="change-bg" data-img="<?php echo base_url()?>/assets/img/login-bg/cemindo.jpg" style="background-image: url(<?php echo base_url()?>/assets/img/login-bg/cemindo.jpg)"></a></li>
            <li><a href="javascript:;" data-click="change-bg" data-img="<?php echo base_url()?>/assets/img/login-bg/xxxxx.jpg" style="background-image: url(<?php echo base_url()?>/assets/img/login-bg/xxxxx.jpg)"></a></li>			
            <li><a href="javascript:;" data-click="change-bg" data-img="<?php echo base_url()?>/assets/img/login-bg/xxx.jpg" style="background-image: url(<?php echo base_url()?>/assets/img/login-bg/xxx.jpg)"></a></li>
        </ul>
        
	</div>
	<!-- end page container -->
    <!-- ================== BEGIN BASE JS ================== -->
    <script src="<?php echo base_url()?>/assets/plugins/jquery/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url()?>/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?php echo base_url()?>/assets/plugins/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
   <!-- @*[if lt IE 9]>
            <script src="~/assets/crossbrowserjs/html5shiv.js"></script>
            <script src="~/assets/crossbrowserjs/respond.min.js"></script>
            <script src="~/assets/crossbrowserjs/excanvas.min.js"></script>
        <![endif]*@-->
    <script src="<?php echo base_url()?>/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url()?>/assets/plugins/js-cookie/js.cookie.js"></script>
    <script src="<?php echo base_url()?>/assets/js/theme/default.min.js"></script>
    <script src="<?php echo base_url()?>/assets/js/apps.min.js"></script>
    <!-- ================== END BASE JS ================== -->
	<script src="<?php echo base_url()?>/assets/js/demo/login-v2.demo.min.js"></script>
	
    <script>
        $(document).ready(function () {
            App.init();
			LoginV2.init();
        });
    </script>
</body>
</html>
