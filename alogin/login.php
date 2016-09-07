<!DOCTYPE HTML> 
<html lang="en">
    <head>
		<meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        
        <link rel="shortcut icon" href="../favicon.ico"> 

<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="../assets/global/css/components-md.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="../assets/global/css/plugins-md.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="../assets/layouts/layout3/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/layouts/layout3/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="../assets/layouts/layout3/css/custom.min.css" rel="stylesheet" type="text/css" />

		<script src="js/modernizr.custom.63321.js"></script>
		<script src="../jquery-2.2.0.min.js"></script>
		<style>
			@import url(http://fonts.googleapis.com/css?family=Ubuntu:400,700);
			body {
			background: -moz-linear-gradient(50deg, rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url(images/blur.jpg) no-repeat center fixed;
			background: -ms-linear-gradient(50deg, rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url(images/blur.jpg) no-repeat center fixed;
			background: -o-linear-gradient(50deg, rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url(images/blur.jpg) no-repeat center fixed;
			background: -webkit-linear-gradient(50deg, rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url(images/blur.jpg) no-repeat center fixed;

				-webkit-background-size: cover;
				-moz-background-size: cover;
				background-size: cover;
			}
			.container > header h1,
			.container > header h2 {
				color: #fff;
				text-shadow: 0 1px 1px rgba(0,0,0,0.7);
			}
		</style>
    </head>
	<body>


<div id="Sign-In"> 
 <div class="col-sm-4 container"  >
 </div>
 <div class="col-sm-4 container" >
			
			<section class="main" style="background:rgba(255,255,255,0.9);margin:15% auto;"">
			<div align="center" style="padding-top:10px;">
			<img style="width:200px; height:200px;padding:20px;" src="images/surveys.png"></img>
			<h1 style="color:black;"> Survey Central </h1>
			</div>
										<div class="portlet-body form">
                                            <form role="form">
                                                <div class="form-body">
                                                    <div class="form-group">
                                                    
													<div class="form-group form-md-line-input has-info" id = "dUsername">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-user" style="color:gray;"></i>
                                                    </span>
                                                    <input type="text" id="username" class="form-control" placeholder="Username">
                                                    <label for="form_control_1">Username</label>
                                                </div>
                                            </div>
													<div class="has-error">
                                                    <span style="display:none;" class="help-block" id="susername">Please enter username</span>
													</div>
                                                    <div class="form-group">
                                                        <div class="form-group form-md-line-input has-info" id = "dPassword">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-key" style="color:gray;"></i>
                                                    </span>
                                                    <input type="password" id="password" class="form-control" placeholder="Username">
                                                    <label for="form_control_1">Password</label>
                                                </div>
                                            </div>
														<div class="has-error">
														<span style="display:none;" class="help-block" id="spassword">Please enter password</span>
														</div>
                                                    </div>
													<div class="has-error" style="padding:10px;display:none;" id='invDetails'>
														<span  class="help-block">Incorrect Username or Password</span>
													</div>
												</div>
												<div align="center" style="padding-bottom: 20px">
													<a class="btn btn-lg btn-primary" href="javascript:login();"> Login <i class="fa fa-sign-in font-white"></i></a>
												</div>
												
											</form>
										</div>

			</section>
			
        </div>
		
		 <div class="col-sm-4 container"  >
		 </div>
</div> 
<style>

</style>
<script>

function login()
{
	if(validate())
	{
		var username=$('#username').val();
		var password = $('#password').val();
		$.ajax({
		type:'POST',
		data:"username="+username+"&password="+password,
		url:'checkuser.php',
		success:function(data){
			if(data == 1)
			{
				window.location.href='template.php';
				$('#invDetails').hide();
			}
			else
				$('#invDetails').show();
			
			
		}
	});
	}


}

function validate()
{
	var flag= false;
	if($('#username').val()=="")
	{
		$('#dusername').addClass("has-error");
		$('#susername').show();
	}
	else
	{
		$('#dusername').removeClass("has-error");
		$('#susername').hide();
		flag = true;
	}
	if($('#password').val()=="")
	{
		$('#dpassword').addClass("has-error");
		$('#spassword').show();
	}
	else
	{	
		$('#dpassword').removeClass("has-error");
		$('#spassword').hide();
		flag =flag && true;
	}
	return flag;
}
</script>
</body> 
</html> 	