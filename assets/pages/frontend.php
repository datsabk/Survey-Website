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
    <title><?php echo $templateName?></title>

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
</style> 
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
				<h3 id="templateName"><?php echo $templateName?></h3>
				</div>
                <!-- END LOGO -->
                <div class="page-top">
                    <div style="padding:20px">
                        <a class="btn btn-circle green" href="javascript:saveDraft();" title="Save as Draft">
                            <i class="fa fa-save font-white fa-lg"></i>
                        </a>
						<a class="btn btn-circle red" href="javascript:generatePdf();" title="Export to Pdf">
                            <i class="fa fa-file-pdf-o font-white fa-lg"></i>
                        </a>
						
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                
            </div>
</div>
<div class="row" style="width:98%;margin-left:1%;margin-right:1%; ">
    
	<div class="col-md-3 col-sm-3 col-xs-3" style="position:fixed;left:0px;top:80px;">
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
			console.log(data);
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
		var divPostText = '</div><div class= "form-actions" style="padding-top:10px;background-color:white;"><a href="javascript:goPrevSection();" class="btn blue font-white" id="btnPrevSection" style="float:left;'+pn+'">Previous Section</a><a href="javascript:goNextSection();" class="btn blue font-white" id = "btnNextSection" style="float:right;'+nn+'">Next Section</a></div></div></div>';
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
		console.log(JSON.stringify(sectionQuestionMapping));
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
		console.log(JSON.stringify(question));
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
				else if(question.optionTypeId==1)
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
		question.plainText += '<p>&#9989; ' +  $("label[for='"+src.id+"']").text()+'</p><br>';
	}
	else
	{
		var aT = question.answerText;
		aT = aT.replace(answer+",", "");
		question.answerText = aT;
		aT = question.plainText;
		aT = aT.replace('<p>&#9989; ' + $("label[for='"+src.id+"']").text()+'</p><br>', "");
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
	console.log(JSON.stringify(question));
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
	console.log(JSON.stringify(question));
	
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
	console.log(JSON.stringify(map));
	var date = new Date();
	var m = date.getMonth();
	var month='';
	if(m<10)
		month = '0'+(m+1);
	else
		month = (m+1);
	download(map['templateName']+'_'+date.getDate()+'_'+month+'_'+date.getFullYear()+'.stmp',JSON.stringify(map));


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


//For Hardik
function generatePdf()
{
dynamicData= traverseQuestionMapping(dynamicData);
var objOfSecQueMap=sectionQuestionMapping;
delete objOfSecQueMap.a;

var content="";
content = loadPdfQuestionsDiv(dynamicData,'<?php echo $templateName?>');
 //$("#tmplPDFGeneration").html(content.replaceAll("<br>","<p style='padding-top:5px;'></p><img src='blank.jpg' />"));  
$("#tmplPDFGeneration").html(content.replaceAll("<br","<div style='margin-top:15px;'><br/></div"));  
 console.log($("#tmplPDFGeneration").html());
$('#tmplPDFGeneration').css('display','');
 downloadPDF($("#templateName").html()) ;

	
}
function loadQueAnsArr(arrOfSec){
var listOfQueAns="";
console.log('abcd'+JSON.stringify(arrOfSec));
for(var i=0;i<arrOfSec.length;i++){
var queAns=arrOfSec[i];
listOfQueAns=listOfQueAns+"<br><p><strong>"+queAns['questionText']+"</strong></p><br><span style='margin-left:50px;'> &nbsp;&nbsp;"+queAns['plainText'];
}

return listOfQueAns+'<br><br>';
}

function downloadPDF(fileName) {
var pdf = new jsPDF('p', 'pt', 'letter')

// source can be HTML-formatted string, or a reference
// to an actual DOM element from which the text will be scraped.
, source = $('#tmplPDFGeneration')[0]
, specialElementHandlers = {
	// element with id of "bypass" - jQuery style selector
	'#bypassme': function(element, renderer){
		// true = "handled elsewhere, bypass text extraction"
		return true
	}
}
console.log(pdf.getFontList());
pdf = pdf.setFont('helvetica','normal');
margins = {
    top: 40,
    bottom: 40,
    left: 40,
	width:522
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
        pdf.save(fileName+'.pdf');
$('#tmplPDFGeneration').css('display','none');
      },
  	margins
  )
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