<?php

$datafill_ID="0";
$datafill_Type="";
$datafill_Name="";
$datafill_URL="";

$msg="".$_REQUEST['m'];

//include("db.php");
include "../config.php";

 if(isset($_POST['submit']))
  { 
  
$req_ID=$_POST['id'];
$req_Type=$_POST['type'];
$req_Name=$_POST['name'];
$req_URL=$_POST['url'];
	
	
	if($_REQUEST['id']>0)
	{
		$sql = "DELETE FROM news  WHERE id = ?";
        $q = $db->prepare($sql);
        $q->execute(array($req_ID));
		
		 $sql = "INSERT INTO news (id,type,name,url)  values(?, ?, ?, ?)";
		$q = $db->prepare($sql);
		$q->execute(array($req_ID,$req_Type,$req_Name,$req_URL));
			
	$msg="update";
        
	}else{
	
		$sql = "INSERT INTO news (type,name,url)  values(?, ?, ?)";
		$q = $db->prepare($sql);
		$q->execute(array($req_Type,$req_Name,$req_URL));
		
	$msg="insert";
	
	}
	header("Location: /alogin/newsDetail.php?m=$msg");
	}
	
	if(isset($_REQUEST['nid'])){
	$datafill_ID=$_REQUEST['nid'];
	$sql= "select * from news where id=".$_REQUEST['nid'];
foreach ($db->query($sql) as $test)
			{
			$datafill_ID=$test["id"];
			$datafill_Type=$test["type"];
			$datafill_Name=$test["name"];
			$datafill_URL=$test["url"];			
			}
}

		if(isset($_REQUEST['dnid'])){
		
		$sql = "DELETE FROM news  WHERE id = ?";
        $q = $db->prepare($sql);
        $q->execute(array($_REQUEST['dnid']));
		
		$msg="delete";
		header("Location: /alogin/newsDetail.php?m=$msg");
		}

	
?>

<html>
<head>
<title>News</title>

<?php include 'defaultStyles.php' ?>
<link href="../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css">
<link href="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css">
<link href="../assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css">
<link href="../assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css">
<style>
.error{
color:red;
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
                        <li class="nav-item   ">
                            <a href="/alogin/template.php" class="nav-link">
                                <i class="icon-diamond"></i>
                                <span class="title">Template</span>                                
                            </a>
                            
                        </li> 
                        <li class="nav-item  active ">
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
                                <span>News</span>
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
                  <h3 class="page-title"> News
                        <!--<small>dashboard &amp; statistics</small>-->
                 </h3>
				 <div id="success" class="alert alert-success" style="display:none;text-align:center;">
<span id="messageFade" style="color:green;"></span>
</div>	
                    <!-- END PAGE TITLE-->
                    <!-- END PAGE HEADER-->
                    <!-- BEGIN DASHBOARD STATS 1-->
                <div  style="/*margin-left:10%;margin-right:10%;*/">



<form id="section-form" class="form-horizontal" method="post"  >	
<input type="hidden" name="id" id="id" value="<?php echo "".$datafill_ID;?>" />	
<div class="form-group">

 	<label class="control-label col-sm-4 no-padding-right"  > News Type </label> 
	<div class=" col-sm-8"> 
		<div class="clearfix">
        <select id="type" name="type" data-rel="tooltip" title="News type is required"  class="required select2 search-select static-select col-xs-12 col-sm-12" >
			<option value="">----------SELECT----------</option> 
			<option value="1">Headline</option> 
			<option value="2">Side News</option> 
			
			</select>
		</div>
	</div>
</div>	
<div class="form-group">

 	<label class="control-label col-sm-4 no-padding-right"  > News Text </label> 
	<div class=" col-sm-8"> 
		<div class="clearfix">
          <input id="name" name="name" type="text"  maxlength="500"  class="required form-control" data-rel="tooltip" title="News Text is required" placeholder="News Text" value="<?php echo "".$datafill_Name;?>" >
		</div>
	</div>
</div>	
<div class="form-group">
<input type="hidden" id="questionId" name="questionId" value="<?php echo "".$_REQUEST['qid']; ?>" />     
 	<label class="control-label col-sm-4 no-padding-right"  > News URL  </label> 
	<div class=" col-sm-8"> 
		<div class="clearfix">
        <input id="url" name="url" type="url" maxlength="500" class="required url form-control" data-rel="tooltip" title="News URL is required" placeholder="News URL" value="<?php echo "".$datafill_URL;?>" >
		</div>
	</div>
</div>	
				
									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											
											<button type="submit" id="submited" name="submit" class="btn btn-info" value="Submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												Submit
											</button>

											&nbsp; &nbsp; &nbsp;
											<button class="btn" type="reset" id="resetButton" onclick="resetInput()">
												<i class="ace-icon fa fa-undo bigger-110"></i>
												Reset
											</button>
										</div>
									</div>															


</form>

<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
									<div class="table-responsive">
											<table id="dynamic-table" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<th>Sr.No.</th>
														<th>News Type</th>
														<th>News Text</th>
														<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Action&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
													</tr>
												</thead>
											<tbody>
											<?php
$cnter=1;

											
											$sql= "select * from news ";
foreach ($db->query($sql) as $test)
			{
											//$resultSet=mysql_query("select * from section_details where section_id=$datafill_ID");
	//while($test=mysql_fetch_array($resultSet))
	//		{
			$id=$test["id"];
			$name=$test["name"];
			$type=$test["type"];
			$url=$test["url"];
			$typeText="Side News";
			if($type==1){
			$typeText="Headline";
			}
			
			
			
											echo "<tr>
														<th>$cnter
														</th>
														<th>$typeText</th>	
														<th><a href=\"$url\" target='_blank' >$name </a></th>	
														<th>
														<div class='btn-group'>
															<a href='/alogin/newsDetail.php?nid=$id' class='btn btn-xs btn-success'>
																<i class='ace-icon fa fa-pencil bigger-120'></i>
															</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href='/alogin/newsDetail.php?dnid=$id' class='btn btn-xs btn-danger'>
																<i class='ace-icon fa fa-trash bigger-120'></i>
															</a>

														</div>
														</th></tr>
														";
														$cnter++;
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

						
<div id="success" style="display:none;text-align:center;position:fixed;top:0;height:65px;width:100%;background-color: lightgreen;">
<h3 id="messageFade" style="color:green;"></h3>
</div>	


<?php include 'defaultScripts.php' ?>

<script src="../assets/global/plugins/jquery-validation/js/jquery.validate.js" type="text/javascript"></script>
<script src="../assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>  			
		
			
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
		}else if($msg=="delete"){
		echo '<script>jQuery(function($) {
		$("#messageFade").html("Record Successfully Deleted");
		$("#success").css("display","");
		$("#success").fadeOut(5000);		
		});</script>';
		}
?>	


<script src="../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<!--
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>			
-->
<script>
function resetInput(){
$("#type").select2('val','');
$("input").val("");
//$(".error").css("display","none");
}

$('#dynamic-table').dataTable();
$(".select2").select2();
$('#section-form').validate();

$('#type').select2().select2('val','<?php echo"$datafill_Type";?>');

</script>

</body>
</html>