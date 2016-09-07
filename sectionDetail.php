<?php

$datafill_ID="";
$datafill_ParentID="";
$datafill_sectionName="";
$datafill_sectionParentName="";
$parent_template_id="";

include("db.php");
 if(isset($_POST['submit']))
  { 
	$req_ID=$_POST['section_id'];
	$req_ParentID=$_POST['parent_section_id'];
	$req_ParentTemplateID=$_POST['parent_template_id'];
	$req_sectionName=$_POST['sectionName'];
	
	
	$strFileName="";
	
	if($_REQUEST['section_id']>0)
	{
	mysql_query("delete from section_details where ID='$req_ID' "); 
	$query="insert into section_details (section_id,parent_section_id,parent_template_id,section_name) 
	values ($req_ID,$req_ParentID,$req_ParentTemplateID,$req_sectionName) ";
	mysql_query($query);
	}else{
	$query="insert into section_details (parent_section_id,parent_template_id,section_name) 
	values ($req_ParentID,$req_ParentTemplateID,$req_sectionName) ";
	mysql_query($query);
	}
	
	}
	
	if(isset($_REQUEST['sid'])){
	$datafill_ID=$_REQUEST['sid'];
	$resultSet=mysql_query("select * from section_details where section_id=$datafill_ID"):
	while($test=mysql_fetch_array($resultSet))
			{
			$datafill_ID=$test["section_id"];
			$parent_section_id=$test["parent_section_id"];
			$parent_template_id=$test["parent_template_id"];
			$datafill_sectionName=$test["section_name"];
			}
}

		if(isset($_REQUEST['dsid'])){
			mysql_query("delete from section_details where section_id='".$_REQUEST['dsid']."'  "); 
		}

	
?>

<html>
<head>
<title></title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.2.0/css/font-awesome.min.css" />

</head>
<body>
<h1>	Sections	</h1>

<form id="section-form" class="form-horizontal" method="post"  >	
	
	
<div class="form-group">

 	<label class="control-label col-sm-4 no-padding-right"  > Template Name </label> 
	<div class=" col-sm-8"> 
		<div class="clearfix">
        <select id="parent_template_id" name="parent_template_id" data-rel="tooltip" title="Template Name"  class="required select2 search-select static-select col-xs-12 col-sm-12" >
			<option value="">----------SELECT----------</option> 
			<?php
$resultExporters=mysql_query("select * from template_details ");
while($test=mysql_fetch_array($resultExporters)){
echo "<option value='".$test['template_id']."' >".$test['template_name']."</option>";}			
			?>
			</select>
		</div>
	</div>
</div>	
<div class="form-group">

 	<label class="control-label col-sm-4 no-padding-right"  >Parent Section Name </label> 
	<div class=" col-sm-8"> 
		<div class="clearfix">
        <select id="parent_section_id" name="parent_section_id" data-rel="tooltip" title="Parent Section Name"  class="required select2 search-select static-select col-xs-12 col-sm-12" >
			<option value="">----------SELECT----------</option> 
			<option value="-1">None</option> 
			<?php
$resultExporters=mysql_query("select * from section_details ");
while($test=mysql_fetch_array($resultExporters)){
echo "<option value='".$test['section_id']."' >".$test['section_name']."</option>";}			
			?>
			</select>
		</div>
	</div>
</div>	
<div class="form-group">
<input type="hidden" id="section_id" name="section_id" value="<?php echo $dataFill_ID;?>" />     
 	<label class="control-label col-sm-4 no-padding-right"  > section Name </label> 
	<div class=" col-sm-8"> 
		<div class="clearfix">
        <input id="sectionName" name="sectionName" type="text" class="required col-xs-12 col-sm-12" data-rel="tooltip" title="section Name" placeholder="section Name" value="<?php echo $dataFill_sectionName;?>" >
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
											$resultSet=mysql_query("select * from section_details where section_id=$datafill_ID"):
	while($test=mysql_fetch_array($resultSet))
			{
			$sectionID=$test["section_id"];
			$sectionName=$test["section_name"];
			
			$cnt=1;
											echo "<tr>
														<th>$cnt
														</th>
														<th>$sectionName</th>	
														<th>
														<div class='btn-group'>
															<a href='/sectionDetail?tid=$sectionID' class='btn btn-xs btn-success'>
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
						
						
						
		<!--[if !IE]> -->
		<script src="assets/js/jquery.2.1.1.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery.1.11.1.min.js"></script>
<![endif]-->

		<!--[if !IE]> -->
		
		<!-- <![endif]-->

		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.validate.min.js"></script>
				<script src="assets/js/select2.min.js"></script>
<script>
$(".select2").select2();
$('#section-form').validate();

$('#parent_section_id').select2('val','<?php echo"$parent_section_id";?>');
$('#parent_template_id').select2('val','<?php echo"$parent_template_id";?>');

</script>

</body>
</html>