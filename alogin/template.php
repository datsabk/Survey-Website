<?php

$datafill_ID="";
$datafill_TemplateName="";
$datafill_strFileName="";

$msg="";
//include("db.php");
include "../config.php";

 if(isset($_POST['submit']))
  { 
	$req_ID=$_POST['templateId'];
	$req_TemplateName=$_POST['templateName'];
	$strFileName="";
	if(isset($_FILES['image'])){
		$errors= array();
		$file_name = $_FILES['image']['name'];
		$file_size =$_FILES['image']['size'];
		$file_tmp =$_FILES['image']['tmp_name'];
		$file_type=$_FILES['image']['type'];   
		$file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
		
		$expensions= array("jpeg","jpg","png"); 		
		if(in_array($file_ext,$expensions)=== false){
			$errors[]="extension not allowed, please choose a JPEG or PNG file.";
		}
		if($file_size > 5197152){
		$errors[]='File size must be excately 5 MB';
		}
		
		if(empty($errors)==true){
		$strFileName="assets/uploadFiles/images/".$file_name;
			move_uploaded_file($file_tmp,$strFileName);
			//echo "Success";
		}else{
			print_r($errors);
		}
	}
	if($_REQUEST['templateId']>0)
	{
	/*
		$sql = "DELETE FROM template_details  WHERE template_id = ?";
        $q = $db->prepare($sql);
        $q->execute(array($_REQUEST['templateId']));
		*/
		 $sql = "update template_details set  template_name=?,imageUrl=? where template_id=? ";
		$q = $db->prepare($sql);
		$q->execute(array($req_TemplateName,$strFileName,$req_ID));
	
	/*mysql_query("delete from template_details where ID='$req_ID' "); 
	$query="insert into template_details (template_id,template_name,imageUrl) values ($req_ID,$req_TemplateName,$strFileName) ";
	mysql_query($query);*/
	
$msg="update";
	}else{
	/*$query="insert into template_details (template_name,imageUrl) values ($req_TemplateName,$strFileName) ";
	mysql_query($query);*/
	 $sql = "insert into template_details (template_name,imageUrl) values( ?, ?)";
		$q = $db->prepare($sql);
		$q->execute(array($req_TemplateName,$strFileName));
		$msg="insert";
	}
	
	}
	
	if(isset($_REQUEST['tid'])){
	$datafill_ID=$_REQUEST['tid'];


	/*$resultSet=mysql_query("select * from template_details where template_id=$datafill_ID");
	while($test=mysql_fetch_array($resultSet))
			{*/
			$sql= "select * from template_details where template_id=$datafill_ID";
foreach ($db->query($sql) as $test)
			{
			$datafill_TemplateName=$test["template_name"];
			$datafill_strFileName=$test["imageUrl"];
			}
}


		if(isset($_REQUEST['dtid'])){
			//mysql_query("delete from section_details where template_id='".$_REQUEST['dtid']."' "); 
			$sql = "DELETE FROM template_details  WHERE template_id		 = ?";
        $q = $db->prepare($sql);
        $q->execute(array($_REQUEST['dtid']));
		}
?>

<html>
<head>
<title>Template</title>
<?php include 'defaultStyles.php' ?>

<style>
.error{
color:red;
}

#chartdiv {
	width		: 100%;
	height		: 235px;
	font-size	: 11px;
}

div#chartdiv a {
    display: none !important;
}		
</style>
</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
 <!-- BEGIN HEADER -->
         <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <h4 style="    color: white;">Survey Central</h4>
                    <div class="menu-toggler sidebar-toggler"> </div>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN TOP NAVIGATION MENU -->
               
                <!-- END TOP NAVIGATION MENU -->
            </div>
				<a href="/alogin/login.php" ><h4 style="    color: white;    position: absolute;    right: 90px;"> Logout </h4></a>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
<!--
<ul class="nav nav-tabs">
 <li role="presentation" class="active"><a href="/alogin/template.php">Templates</a></li>
  <li role="presentation" ><a href="/alogin/sectionDetail.php">Sections</a></li>
  <li role="presentation" ><a href="/alogin/questionDetail.php">Question</a></li>
</ul>
-->

<!-- -->

 <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- BEGIN SIDEBAR -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <div class="page-sidebar navbar-collapse collapse">
                    <!-- BEGIN SIDEBAR MENU -->
                    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                        <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                        <li class="sidebar-toggler-wrapper hide">
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <div class="sidebar-toggler"> </div>
                            <!-- END SIDEBAR TOGGLER BUTTON -->
                        </li>
                        <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                       <!--> <li class="heading">
                            <h3 class="uppercase">Features</h3>
                        </li>
						-->
                        <li class="nav-item  active ">
                            <a href="/alogin/template.php" class="nav-link">
                                <i class="icon-diamond"></i>
                                <span class="title">Template</span>
                                <span class="arrow"></span>
                            </a>
                            
                        </li> 

 
                        <li class="nav-item ">
                            <a href="/alogin/newsDetail.php" class="nav-link">
                                <i class="fa fa-newspaper-o"></i>
                                <span class="title">News</span>                                
                            </a>
                            
                        </li> 
						<!--<li class="nav-item  ">
                            <a href="/alogin/sectionDetail.php" class="nav-link">
                                <i class="icon-diamond"></i>
                                <span class="title">Sections</span>
                                <span class="arrow"></span>
                            </a>
                            
                        </li> 
						<li class="nav-item  ">
                            <a href="/alogin/questionDetail.php" class="nav-link">
                                <i class="icon-diamond"></i>
                                <span class="title">Questions</span>
                                <span class="arrow"></span>
                            </a>
                            
                        </li>
						-->
                        
                    </ul>
                    <!-- END SIDEBAR MENU -->
                    <!-- END SIDEBAR MENU -->
                </div>
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content" style="min-height:1112px">
                    <!-- BEGIN PAGE HEADER-->
                    <!-- BEGIN THEME PANEL -->
					
				   <!-- END THEME PANEL -->
                    <!-- BEGIN PAGE BAR -->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                           <li>
                                <span>Template</span>
                            </li>
                        </ul>
                       <!-- <div class="page-toolbar">
                            <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range">
                                <i class="icon-calendar"></i>&nbsp;
                                <span class="thin uppercase hidden-xs">January 17, 2016 - February 15, 2016</span>&nbsp;
                                <i class="fa fa-angle-down"></i>
                            </div>
                        </div>
						-->
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                   <h3 class="page-title"> Template
                        <!--<small>dashboard &amp; statistics</small>-->
                  </h3>

	 <div id="success" class="alert alert-success" style="display:none;text-align:center;">
<span id="messageFade" style="color:green;"></span>
</div>	
                    <!-- END PAGE TITLE-->
                    <!-- END PAGE HEADER-->
                    <!-- BEGIN DASHBOARD STATS 1-->
                <div  style="/*margin-left:10%;margin-right:10%;*/">

<!--<h1>	Templates	</h1>-->


<div class="row">
							<div class="col-xs-12">
<div id='chartdiv'>

</div>
</div>

</div>
<hr>
<div class="row">
							<div class="col-xs-12">
<form id="Template-form" class="form-horizontal" method="post"  enctype="multipart/form-data"  >	
		
		
<div class="form-group">
<input type="hidden" id="templateId" name="templateId" value="<?php echo "".$_REQUEST['tid']; ?>" />     
 	<label class="control-label col-sm-4 no-padding-right"  > Template Name </label> 
	<div class=" col-sm-8"> 
		
        <input id="templateName" name="templateName" type="text"  data-required="1" class="form-control required" data-rel="tooltip" title="Template name is required." placeholder="Template Name" value="<?php echo "".$dataFill_templateName;?>" >
		
	</div>
</div>	

<h3 class="header smaller lighter blue">
										Template Image
                                    </h3>
									
														<div class="form-group">
															<div class="col-xs-12">
															<span id="fileErrorShow" style="color:red;"></span>
																<input multiple type="file" name="image" id="id-input-file-3" class="required" />
															</div>
														</div>	  

				
									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											
											<button type="submit" id="submited" name="submit" class="btn btn-info" value="Submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												Submit
											</button>

											&nbsp; &nbsp; &nbsp;
											<button class="btn" type="reset">
												<i class="ace-icon fa fa-undo bigger-110"></i>
												Reset
											</button>
										</div>
									</div>															


</form>
</div>
</div>
<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
									<div class="table-responsive">
											<table id="dynamic-table" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<th>Sr.No.</th>
														<th>Image</th>
														<th>Template Name</th>
														<!--<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>-->
													</tr>
												</thead>
											<tbody>
											<?php
											//$resultSet=mysql_query("select * from template_details ");
	//while($test=mysql_fetch_array($resultSet))
	$sql= "select * from template_details";
	$cntTemp=1;
	$row=[];
	$dataProvider=[];
	$colors=['#FF0F00','#FF0F00','#780800','#350F35','#910327','#FF0F91','#55220F','#F0760F','#510F11','#101101','#505505','#FF0F00','#FF0F00','#FF0F00','#FF0F00'];
foreach ($db->query($sql) as $test)
			{
			$graphData=[];
			$graphData['template']=$test["template_name"];
			$graphData['visits']=$test["template_views"];
			$graphData['color']=$colors[$cntTemp];
			array_push($dataProvider,$graphData);
			$row[$cntTemp]=$test;
			$templateID=$test["template_id"];
			$templateName=$test["template_name"];
			$tempImage=$test["imageUrl"];
			
											echo "<tr><th>$cntTemp</th>
														<th>
														<img src='$tempImage' width='15px' height='15px'  
														class='myPopOver' data-toggle='popover' title='$templateName' 
														data-content='$templateName' width='80px' height='80px' />
														</th>
														<th><a href='/alogin/sectionDetail.php?tmpId=$templateID' >$templateName</a></th>	
														<!--<th>
														<div class='btn-group'>
															<a href='/alogin/template.php?tid=$templateID' class='btn btn-xs btn-success'>
																<i class='ace-icon fa fa-pencil bigger-120'></i>
															</a>

														</div>
														</th>--></tr>
														";
														$cntTemp++;
														}
														/*
														
														
															<a class='btn btn-xs btn-info'>
																<i class='ace-icon fa fa-pencil bigger-120'></i>
															</a>

															<a  href='#' onclick='soldProperty('<%=properties[i].id%>')' class='btn btn-xs btn-danger'>
																<i class='ace-icon fa fa-trash-o bigger-120'></i>
															</a>
														*/
											?>
											
											</tbody>
											
											</table>
									</div>	
									
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
						
						
						
</div>
				</div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
            <!-- BEGIN QUICK SIDEBAR -->
            <!-- END QUICK SIDEBAR -->
        </div>
        <!-- END CONTAINER -->
     


<!-- -->

	


<?php include 'defaultScripts.php' ?>

<script src="../assets/global/plugins/jquery-validation/js/jquery.validate.js" type="text/javascript"></script>
   
   
        <script src="../assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>
		
		<?php
		
if($msg=='insert'){
 echo '<script>jQuery(function($) {
		$("#messageFade").html("Record Successfully Inserted");
		$("#success").css("display","");
		$("#success").fadeOut(5000);		
		});</script>';
		}else if($msg=='update'){
		echo '<script>jQuery(function($) {
		$("#messageFade").html("Record Successfully Updated");
		$("#success").css("display","");
		$("#success").fadeOut(5000);		
		});</script>';
		}
?>		

				
<script>
console.log('<?php  echo "".json_encode($dataProvider); ?>');
var dataProviser=<?php  echo "".json_encode($dataProvider); ?>;

$('#Template-form').validate();


var chart = AmCharts.makeChart("chartdiv", {
    "theme": "light",
    "type": "serial",
	"startDuration": 2,
    "dataProvider": dataProviser,
    "valueAxes": [{
        "position": "left",
        "axisAlpha":0,
        "gridAlpha":0         
    }],
    "graphs": [{
        "balloonText": "[[category]]: <b>[[value]]</b>",
        "colorField": "color",
        "fillAlphas": 0.85,
        "lineAlpha": 0.1,
        "type": "column",
        "topRadius":1,
        "valueField": "visits"
    }],
    "depth3D": 40,
	"angle": 30,
    "chartCursor": {
        "categoryBalloonEnabled": false,
        "cursorAlpha": 0,
        "zoomable": false
    },    
    "categoryField": "template",
    "categoryAxis": {
        "gridPosition": "start",
        "axisAlpha":0,
        "gridAlpha":0
        
    },
    "export": {
    	"enabled": true
     }

},0);

jQuery('.chart-input').off().on('input change',function() {
	var property	= jQuery(this).data('property');
	var target		= chart;
	chart.startDuration = 0;

	if ( property == 'topRadius') {
		target = chart.graphs[0];
	}

	target[property] = this.value;
	chart.validateNow();
});
</script>

</body>
</html>