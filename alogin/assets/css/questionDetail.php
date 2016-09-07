<?php

$datafill_ID="0";
$datafill_ParentID="";
$datafill_questionName="";
$datafill_sectionParentName="";
$parent_template_id="";
$datafill_AnswerType="";
$msg="";
//include("db.php");
include "../config.php";

 if(isset($_POST['submit']))
  { 
	$req_ID=$_POST['questionId'];
	$req_ParentID=$_POST['parent_section_id'];
	$req_ParentTemplateID=$_POST['parent_template_id'];
	$req_questionName=$_POST['questionName'];
	$req_AnswerType=$_POST['answerType'];
	
	
	$strFileName="";
	
	if($_REQUEST['questionId']>0)
	{
		$sql = "DELETE FROM question_details  WHERE question_id = ?";
        $q = $db->prepare($sql);
        $q->execute(array($req_ID));
		
		 $sql = "INSERT INTO question_details (question_id,parent_section_id,parent_template_id,question_text,option_type_id)  values(?, ?, ?, ?, ?)";
		$q = $db->prepare($sql);
		$q->execute(array($req_ID,$req_ParentID,$req_ParentTemplateID,$req_questionName,$req_AnswerType));
	$msg="insert";
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
	$msg="update";
	
	/*
	$query="insert into section_details (parent_section_id,parent_template_id,section_name) 
	values ($req_ParentID,$req_ParentTemplateID,$req_sectionName) ";
	mysql_query($query);
	*/
	}
	
	}
	
	if(isset($_REQUEST['qid'])){
	$datafill_ID=$_REQUEST['qid'];
	
	//$resultSet=mysql_query("select * from section_details where section_id=$datafill_ID");
	//while($test=mysql_fetch_array($resultSet))
	$sql= "select * from question_details where question_id=$datafill_ID";
foreach ($db->query($sql) as $test)
			{
			$datafill_ID=$test["question_id"];
			$parent_section_id=$test["parent_section_id"];
			$parent_template_id=$test["parent_template_id"];
			$datafill_questionName=$test["question_name"];
			$datafill_AnswerType=$test["option_type_id"];;
			}
}

		if(isset($_REQUEST['dqid'])){
			//mysql_query("delete from section_details where section_id='".$_REQUEST['dsid']."'  "); 
			$sql = "DELETE FROM question_details  WHERE question_id = ?";
        $q = $db->prepare($sql);
        $q->execute(array($_REQUEST['dqid']));
		}

	
?>

<html>
<head>
<title></title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
<link rel="stylesheet" href="assets/css/select2.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.2.0/css/font-awesome.min.css" />

</head>
<body>
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
			<option >Text Field</option> 
			<option >Single Choice</option> 
			<option >Multi Choice</option> 			
			</select>
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
														<th>Image</th>
														<th>section Name</th>
														<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
													</tr>
												</thead>
											<tbody>
											<?php
											$sql= "select * from question_details";
foreach ($db->query($sql) as $test)
			{
											//$resultSet=mysql_query("select * from section_details where section_id=$datafill_ID");
	//while($test=mysql_fetch_array($resultSet))
	//		{
			$sectionID=$test["question_id"];
			$sectionName=$test["question_text"];
			
			$cnt=1;
											echo "<tr>
														<th>$cnt
														</th>
														<th>$sectionName</th>	
														<th>
														<div class='btn-group'>
															<a href='/alogin/questionDetail.php?qid=$sectionID' class='btn btn-xs btn-success'>
																<i class='ace-icon fa fa-pencil bigger-120'></i>
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
		}
?>		
<script>


$(".select2").select2();
$('#section-form').validate();

$('#parent_section_id').select2('val','<?php echo"$parent_section_id";?>');
$('#parent_template_id').select2('val','<?php echo"$parent_template_id";?>');
$('#answerType').select2('val','<?php echo"$datafill_AnswerType";?>');

</script>

</body>
</html>