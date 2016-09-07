<?php

$datafill_ID="";
$datafill_TemplateName="";
$datafill_strFileName="";

include("db.php");
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
			echo "Success";
		}else{
			print_r($errors);
		}
	}
	if($_REQUEST['templateId']>0)
	{
	mysql_query("delete from template_details where ID='$req_ID' "); 
	$query="insert into template_details (template_id,template_name,imageUrl) values ($req_ID,$req_TemplateName,$strFileName) ";
	mysql_query($query);
	}else{
	$query="insert into template_details (template_name,imageUrl) values ($req_TemplateName,$strFileName) ";
	mysql_query($query);
	}
	
	}
	
	if(isset($_REQUEST['tid'])){
	$datafill_ID=$_REQUEST['tid'];


	$resultSet=mysql_query("select * from template_details where template_id=$datafill_ID");
	while($test=mysql_fetch_array($resultSet))
			{
			$datafill_TemplateName=$test["template_name"];
			$datafill_strFileName=$test["imageUrl"];
			}
}


		if(isset($_REQUEST['dtid'])){
			mysql_query("delete from section_details where template_id='".$_REQUEST['dtid']."' "); 
		}
?>

<html>
<head>
<title></title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.2.0/css/font-awesome.min.css" />
<style>

div#chartdiv a {
    display: none !important;
}
</style>
</head>
<body>
<h1>	Templates	</h1>

<form id="Template-form" class="form-horizontal" method="post"  >	
				     
<div class="form-group">
<input type="hidden" id="templateId" name="templateId" value="<?php echo $dataFill_templateId;?>" />     
 	<label class="control-label col-sm-4 no-padding-right"  > Template Name </label> 
	<div class=" col-sm-8"> 
		<div class="clearfix">
        <input id="templateName" name="templateName" type="text" class="required col-xs-12 col-sm-12" data-rel="tooltip" title="Template Name" placeholder="Template Name" value="<?php echo $dataFill_templateName;?>" >
		</div>
	</div>
</div>	

<h3 class="header smaller lighter blue">
										Template Image
                                    </h3>
									
														<div class="form-group">
															<div class="col-xs-12">
															<span id="fileErrorShow" style="color:red;"></span>
																<input multiple type="file" name="image" id="id-input-file-3" />
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
														<th>Template Name</th>
														<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
													</tr>
												</thead>
											<tbody>
											<?php
											$resultSet=mysql_query("select * from template_details ");
	while($test=mysql_fetch_array($resultSet))
			{
			$templateID=$test["template_id"];
			$templateName=$test["template_name"];
			$tempImage=$test["imageUrl"];
			
											echo "<tr>
														<th>
														<img src='$tempImage' width='15px' height='15px'  
														class='myPopOver' data-toggle='popover' title='$templateName' 
														data-content='$templateName' width='80px' height='80px' />
														</th>
														<th>$templateName</th>	
														<th>
														<div class='btn-group'>
															<a href='/template?tid=$templateID' class='btn btn-xs btn-success'>
																<i class='ace-icon fa fa-pencil bigger-120'></i>
															</a>

														</div>
														</th></tr>
														";
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
</script>

</body>
</html>