<?php

$datafill_ID="0";
$datafill_ParentID="";
$datafill_questionName="";
$datafill_sectionParentName="";
$parent_template_id="";
$datafill_AnswerType="";
$msg="".$_REQUEST['m'];
$answerCount=0;
//include("db.php");
include "../config.php";

 if(isset($_POST['submit']))
  { 
	$req_ID=$_POST['questionId'];
	$req_ParentID=$_POST['parent_section_id'];
	$req_ParentTemplateID=$_POST['parent_template_id'];
	$req_questionName=$_POST['questionName'];
	$req_AnswerType=$_POST['answerType'];
	$req_AnswerLists=$_POST['answers'];
	
	
	$strFileName="";
	
	if($_REQUEST['questionId']>0)
	{
		$sql = "DELETE FROM question_details  WHERE question_id = ?";
        $q = $db->prepare($sql);
        $q->execute(array($req_ID));
		
		 $sql = "INSERT INTO question_details (question_id,parent_section_id,parent_template_id,question_text,option_type_id)  values(?, ?, ?, ?, ?)";
		$q = $db->prepare($sql);
		$q->execute(array($req_ID,$req_ParentID,$req_ParentTemplateID,$req_questionName,$req_AnswerType));
		
		$sql = "DELETE FROM options_details  WHERE parent_question_id = ?";
        $q = $db->prepare($sql);
        $q->execute(array($req_ID));
		
		for($cnt=0;$cnt<sizeof($req_AnswerLists);$cnt++){
		 $sql = "INSERT INTO options_details (parent_question_id,option_text)  values(?, ?)";
		$q = $db->prepare($sql);
		$q->execute(array($req_ID,$req_AnswerLists[$cnt]));
		}
		
	$msg="update";
         /*   

	mysql_query("delete from section_details where ID='$req_ID' "); 
	$query="insert into section_details (section_id,parent_section_id,parent_template_id,section_name) 
	values ($req_ID,$req_ParentID,$req_ParentTemplateID,$req_sectionName) ";
	mysql_query($query);
	*/
	}else{
	
		 $sql = "INSERT INTO question_details (parent_section_id,parent_template_id,question_text,option_type_id)  values(?, ?, ?, ?)";
		$q = $db->prepare($sql);
		$q->execute(array($req_ParentID,$req_ParentTemplateID,$req_questionName,$req_AnswerType));
		$id = $db->lastInsertId();
		
		
		for($cnt=0;$cnt<sizeof($req_AnswerLists);$cnt++){
		 $sql = "INSERT INTO options_details (parent_question_id,option_text)  values(?, ?)";
		$q = $db->prepare($sql);
		$q->execute(array($id,$req_AnswerLists[$cnt]));
		}
	$msg="insert";
	
	/*
	$query="insert into section_details (parent_section_id,parent_template_id,section_name) 
	values ($req_ParentID,$req_ParentTemplateID,$req_sectionName) ";
	mysql_query($query);
	*/
	}
	header("Location: /alogin/questionDetail.php?m=$msg");
	}
	
	if(isset($_REQUEST['qid'])){
	$datafill_ID=$_REQUEST['qid'];
	
	//$resultSet=mysql_query("select * from section_details where section_id=$datafill_ID");
	//while($test=mysql_fetch_array($resultSet))
	$sql= "select * from question_details where question_id=".$_REQUEST['qid'];
foreach ($db->query($sql) as $test)
			{
			$datafill_ID=$test["question_id"];
			$parent_section_id=$test["parent_section_id"];
			$parent_template_id=$test["parent_template_id"];
			$datafill_questionName=$test["question_text"];
			$datafill_AnswerType=$test["option_type_id"];;
			}
}

		if(isset($_REQUEST['dqid'])){
		
		$sql = "DELETE FROM options_details  WHERE parent_question_id = ?";
        $q = $db->prepare($sql);
        $q->execute(array($_REQUEST['dqid']));
		
			//mysql_query("delete from section_details where section_id='".$_REQUEST['dsid']."'  "); 
			$sql = "DELETE FROM question_details  WHERE question_id = ?";
        $q = $db->prepare($sql);
        $q->execute(array($_REQUEST['dqid']));
		$msg="delete";
		header("Location: /alogin/questionDetail.php?m=$msg");
		}

	
?>

<html>
<head>
<title>Question</title>
<style>
.answersText{
width="100%"
}
.select2-container{
padding:0px 0px 0px 0px;
}
</style>

<?php include 'defaultStyles.php' ?>

</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
 <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="index.html">
                        <img src="../assets/layouts/layout/img/logo.png" alt="logo" class="logo-default"> </a>
                    <div class="menu-toggler sidebar-toggler"> </div>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN TOP NAVIGATION MENU -->
               
                <!-- END TOP NAVIGATION MENU -->
            </div>
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
                       
                        <li class="nav-item">
                            <a href="/alogin/template.php" class="nav-link">
                                <i class="icon-diamond"></i>
                                <span class="title">Template</span>
                               
                            </a>
                            
                        </li> 
						<li class="nav-item">
                            <a href="/alogin/sectionDetail.php" class="nav-link">
                                <i class="icon-diamond"></i>
                                <span class="title">Sections</span>
                                
                            </a>
                            
                        </li> 
						<li class="nav-item active">
                            <a href="/alogin/questionDetail.php" class="nav-link">
                                <i class="icon-diamond"></i>
                                <span class="title">Questions</span>
                                
                            </a>
                            
                        </li>
                        
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
                                <span>Question</span>
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
                    <h3 class="page-title"> Question
                        <!--<small>dashboard &amp; statistics</small>-->
                    </h3>
                    <!-- END PAGE TITLE-->
                    <!-- END PAGE HEADER-->
                    <!-- BEGIN DASHBOARD STATS 1-->
               <div style="/*margin-left:10%;margin-right:10%;*/">
<h1>	Question	</h1>

<form id="section-form" class="form-horizontal" method="post"  >	
	
	
<div class="form-group">

 	<label class="control-label col-sm-4 no-padding-right"  > Template Name </label> 
	<div class=" col-sm-8"> 
		<div class="clearfix">
        <select id="parent_template_id" name="parent_template_id" data-rel="tooltip" title="Template Name"  class="required select2 search-select static-select col-xs-12 col-sm-12" >
			<option value="">----------SELECT----------</option> 
			<?php
			$sql= "select * from template_details";
foreach ($db->query($sql) as $test)
			{
//$resultExporters=mysql_query("select * from template_details ");
//while($test=mysql_fetch_array($resultExporters)){
echo "<option value='".$test['template_id']."' >".$test['template_name']."</option>";}			
			?>
			</select>
		</div>
	</div>
</div>	
<div class="form-group">

 	<label class="control-label col-sm-4 no-padding-right"  > Section Name </label> 
	<div class=" col-sm-8"> 
		<div class="clearfix">
        <select id="parent_section_id" name="parent_section_id" data-rel="tooltip" title="Parent Section Name"  class="required select2 search-select static-select col-xs-12 col-sm-12" >
			<option value="">----------SELECT----------</option> 
			<option value="-1">None</option> 
			<?php
			$sql= "select * from section_details";
foreach ($db->query($sql) as $test)
			{
//$resultExporters=mysql_query("select * from section_details ");
//while($test=mysql_fetch_array($resultExporters)){
echo "<option value='".$test['section_id']."' >".$test['section_name']."</option>";}			
			?>
			</select>
		</div>
	</div>
</div>	
<div class="form-group">
<input type="hidden" id="questionId" name="questionId" value="<?php echo "".$_REQUEST['qid']; ?>" />     
 	<label class="control-label col-sm-4 no-padding-right"  > Question Name  </label> 
	<div class=" col-sm-8"> 
		<div class="clearfix">
        <input id="questionName" name="questionName" type="text" class="required col-xs-12 col-sm-12" data-rel="tooltip" title="Question Name" placeholder="section Name" value="<?php echo "".$datafill_questionName;?>" >
		</div>
	</div>
</div>	


<div class="form-group">

 	<label class="control-label col-sm-4 no-padding-right"  > Answer Type </label> 
	<div class=" col-sm-8"> 
		<div class="clearfix">
        <select id="answerType" name="answerType" data-rel="tooltip" title="Answer Type"  class="required select2 search-select static-select col-xs-12 col-sm-12" >
			<option value="">----------SELECT----------</option> 
			<option value="1">Text Field</option> 
			<option value="2">Single Choice</option> 
			<option value="3">Multi Choice</option> 			
			</select>
		</div>
	</div>
</div>	
									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											
											<button style="margin-bottom:10px" type="button" id="addNewAns" name="addNewAns" class="btn btn-info" value="Add Answer">
												<i class="ace-icon fa fa-check bigger-110"></i>
												Add
											</button>
										</div>
									</div>	
					<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
									<div class="table-responsive">
											<table id="dynamic-table-1" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<th>Answer</th>
														</tr>
												</thead>
											<tbody id="answerList">
											<?php
											if(isset($_REQUEST['qid'])){
											$sql= "select * from options_details where parent_question_id=".$_REQUEST['qid'];
											foreach ($db->query($sql) as $test)
											{
											echo "<tr><td ><input class='answersText' type='text' name='answers[$answerCount]' value='".$test['option_text']."' /></td></tr>";
											$answerCount++;
											}	
											}
											?>
											</tbody>
											</table>
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
											<button class="btn" type="reset">
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
														<th>No.</th>
														<th>QuestionName</th>
														<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
													</tr>
												</thead>
											<tbody>
											<?php
$cnter=1;
											$sql= "select * from question_details";
foreach ($db->query($sql) as $test)
			{
											//$resultSet=mysql_query("select * from section_details where section_id=$datafill_ID");
	//while($test=mysql_fetch_array($resultSet))
	//		{
			$sectionID=$test["question_id"];
			$sectionName=$test["question_text"];
			
			
											echo "<tr>
														<th>$cnter
														</th>
														<th>$sectionName</th>	
														<th>
														<div class='btn-group'>
															<a href='/alogin/questionDetail.php?qid=$sectionID' class='btn btn-xs btn-success'>
																<i class='ace-icon fa fa-pencil bigger-120'></i>
															</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href='/alogin/questionDetail.php?dqid=$sectionID' class='btn btn-xs btn-danger'>
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
								
				
				
		
		<script src="assets/js/jquery-2.0.3.min.js"></script>

		<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.validate.min.js"></script>
				<script src="assets/js/select2.min.js"></script>
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


<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>			
<script>
$('#dynamic-table').dataTable();

var answerCount=<?php echo "".$answerCount;?>;

function addNewAnsFun(){
var ansString="<tr><td ><input  class='answersText' type='text' name='answers["+answerCount+"]'  /></td></tr>";
$("#answerList").append(ansString);
answerCount++;
}

$("#addNewAns").on('click',function(){
addNewAnsFun();
});

function removeAns(t){
$(t).remove();
answerCount--;
}

$(".select2").select2();
$('#section-form').validate();

$('#parent_section_id').select2().select2('val','<?php echo"$parent_section_id";?>');
$('#parent_template_id').select2().select2('val','<?php echo"$parent_template_id";?>');
$('#answerType').select2().select2('val','<?php echo"$datafill_AnswerType";?>');

</script>
