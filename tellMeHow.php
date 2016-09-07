<!DOCTYPE html>
<?php include 'config.php' ?>
<?php include 'includes.html' ?>
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
                <div class="page-logo" style="padding:28px;width: 300px;">
                    <a href="index.php"><span style="    font-size: 25px; color: #32C5D2;">SATI Questionnaire</span>
                    <!--<img src="assets/layouts/layout4/img/Drawing1.png" />-->
                    </a>
                </div>
                <!-- END LOGO -->
                <div class="page-top">
                    <div style="padding:10px;float:right;margin-right: 20px;" >

						<div class="fileUpload btn btn-circle green" >
						<form method="POST" action="frontend.php" id='uploadForm'  enctype="multipart/form-data" >
						   <i class="fa fa-cloud-upload font-white fa-lg required" ></i>
						   <input type='hidden' name='resume' value='true' />
						    <input type="file" name="resumeFile" class="upload" onchange="resumeSurvey(this);"  title="Resume Survey"/>

						</form>
						</div>
                        
						<a class="btn btn-circle red" href="javascript:;" title="Contact us">
                            <i class="fa fa-phone font-white fa-lg"></i>
                        </a>
						
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                
            </div>
</div>
			<div class="row"  style="margin-top:80px;">
				<div class="col-md-12" align="center" style="background-color:white;">
                           <h2> Introduction</h2>
						   <hr>
						 

<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:"Cambria Math";
	panose-1:2 4 5 3 5 4 6 3 2 4;}
@font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:10.0pt;
	margin-left:0in;
	line-height:115%;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";}
p
	{margin-right:0in;
	margin-left:0in;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
.MsoPapDefault
	{margin-bottom:10.0pt;
	line-height:115%;}
@page Section1
	{size:8.5in 11.0in;
	margin:1.0in 1.0in 1.0in 1.0in;}
div.Section1
	{page:Section1;}
-->
</style>

</head>

<body lang=EN-US>

<div style="text-align:left;margin-left:14px;" class=Section1>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal;background:white'><b><span style='color:#1F497D'>The SATI is a
comprehensive questionnaire based on a consolidation of common and unique
Global OEM Supplier Registration Site and Questionnaire requirements.</span></b></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal;background:white'><span style='font-size:10.0pt;font-family:"Arial","sans-serif";
color:#222222'>&nbsp;</span></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal;background:white'><b><span style='color:#1F497D'>&nbsp; &nbsp; &nbsp;
&nbsp; &nbsp;</span></b></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal;background:white'><span style='font-size:10.0pt;font-family:"Arial","sans-serif";
color:#222222'>&nbsp;</span></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal;background:white'><span style='color:#1F497D'>A variety of industry
sectors and OEMs were researched and their needs incorporated, including
Aerospace, Maritime, Land Vehicles&nbsp; and General Manufacturing.</span></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal;background:white'><b><span style='color:#1F497D'>When reviewing the SATI
questionnaire</span></b><span style='color:#1F497D'>: the Supplier is provided
with an overview of the selection criteria, corporate attributes and other
factors that OEMs use to qualify Suppliers.</span></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal;background:white'><b><span style='color:#1F497D'>When filling out the
SATI questionnaire:</span></b><span style='color:#1F497D'>&nbsp;the Supplier
will identify their own strengths, weaknesses and/or gaps in terms of what
global OEMs are looking in a preferred Supplier.&nbsp;</span></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal;background:white'><b><span style='color:#1F497D'>When the SATI
questionnaire is completed:</span></b><span style='color:#1F497D'>&nbsp;the
SATI becomes a great database for the company to update as required and to use
for internal purposes such as:&nbsp;</span></p>

<p class=MsoNormal style='line-height:normal;background:white'><span
style='font-family:Symbol;color:#1F497D'>·</span><span style='font-size:7.0pt;
font-family:"Times New Roman","serif";color:#1F497D'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
style='color:#1F497D'>Populating OEM Supplier Registrations forms and Supplier
Questionnaires,&nbsp;</span></p>

<p class=MsoNormal style='line-height:normal;background:white'><span
style='font-family:Symbol;color:#1F497D'>·</span><span style='font-size:7.0pt;
font-family:"Times New Roman","serif";color:#1F497D'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
style='color:#1F497D'>Populating Directories and Databases of Government
Entities, Associations and others,</span></p>

<p class=MsoNormal style='line-height:normal;background:white'><span
style='font-family:Symbol;color:#1F497D'>·</span><span style='font-size:7.0pt;
font-family:"Times New Roman","serif";color:#1F497D'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
style='color:#1F497D'>Creating and Communicating informed, compelling and
consistent business reasons for OEM(s) to do business with you,&nbsp;</span></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal;background:white'><b><span style='color:#1F497D'>When the SATI
Questionnaire Responses are exported to a PDF</span></b><span style='color:
#1F497D'>: the SATI PDF becomes a great document for the company to use for
marketing purposes such as:&nbsp;</span></p>

<p class=MsoNormal style='line-height:normal;background:white'><span
style='font-family:Symbol;color:#1F497D'>·</span><span style='font-size:7.0pt;
font-family:"Times New Roman","serif";color:#1F497D'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
style='color:#1F497D'>Creating a comprehensive capabilities document that can
be used as a unique page on your website – for a one stop Capabilities document</span></p>

<p class=MsoNormal style='line-height:normal;background:white'><span
style='font-family:Symbol;color:#1F497D'>·</span><span style='font-size:7.0pt;
font-family:"Times New Roman","serif";color:#1F497D'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
style='color:#1F497D'>Including as and/or contributing to the development of a
hand out for meetings</span></p>

<p class=MsoNormal style='line-height:normal;background:white'><span
style='font-family:Symbol;color:#1F497D'>·</span><span style='font-size:7.0pt;
font-family:"Times New Roman","serif";color:#1F497D'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
style='color:#1F497D'>Submitting to those OEMs who have agreed to review your
SATI and are waiting for your response!&nbsp;</span></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal;background:white'><b><span style='font-size:16.0pt;color:#1F497D'>&nbsp;</span></b></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal;background:white'><b><span style='font-size:24.0pt;color:#1F497D'>How to
Use&nbsp;&nbsp;</span></b></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal;background:white'><span style='color:#1F497D'>Download the SATI
Questionnaire and Get started!</span></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal;background:white'><span style='color:#1F497D'>Manage the document
internally</span></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal;background:white'><span style='color:#1F497D'>Begin the process of
filling out the SATI</span></p>

<p class=MsoNormal style='line-height:normal;background:white'><span
style='font-family:Symbol;color:#1F497D'>·</span><span style='font-size:7.0pt;
font-family:"Times New Roman","serif";color:#1F497D'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
style='color:#1F497D'>Save it and access/update as needed</span></p>

<p class=MsoNormal style='line-height:normal;background:white'><span
style='font-family:Symbol;color:#1F497D'>·</span><span style='font-size:7.0pt;
font-family:"Times New Roman","serif";color:#1F497D'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
style='color:#1F497D'>Save more than one version if you like</span></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal;background:white'><span style='color:#1F497D'>Export completed
version(s) to a PDF</span></p>

<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal;background:white'><span style='color:#1F497D'>Email the PDF to the OEMs
you wish to target who have agreed to review your submissions</span></p>

<p class=MsoNormal>&nbsp;</p>

</div>

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