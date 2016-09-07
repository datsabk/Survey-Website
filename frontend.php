<!DOCTYPE html>
<?php include 'config.php' ?>
<?php include 'includes.html' ?>
<?php
$templateName = "";
$file_get_contents_json="";
$templateId="5";
//if POST request
//Write code to take file name and read the file text
//else execute below code

if(isset($_POST['resume']) &&$_POST['resume'] =='true')
{

	if(isset($_FILES['resumeFile'])){
	$file_get_contents_json="hardik2";
		$errors= array();
		$file_name = $_FILES['resumeFile']['name'];
		$file_size =$_FILES['resumeFile']['size'];
		$file_tmp =$_FILES['resumeFile']['tmp_name'];
		$file_type=$_FILES['resumeFile']['type'];   
		$file_ext=strtolower(end(explode('.',$_FILES['resumeFile']['name'])));
		$file_get_contents_json= file_get_contents($_FILES['resumeFile']['tmp_name']); 
		$map = json_decode($file_get_contents_json,true);
		$templateId= $map['templateId'];
	}
	else{
	$file_get_contents_json="";
	}
}
else
{
	$templateId = $_GET['templateId'];
}

$sql= "select * from template_details where template_id=".$templateId;
$results = $db->query($sql);
$templateViews= 0;
foreach ($results as $test)
			{
			$templateName=$test["template_name"];
			$templateViews = $test["template_views"];
			}
$sql = "update template_details set template_views=".($templateViews+1)." where template_id=".$templateId;
$db->query($sql);

?>
<html>
  <head>
<!--     <title><?php echo $templateName?></title> -->
<title>SATI Questionnaire </title>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />

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
</style> 
<meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
 </head>
<body>
<div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo" style="padding:28px">
                    <a href="index.php">
                        <i class="fa fa-home font-green" style="font-size:40px"></i>
                    
                </div>
				<div style="position:absolute;left:45%">
<!-- 				<h3 id="templateName"><?php echo $templateName?></h3> -->
				<h3 id="templateName">SATI Questionnaire</h3>
				</div>
                <!-- END LOGO -->
                <div class="page-top">
                    <div style="padding:20px">
                        <a class="btn btn-circle green" href="javascript:saveDraft();" title="Save as Draft">
                            <i class="fa fa-save font-white fa-lg"></i>
                        </a>
						<a class="btn btn-circle red" href="javascript:pdfSuccess();" title="Export to Pdf">
                            <i class="fa fa-file-pdf-o font-white fa-lg"></i>
                        </a>
						
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                
            </div>
</div>
<div class="row" style="width:98%;margin-left:1%;margin-right:1%; ">
    
	<div class="col-md-3 col-sm-3 col-xs-3" style="position:fixed;left:0px;top:80px;overflow:auto;height:520px">
		<ul class="nav nav-tabs tabs-left" id="sectionList">
			
			
		</ul>
	</div>
	
	<div class="col-md-9 col-sm-9 col-xs-9" style="padding-left:10px;padding-top:80px;border-left:1px solid light gray;background-color:white;float:right;">
           <div class="tab-content" id="allQuestionDiv">
			
		
		   </div>
	</div>
</div>
<div id="tmplPDFGeneration" style="display:none;">

</div>
<script type="text/javascript" src="jspdf.min.js"></script>
<script type="text/javascript" src="pdfContent.js"></script>
<script type="text/javascript" src="html2canvas.js"></script>


<script type="text/javascript">
var file_get_contents_jsonJS='<?php echo "$file_get_contents_json"; ?>';


var templateId = <?php echo $templateId?>;
var totalQuestions = 0;
var dynamicData;
if(file_get_contents_jsonJS=='')
{
	
$.ajax({
		type:'POST',
		url:'getSections.php',
		data:'templateId='+templateId,
		async: false,
		success:function(data){
			
			dynamicData = JSON.parse(data);
			populateSections();
			loadQuestionsDiv(dynamicData);
		}
		});

}
else
{

	var map = JSON.parse(file_get_contents_jsonJS);
	dynamicData = map['dynamicData'];
	populateSections();
	loadQuestionsDiv(dynamicData);
}
var currentSectionIndex;
var questions;
var qCount;
var sectionQuestionMapping;
var childHtmlContent='';
String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};

function populateSections()
{
	
	var htmlContent="";
	var preTextA = '<li class="active"><a href="';
	var preText = '<li><a href="';
	var midText = '" data-toggle="tab">';
	var postText = ' </a></li>';
	currentSectionIndex=0;
	for(var i=0;i<dynamicData.length;i++)
	{
		if(i==0)
			htmlContent+=preTextA;
		else
			htmlContent+=preText;
		htmlContent+='#qDiv_'+dynamicData[i].secId;
		htmlContent+= midText;
		htmlContent+=dynamicData[i].text;
		htmlContent+=postText;
	}
	$('#sectionList').html(htmlContent);
}
function loadQuestionsDiv(questionData)
{

	for(var i=0;i<questionData.length;i++)
	{
		
		qCount=0;
		var parentQuestionContent="";
		var pn= "";
		var nn = "";
		if(i==0)
			pn = "display:none;";
		if(i==questionData.length-1)
			nn = "display:none;";
		var divPreText='<div class="tab-pane fade" id="qDiv_'+questionData[i].secId+'"><div class="portlet box blue"><div class="portlet-title"><div class="caption" id="title_'+questionData[i].secId+'">'+questionData[i].text+'</div><div class="tools"><a href="javascript:;" class="collapse" data-original-title="" title=""></a></div></div><div class="portlet-body form"><div class= "form-body" id="questions" style="min-height:350px;padding-left:10px;padding-top:30px;">';
		var divPostText = '</div><div class= "form-actions" style="padding-top:10px;background-color:white;"><a href="javascript:goPrevSection();" class="btn blue font-white" id="btnPrevSection" title="Go to Previous Section" style="float:left;position:fixed;right:67.5%;bottom:7%;'+pn+'"><i class="fa fa-arrow-left fa-lg" aria-hidden="true"></i></a><a href="javascript:goNextSection();" class="btn blue font-white" id = "btnNextSection" title="Go to Next Section" style="float:right;position:fixed;right:5%;bottom:7%;'+nn+'"><i class="fa fa-arrow-right fa-lg" aria-hidden="true"></i></a></div></div></div>';
		var htmlContent="";
		var qList = questionData[i].questions;
		if(sectionQuestionMapping==undefined|| sectionQuestionMapping=='undefined')
		{
		
			sectionQuestionMapping={'a':1};
		}
		var htmlContent=divPreText+loadQuestion(qList,questionData[i].text);
		childHtmlContent='';
		if(questionData[i].nodes!=null && questionData[i].nodes.length>0)
			htmlContent+=loadChildQuestions(questionData[i].nodes);
		htmlContent+=divPostText;
		if(i==0)
			$('#allQuestionDiv').html(htmlContent);
		else
			$('#allQuestionDiv').append(htmlContent);

		$('#title_'+questionData[i].secId).append(" ("+qCount+" questions)");
	}
		$('#qDiv_'+questionData[0].secId).addClass("active").addClass("in");
		
}

function loadChildQuestions(nodeList)
{
	var htmlContent="";

	for(var i=0;i<nodeList.length;i++)
	{
		
		var divPreText='<div class="portlet box blue"><div class="portlet-title"><div class="caption">'+nodeList[i].text+'</div><div class="tools"><a href="javascript:;" class="collapse" data-original-title="" title=""></a></div></div><div class="portlet-body form"><div class= "form-body" id="questions" style="min-height:350px;padding-left:10px;padding-top:30px;">';
		var divPostText = '</div></div></div>';
		
		var qList = nodeList[i].questions;
		if(qList!=null && qList.length>0)
		{
		htmlContent+=divPreText+loadQuestion(qList,nodeList[i].text);

		if(nodeList[i].nodes!=null && nodeList[i].nodes.length>0)
			htmlContent+=loadChildQuestions(nodeList[i].nodes);
		htmlContent+=divPostText;
		}
	}
	return htmlContent;
}
function loadQuestion(questionList,currentSectionName)
{
    var  htmlContent= '';
	sectionQuestionMapping[currentSectionName.replace(" ","_").replace(".","__")]=questionList;
	for(var c=0;c<questionList.length;c++)
	{
		qCount++;
		var question = questionList[c];
		
		var cSn = currentSectionName.replace(" ","_").replace(".","__");

        htmlContent+='<div id="'+cSn.toLowerCase()+'_question'+c+'">';
		htmlContent+='<h4>'+(c+1)+'. '+question.questionText+"</h4><br>";

				
				if(question.optionsArray!=null && question.optionsArray.length>0)
				{
					var header = '';
					var footer = '';
					var preText = '';
					var postText='';
					if(question.optionTypeId==2)
					{
						header = '<div class="md-radio-list">';
						footer = '</div>';
						preText = '<div class="md-radio"><input type="radio" id="optOPTNO" name="optQSNO" class="md-radiobtn" onchange="saveRadioAnswer(this,'+c+',\''+currentSectionName+'\');"><label for="optOPTNO"><span class="inc"></span><span class="check"></span><span class="box"></span>';
						preText1 = '<div class="md-radio"><input type="radio" checked id="optOPTNO" name="optQSNO" class="md-radiobtn" onchange="saveRadioAnswer(this,'+c+',\''+currentSectionName+'\');"><label for="optOPTNO"><span class="inc"></span><span class="check"></span><span class="box"></span>';

						postText= ' </label></div>';
					}
					else if(question.optionTypeId==3)
					{
						header = '<div class="md-checkbox-list">';
						footer = '</div>';
						preText = '<div class="md-checkbox"><input type="checkbox" id="optOPTNO" name="optQSNO" class="md-radiobtn" onchange="saveCheckAnswer(this,'+c+',\''+currentSectionName+'\');"><label for="optOPTNO"><span class="inc"></span><span class="check"></span><span class="box"></span>';
						preText1 = '<div class="md-checkbox"><input checked type="checkbox" id="optOPTNO" name="optQSNO" class="md-radiobtn" onchange="saveCheckAnswer(this,'+c+',\''+currentSectionName+'\');"><label for="optOPTNO"><span class="inc"></span><span class="check"></span><span class="box"></span>';
						postText= ' </label></div>';
					}
					htmlContent+=header;
					for(var x=0;x<question.optionsArray.length;x++)
					{
						var answerText = question.answerText+' ';
						var optionId ="optOPTNO".replace(/optOPTNO/g,'opts'+currentSectionName.replace(" ","_").replace(".","__")+'q'+c+x);
						

						if(answerText.indexOf("optOPTNO".replace(/optOPTNO/g,'opts'+currentSectionName.replace(" ","_").replace(".","__")+'q'+c+x))>=0)
						{
							htmlContent+=preText1.replace(/optOPTNO/g,'opts'+currentSectionName.replace(" ","_").replace(".","__")+'q'+c+x).replace(/optQSNO/g,'opts'+currentSectionName.replace(" ","_").replace(".","__")+c);
						}
						else
						{
						htmlContent+=preText.replace(/optOPTNO/g,'opts'+currentSectionName.replace(" ","_").replace(".","__")+'q'+c+x).replace(/optQSNO/g,'opts'+currentSectionName.replace(" ","_").replace(".","__")+c);
						}
						htmlContent+=question.optionsArray[x].optionText;
						htmlContent+=postText;
					}
					htmlContent+=footer;
				}
				else if(question.optionTypeId==4)
				{
					htmlContent+='<div class="form-group form-md-line-input"><input type="text" class="form-control" onkeypress="return (event.charCode||event.keyCode) >= 48 && (event.charCode||event.keyCode) <= 57;" onblur="saveTextAnswer(this,'+c+',\''+currentSectionName+'\');" placeholder="Your Answer(only numbers)" value="'+question.answerText+'"/></div>';
				} 
				else if(question.optionTypeId==5)
				{
					htmlContent+='<div class="form-group" style="margin-bottom:30px !important;"><div class="col-md-3"><div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy" ><input readonly type="text" class="form-control" onchange="saveTextAnswer(this,'+c+',\''+currentSectionName+'\');" value="'+question.answerText+'"/><span class="input-group-btn"> <button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span></div></div></div>';
				}
				else if(question.optionTypeId==7)
				{
					htmlContent+= '<div class="form-group" style="margin-bottom:30px !important;"><div class="col-md-4"><div class="input-group input-large date-picker input-daterange" data-date-format="dd/mm/yyyy"><input type="text" class="form-control" onchange="saveFromDate(this,'+c+',\''+currentSectionName+'\');"  name="from" placeholder="From" value="'+question.fromDate+'"/><span class="input-group-addon"> - </span><input type="text" class="form-control" onchange="saveToDate(this,'+c+',\''+currentSectionName+'\');" name="to" placeholder="To" value="'+question.toDate+'" /> </div></div></div>';
				}
				else
				{
					htmlContent+='<div class="form-group form-md-line-input"><textarea class="form-control" rows="5" onblur="saveTextAnswer(this,'+c+',\''+currentSectionName+'\');" placeholder="Your Answer">'+question.answerText+'</textarea></div>';
				}
				htmlContent+='</div><div style="padding-top:10px;"></div>';
				
				
	}
	return htmlContent;

	
}

function saveRadioAnswer(src,currentQuestion,currentSectionName)
{
	
	var questionsList = sectionQuestionMapping[currentSectionName.replace(" ","_").replace(".","__")];
	var	question = questionsList[currentQuestion];
	var answer = src.id;
	question.answerText = answer;
	question.plainText = '<p> ' +  $("label[for='"+src.id+"']").text()+'</p><br>';

	questionsList[currentQuestion] = question;
	sectionQuestionMapping[currentSectionName.replace(" ","_").replace(".","__")] = questionsList;


}

function saveCheckAnswer(src,currentQuestion,currentSectionName)
{
	var questionsList = sectionQuestionMapping[currentSectionName.replace(" ","_").replace(".","__")];
	var	question = questionsList[currentQuestion];
	var answer =src.id;
	if(src.checked)
	{
		if(question.answerText=='')
			question.plainText= '';
		question.answerText += (answer+',');
		question.plainText += '<p> ' +  $("label[for='"+src.id+"']").text()+'</p><br>';
	}
	else
	{
		var aT = question.answerText;
		aT = aT.replace(answer+",", "");
		question.answerText = aT;
		aT = question.plainText;
		aT = aT.replace('<p> ' + $("label[for='"+src.id+"']").text()+'</p><br>', "");
		question.plainText = aT;
	}
	questionsList[currentQuestion] = question;
	sectionQuestionMapping[currentSectionName.replace(" ","_").replace(".","__")] = questionsList;
}

function saveTextAnswer(src,currentQuestion,currentSectionName)
{
	var questionsList = sectionQuestionMapping[currentSectionName.replace(" ","_").replace(".","__")];
	var	question = questionsList[currentQuestion];
	var answer = src.value;
	question.answerText = answer;
	question.plainText = answer+'<br>';
	questionsList[currentQuestion] = question;
	sectionQuestionMapping[currentSectionName.replace(" ","_").replace(".","__")] = questionsList;
}

function saveFromDate(src,currentQuestion,currentSectionName)
{
	var questionsList = sectionQuestionMapping[currentSectionName.replace(" ","_").replace(".","__")];
	var	question = questionsList[currentQuestion];
	var answer = src.value;

	question.fromDate = answer;
	question.plainText = question.fromDate + ' to ' + question.toDate+'<br>';
	questionsList[currentQuestion] = question;
	sectionQuestionMapping[currentSectionName.replace(" ","_").replace(".","__")] = questionsList;
	
}

function saveToDate(src,currentQuestion,currentSectionName)
{
	var questionsList = sectionQuestionMapping[currentSectionName.replace(" ","_").replace(".","__")];
	var	question = questionsList[currentQuestion];
	var answer = src.value;
	question.toDate = answer;
	question.plainText = question.fromDate + ' to ' + question.toDate+'<br>';
	questionsList[currentQuestion] = question;
	sectionQuestionMapping[currentSectionName.replace(" ","_").replace(".","__")] = questionsList;
	
	
}
function goNextSection()
{
	currentSectionIndex++;
	$('.nav-tabs li:eq('+currentSectionIndex+') a').tab('show');
}
  
function goPrevSection()
{
	currentSectionIndex--;
	$('.nav-tabs li:eq('+currentSectionIndex+') a').tab('show');
}

function saveDraft()
{
	var map = {};
	map['templateId'] = templateId;
	map['templateName'] = '<?php echo $templateName?>';
	dynamicData = traverseQuestionMapping(dynamicData);
	map['dynamicData']= dynamicData;
	
	var date = new Date();
	var m = date.getMonth();
	var month='';
	if(m<10)
		month = '0'+(m+1);
	else
		month = (m+1);
	download(map['templateName']+'_'+date.getDate()+'_'+month+'_'+date.getFullYear()+'.txt',JSON.stringify(map));


}
function download(filename, text) {
		  var ua = navigator.userAgent.toLowerCase(); 
	if (ua.indexOf('safari') != -1) { 
  if (ua.indexOf('chrome') > -1) {
var pom = document.createElement('a');
    pom.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
    pom.setAttribute('download', filename);
	pom.target='_blank';
    if (document.createEvent) {
        var event = document.createEvent("MouseEvents");
        event.initMouseEvent("click", true, true, window,
            0, 0, 0, 0, 0,
            false, false, false, false,
            0, null);
        cancelled = !pom.dispatchEvent(event);
    }
    else if (pom.fireEvent) {
        cancelled = !pom.fireEvent("onclick");
    }
  } else {
        var downloadDataURI = function($, options) {
    if(!options)
        return;
    $.isPlainObject(options) || (options = {data: options});
    options.filename || (options.filename = "download." + options.data.split(",")[0].split(";")[0].substring(5).split("/")[1]);
    options.url || (options.url = "http://download-data-uri.appspot.com/");
    $('<form method="post" action="'+options.url+'" style="display:none"><input type="hidden" name="filename" value="'+options.filename+'"/><input type="hidden" name="data" value="'+options.data+'"/></form>').submit().remove();
}
downloadDataURI($, {filename: filename,data:"data:attachment/plain;charset=utf-8,"+ encodeURIComponent(text)});


  }
}
else{
var pom = document.createElement('a');
    pom.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
    pom.setAttribute('download', filename);
	pom.target='_blank';
    if (document.createEvent) {
        var event = document.createEvent("MouseEvents");
        event.initMouseEvent("click", true, true, window,
            0, 0, 0, 0, 0,
            false, false, false, false,
            0, null);
        cancelled = !pom.dispatchEvent(event);
    }
    else if (pom.fireEvent) {
        cancelled = !pom.fireEvent("onclick");
    }
}
   
    
	showSuccess();
}
function traverseQuestionMapping(questionData)
{
	for(var i=0;i<questionData.length;i++)
	{
		var currentSectionName = questionData[i].text;
		questionData[i].questions = sectionQuestionMapping[currentSectionName.replace(" ","_").replace(".","__")];
		if(questionData[i].nodes!=null && questionData[i].nodes.length>0)
			questionData[i].nodes = traverseChild(questionData[i].nodes);
	}
	return questionData;
}

function traverseChild(nodes)
{
	for(var j=0;j<nodes.length;j++)
	{
		var currentSectionName = nodes[j].text;
		nodes[j].questions = sectionQuestionMapping[currentSectionName.replace(" ","_").replace(".","__")];
		if(nodes[j].nodes!=null && nodes[j].nodes.length>0)
			nodes[j].nodes =traverseChild(nodes[j].nodes);
	}
	return nodes;
}


function traverseQuestionMappingAns(questionData)
{

for(var i=0;i<questionData.length;)
	{
	var isAnyAnsInSec=false;
	
		var currentSectionName = questionData[i].text;
		questionData[i].questions = sectionQuestionMapping[currentSectionName.replace(" ","_").replace(".","__")];
		for(var ansL=0;(questionData[i].questions!=null && ansL<questionData[i].questions.length);){
			if(questionData[i].questions[ansL].answerText==""){
				questionData[i].questions.splice(ansL,1);	
			}else{
				ansL++;
				isAnyAnsInSec=true;
			}
		}		
		if(questionData[i].nodes!=null && questionData[i].nodes.length>0)		
			questionData[i].nodes = traverseChildAns(questionData[i].nodes);
			
			if(isAnyAnsInSec==true || (questionData[i].nodes!=null && questionData[i].nodes.length>0)){
				i++;
				}else{
				questionData.splice(i,1);
				}			
			}
	return questionData;
	}
	
function traverseChildAns(nodes)
{
	for(var j=0;j<nodes.length;)
	{
	var isAnyAnsInSec=false;
		var currentSectionName = nodes[j].text;
		nodes[j].questions = sectionQuestionMapping[currentSectionName.replace(" ","_").replace(".","__")];
		
		for(var ansL=0;(nodes[j].questions!=null && ansL<nodes[j].questions.length);){
			if(nodes[j].questions[ansL].answerText==""){
				nodes[j].questions.splice(ansL,1);	
			}else{
				ansL++;
				isAnyAnsInSec=true;
			}
		}	
		if(nodes[j].nodes!=null && nodes[j].nodes.length>0)
			nodes[j].nodes =traverseChildAns(nodes[j].nodes);
			
		if(isAnyAnsInSec==true){
			j++;
			}else if (nodes.length>j){
			nodes.splice(j,1);
			}
	}
	return nodes;
}

//For Hardik
function generatePdf(pdfFlag)
{

dynamicData= traverseQuestionMapping(dynamicData);

var qDDD=[];
for(var i=0;i<dynamicData.length;i++){
qDDD[i]=dynamicData[i];
}
//var qDDD=dynamicData.slice();
if(pdfFlag){
qDDD=traverseQuestionMappingAns(qDDD);
}
//dynamicData=qDDD;

var objOfSecQueMap=sectionQuestionMapping;
delete objOfSecQueMap.a;
debugger;
var content="";
content = loadPdfQuestionsDiv(qDDD,'<?php echo $templateName?>');
 //$("#tmplPDFGeneration").html(content.replaceAll("<br>","<p style='padding-top:5px;'></p><img src='blank.jpg' />"));  
content =  content.replaceAll("<br>","<div style='width:100%;'><img src='blank.jpg'/></div>");
content =  content.replaceAll("’","\'");
content =  content.replaceAll(" – ","-");

$("#tmplPDFGeneration").html(content);  

$('#tmplPDFGeneration').css('display','');
 downloadPDF($("#templateName").html()) ;

	modal().close();
}
function loadQueAnsArr(arrOfSec){
var listOfQueAns="";

for(var i=0;i<arrOfSec.length;i++){
var queAns=arrOfSec[i];
listOfQueAns=listOfQueAns+"<br><p><strong>"+queAns['questionText']+"</strong></p><br><span style='margin-left:50px;'> &nbsp;&nbsp;"+queAns['plainText'];
}

return listOfQueAns+'<br><br>';
}

function downloadPDF(fileName) {
	debugger;
var pdf = new jsPDF('p', 'pt', 'letter')

// source can be HTML-formatted string, or a reference
// to an actual DOM element from which the text will be scraped.
, source = $('#tmplPDFGeneration').html()
, specialElementHandlers = {
	// element with id of "bypass" - jQuery style selector
	'#bypassme': function(element, renderer){
		// true = "handled elsewhere, bypass text extraction"
		return true
	}
}

pdf = pdf.setFont('helvetica','normal');
margins = {
    top: 30,
    bottom: 30,
    left: 40,
	width:570
  };
  // all coords and widths are in jsPDF instance's declared units
  // 'inches' in this case
pdf.fromHTML(
  	source // HTML string or DOM elem ref.
  	, margins.left // x coord
  	, margins.top // y coord
  	, {
  		'width': margins.width // max width of content on PDF
  		, 'elementHandlers': specialElementHandlers
  	},
  	function (dispose) {
  	  // dispose: object with X, Y of the last line add to the PDF
  	  //          this allow the insertion of new lines after html
	  var ua = navigator.userAgent.toLowerCase(); 
if (ua.indexOf('safari') != -1) { 
  if (ua.indexOf('chrome') > -1) {
        pdf.save(fileName+'.pdf');
  } else {
        pdf.output('datauri');
  }
}
else{
	        pdf.save(fileName+'.pdf');
}
   
$('#tmplPDFGeneration').css('display','none');
      },
  	margins
  )
}
function showSuccess() {
			modal({
				type: 'success',
				title: 'Save Successful',
				text: 'To resume the survey:<br/>1. Go to home page<br/>2.Upload the file downloaded.',
			});
		}
function pdfSuccess() {
			modal({
				type: 'success',
				title: 'Download Pdf',
				text: '<ol><li style="cursor:pointer" onclick="generatePdf(true)" > Download pdf only answered questions. </li><br/><li   style="cursor:pointer" onclick="generatePdf(false)" > Download full pdf. </li></ol>',
			});
		}
</script>

<style>
.border-div{
border:2px solid black;
border-radius:2px ;
}
@media print {
  .no-print{
    visibility: hidden;
  }
  #questions {
    visibility: visible !important;
  }
}
.btn-group-justified{
border-spacing:5px !important ;
}

</style>
</body>

</html>					