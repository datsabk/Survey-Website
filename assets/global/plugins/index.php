<!DOCTYPE html>
<?php include 'config.php' ?>
<?php include 'includes.html' ?>
<?php

class Template{
public $templateName;
public $templateId;
public $templateViews;
public $templateURL;
public $templateImg;
}
$sql= "select * from template_details";

$url = 'frontend.php?templateId=';
$templateArray = array();


foreach ($db->query($sql) as $test)
			{
				$templateInstance = new Template();
				$templateInstance->templateName=$test["template_name"];
				$templateInstance->templateId=$test["template_id"];
				$templateInstance->templateViews=$test["template_views"];
				$templateInstance->templateURL=$url.'"'.$test["template_id"].'"';
				$templateInstance->templateImg = $test["imageUrl"];	
				$templateArray[] = $templateInstance;
			}

?>
<html>
  <head>
   <!-- <title>Survey Central</title>-->
        <title>Central</title>

	        <!-- BEGIN GLOBAL MANDATORY STYLES -->

<style>
.border-div{
background-color:#eee !important;
}
.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover{
background-color:#2196F3 !important;
}
.nav-tabs>li.active>a{
color:white !important;

}

a{
color:black !important;
margin-left:0px !important;
margin-bottom:0px !important;
}

.tabs-left.nav-tabs>li{
border:1px solid lightgray;
}
.fileUpload {
    position: relative;
    overflow: hidden;
    margin: 10px;
}
.fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}
</style> 
<meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
 </head>
<body class="border-div">
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-75050399-1', 'auto');
  ga('send', 'pageview');

</script>
<div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo" style="padding:22px;width: 300px;">
                    <a href="index.php"><span style="font-size: 25px; color: #32C5D2;">SATI Questionnaire</span>
                    <!--<img src="assets/layouts/layout4/img/Drawing1.png" />-->
                    </a>
                </div>
                <!-- END LOGO -->
                <div class="page-top">
                    <div style="padding:10px;float:right;margin-right: 20px;">

						<div class="fileUpload btn btn-circle green" style="margin-right: 1px;">
						<form method="POST" action="frontend.php" id="uploadForm" enctype="multipart/form-data">
						   <i class="fa fa-cloud-upload font-white fa-lg required"></i>
						   <input type="hidden" name="resume" value="true">
						    <input type="file" name="resumeFile" class="upload" onchange="resumeSurvey(this);" title="Resume Survey">

						</form>
						</div>
                        
						<a class="btn btn-circle" href="javascript:;" title="Contact us" style="background-color: #8BC34A !important;">
                            <i class="fa fa-phone font-white fa-lg"></i>
                        </a>
						<a class="btn btn-circle red" href="http://surveyproject.16mb.com/tellMeHow.php" title="Contact us">
                            <i class="fa fa-question font-white fa-lg" style="padding:1px"></i>
                        </a>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                
            </div>
</div>
			<div class="row"  style="margin-top:80px;">
				<div class="col-md-12" align="center" style="background-color:white;">
                            <?php
						$sqlHeadLine= "select * from news where type=1 order by 1 desc limit 1 ";
						foreach ($db->query($sqlHeadLine) as $testHL)
							{
							echo '<marquee  style="
    height: 20px;
padding:5px;margin-bottom:5px" onmouseover="this.stop();" onmouseout="this.start();" scrollamount="10" ><p style="font-size:14px;"> <a href="'.$testHL["url"].'" target="_blank" >'.$testHL["name"].'</a></p></marquee>';
							}
				?>
				</div>
			</div>
			
			<div class="row">	
                        
			<div class="col-md-8" style="float:left;padding:5px !important;">
                            
							<div class="portlet light portlet-fit bordered">
                                <div class="portlet-title" style="background:#32C5D2;">
                                    <div class="caption">
                                        <i class="icon-layers font-white"></i>
                                        <span class="caption-subject font-white bold uppercase">Surveys</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
									<div class="mt-element-card mt-element-overlay">
                                        <div class="row"  style="min-height:450px;">
										<div class="col-sm-12" style="
    margin-bottom: 10px;
"><b><a href="tellMeHow.php" >
    The <span style=" color: #32C5D2;" >SATI</span> is a comprehensive questionnaire based on a consolidation of common and unique Global OEM Supplier Registration Site and Questionnaire requirements.
  </a></b>
  </div>
								<?php 
								foreach($templateArray as $templateInstance)
								{ 
									?>
								
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                <div class="mt-card-item">
                                                    <div class="mt-card-avatar mt-overlay-1">
                                                        <img src="alogin/<?php echo $templateInstance->templateImg; ?>" style="height:160px;width:180px;">
                                                    </div>
                                                    <div class="mt-card-content">
														<a href='<?php echo $templateInstance->templateURL; ?>'>
                                                        <h3 class="mt-card-name"><?php echo $templateInstance->templateName; ?></h3>
														</a>
                                                        <p class="mt-card-desc font-grey-mint">Total Views: <?php echo $templateInstance->templateViews; ?></p>
                                                        
                                                    </div>
                                                </div>
                                    </div>
								<?php } ?>
								</div>
								</div>
								</div>
							</div>
            </div>
			<div class="col-md-4" style="padding:5px !important; ">
                            <div class="portlet light portlet-fit bordered">
                                <div class="portlet-title" style="background:#32C5D2;">
                                    <div class="caption" align="center">
                                        <i class="fa fa-newspaper-o font-white"></i>
                                        <span class="caption-subject font-white bold uppercase">Latest News</span>
                                    </div>
                                </div>
                                <div class="portlet-body" style="min-height:450px;">
							
							<!--<marquee style="min-height: 150px;" onmouseover="this.stop();" onmouseout="this.start();" direction="up" scrollamount="4" >-->
								
								<div data-spy="scroll" data-target=".navbar" data-offset="50">
								<div class="navbar"></div>
					<ul>
					
				<?php
						$sqlHeadLine= "select * from news where type=2 order by 1 desc ";
						$cntt=0;
						foreach ($db->query($sqlHeadLine) as $testHL)
							{
							echo '	<div class="container-fluid">	<li>
									<p style="font-size:14px;"> <a href="'.$testHL["url"].'" target="_blank" >'.$testHL["name"].'</a></p>
								</li></div>';
								$cntt++;
							}
							if($cntt==0){
							echo '<li>
									<h3> News coming soon</h3>
								</li>';
							}
				?>
								</ul>
								</div>
							<!--</marquee>-->
							</div>
            </div>

<script>
function resumeSurvey(src)
{
	document.getElementById("uploadForm").submit();
}
</script>


</body>

</html>	