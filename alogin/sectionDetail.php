<?php

$datafill_ID="0";
$datafill_ParentID="";
$datafill_sectionName="";
$datafill_sectionParentName="";
$parent_template_id="";

$msg="".$_REQUEST['m'];

//include("db.php");
include "../config.php";

 if(isset($_POST['submit']))
  { 
	$req_ID=$_POST['section_id'];
	$req_ParentID=$_POST['parent_section_id'];
	$req_ParentTemplateID=$_POST['parent_template_id'];
	$req_sectionName=$_POST['sectionName'];
	
	
	$strFileName="";
	
	if($_REQUEST['section_id']>0)
	{
		/*$sql = "DELETE FROM section_details  WHERE section_id = ?";
        $q = $db->prepare($sql);
        $q->execute(array($req_ID));
		*/
		 $sql = "UPDATE section_details  SET parent_section_id= ? ,parent_template_id= ? ,section_name=? where section_id= ? ";
		$q = $db->prepare($sql);
		$q->execute(array($req_ParentID,$req_ParentTemplateID,$req_sectionName,$req_ID));
	$msg="update";
         /*   

	mysql_query("delete from section_details where ID='$req_ID' "); 
	$query="insert into section_details (section_id,parent_section_id,parent_template_id,section_name) 
	values ($req_ID,$req_ParentID,$req_ParentTemplateID,$req_sectionName) ";
	mysql_query($query);
	*/
	}else{
	
		 $sql = "INSERT INTO section_details (parent_section_id,parent_template_id,section_name)  values(?, ?, ?)";
		$q = $db->prepare($sql);
		$q->execute(array($req_ParentID,$req_ParentTemplateID,$req_sectionName));
	$msg="insert";
	/*
	$query="insert into section_details (parent_section_id,parent_template_id,section_name) 
	values ($req_ParentID,$req_ParentTemplateID,$req_sectionName) ";
	mysql_query($query);
	*/
	}
	header("Location: /alogin/sectionDetail.php?m=$msg&tmpId=$req_ParentTemplateID");
	}
	
	if(isset($_REQUEST['sid'])){
	$datafill_ID=$_REQUEST['sid'];
	
	//$resultSet=mysql_query("select * from section_details where section_id=$datafill_ID");
	//while($test=mysql_fetch_array($resultSet))
	$sql= "select * from section_details where section_id=$datafill_ID";
foreach ($db->query($sql) as $test)
			{
			$datafill_ID=$test["section_id"];
			$parent_section_id=$test["parent_section_id"];
			$parent_template_id=$test["parent_template_id"];
			$datafill_sectionName=$test["section_name"];
			}
}

		if(isset($_REQUEST['dsid'])){
			//mysql_query("delete from section_details where section_id='".$_REQUEST['dsid']."'  "); 
			$sql = "DELETE FROM section_details  WHERE section_id = ?";
        $q = $db->prepare($sql);
        $q->execute(array($_REQUEST['dsid']));
		$msg="delete";
		header("Location: /alogin/sectionDetail.php?m=$msg&tmpId=".$_REQUEST['tpid']."");
		}

$tempCondition="";
$condition="";
											if(isset($_REQUEST['tmpId'])){
											$condition=" where parent_template_id = ".$_REQUEST['tmpId'];
$parent_template_id=$_REQUEST['tmpId'];
$tempCondition=" where template_id= $parent_template_id ";
											}	
?>

<html>
<head>
<title>Section</title>

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
                        <li class="nav-item  active ">
                            <a href="/alogin/template.php" class="nav-link">
                                <i class="icon-diamond"></i>
                                <span class="title">Template</span>
                                
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
                                <span><a href="/alogin/template.php"> Template</a></span> <i class="fa fa-arrow-right"></i>
                            </li>
                           <li>
                                <span>Sections</span>
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
                  <h3 class="page-title"> Sections
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
	
	
<div class="form-group">

 	<label class="control-label col-sm-4 no-padding-right"  > Template Name </label> 
	<div class=" col-sm-8"> 
		
        <select id="parent_template_id" name="parent_template_id" data-rel="tooltip" title="Template Name is required;"  class="required select2 search-select static-select col-xs-12 col-sm-12" >
			<option value="">----------SELECT----------</option> 
			<?php
			$sql= "select * from template_details $tempCondition";
foreach ($db->query($sql) as $test)
			{
//$resultExporters=mysql_query("select * from template_details ");
//while($test=mysql_fetch_array($resultExporters)){
echo "<option value='".$test['template_id']."' >".$test['template_name']."</option>";}			
			?>
			</select>
		
	</div>
</div>	
<div class="form-group">

 	<label class="control-label col-sm-4 no-padding-right"  >Parent Section Name </label> 
	<div class=" col-sm-8"> 
		
        <select id="parent_section_id" name="parent_section_id" data-rel="tooltip" title="Parent Section Name is required"  class="required select2 search-select static-select col-xs-12 col-sm-12" >
			<option value="">----------SELECT----------</option> 
			<option value="-1">None</option> 
			<?php
			$sql= "select * from section_details $condition";
foreach ($db->query($sql) as $test)
			{
//$resultExporters=mysql_query("select * from section_details ");
//while($test=mysql_fetch_array($resultExporters)){
echo "<option value='".$test['section_id']."' >".$test['section_name']."</option>";}			
			?>
			</select>
		
	</div>
</div>	
<div class="form-group">
<input type="hidden" id="section_id" name="section_id" value="<?php echo "".$_REQUEST['sid']; ?>" />     
 	<label class="control-label col-sm-4 no-padding-right"  > Section Name  </label> 
	<div class=" col-sm-8"> 

        <input id="sectionName" name="sectionName" type="text" class="required form-control" data-rel="tooltip" title="Section Name is required" placeholder="Section Name" value="<?php echo "".$datafill_sectionName;?>" >
		
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
														<th>Section Name</th>
														<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Action&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
													</tr>
												</thead>
											<tbody>
											<?php
											
											$sql= "select * from section_details $condition ";
											$cnt=1;
foreach ($db->query($sql) as $test)
			{
											//$resultSet=mysql_query("select * from section_details where section_id=$datafill_ID");
	//while($test=mysql_fetch_array($resultSet))
	//		{
$tplId=$test["parent_template_id"];
			$sectionID=$test["section_id"];
			$sectionName=$test["section_name"];
			
			
											echo "<tr>
														<th>$cnt
														</th>
														<th><a href='/alogin/questionDetail.php?gTplId=$tplId&secId=$sectionID' >$sectionName</a></th>	
														<th>
														<div class='btn-group'>
															<a href='/alogin/sectionDetail.php?sid=$sectionID' class='btn btn-xs btn-success'>
																<i class='ace-icon fa fa-pencil bigger-120'></i>
															</a>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href='/alogin/sectionDetail.php?dsid=$sectionID&tpid=$tplId' class='btn btn-xs btn-danger'>
																<i class='ace-icon fa fa-trash  bigger-120'></i>
															</a>

														</div>
														</th></tr>
														";
														$cnt++;
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
<script src="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<!--
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
-->			
<script>
function resetInput(){
$("#parent_section_id").select2('val','');
$("#parent_template_id").select2('val','');
$("input").val("");
//$(".error").css("display","none");
}

$('#dynamic-table').dataTable();


$(".select2").select2();
$('#section-form').validate();

$('#parent_section_id').select2('val','<?php echo"$parent_section_id";?>');
$('#parent_template_id').select2('val','<?php echo"$parent_template_id";?>');

</script>

</body>
</html>