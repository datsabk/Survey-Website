function loadPdfQuestionsDiv(questionData,templateName)
{
	var finalContent="<h3 style='margin-left:250px;font-size:18px;'>"+templateName+" </h3>";
	for(var i=0;i<questionData.length;i++)
	{
		qCount=0;
		var parentQuestionContent="";
		var pn= "";
		var nn = "";
		var divPreText='<br><br><h4 style="font-size:14px">'+(i+1)+') '+questionData[i].text+'</h4>';
		var divPostText = '';
		var htmlContent="";
		var qList = questionData[i].questions;
		
		var htmlContent=divPreText+loadPdfQuestion(qList,questionData[i].text);
		childHtmlContent='';
		if(questionData[i].nodes!=null && questionData[i].nodes.length>0)
			htmlContent+=loadPdfChildQuestions(questionData[i].nodes);
		htmlContent+=divPostText;
		finalContent+=(htmlContent);

		
	}
	return finalContent;
}

function loadPdfChildQuestions(nodeList)
{
	var htmlContent="";

	for(var i=0;i<nodeList.length;i++)
	{
		
		var divPreText='<br><br><h4 style="font-size:14px;padding-left:25px;">'+nodeList[i].text+'</h4>';
		var divPostText = '';
		
		var qList = nodeList[i].questions;
		if(qList!=null && qList.length>0)
		{
		htmlContent+=divPreText+loadPdfQuestion(qList,nodeList[i].text);

		if(nodeList[i].nodes!=null && nodeList[i].nodes.length>0)
			htmlContent+=loadPdfChildQuestions(nodeList[i].nodes);
		htmlContent+=divPostText;
		}
	}
	return htmlContent;
}
function loadPdfQuestion(questionList,currentSectionName)
{
    var  htmlContent= '';
	for(var c=0;c<questionList.length;c++)
	{
		qCount++;
		var question = questionList[c];
		var cSn = currentSectionName.replace(" ","_").replace(".","__");

        htmlContent+='';
		htmlContent+='<br><p style="font-size:14px;">'+question.questionText+"</p>";

				
				if(question.optionsArray!=null && question.optionsArray.length>0)
				{
					var header = '';
					var footer = '';
					var preText = '';
					var postText='';
					if(question.optionTypeId==2)
					{
						header = '';
						footer = '';
						preText = '<p style="font-size:12px;"><img src="radios.jpg" style="float:left;padding-right:5px;height: 8px;margin-top: 7px;" />   ';
						preText1 = '<p style="font-size:12px;"><img src="rchecks.jpg" style="float:left;padding-right:5px;height: 8px;margin-top: 7px;" />   ';

						postText= '</p>';
					}
					else if(question.optionTypeId==3)
					{
						header = '';
						footer = '';
						preText = '<p style="font-size:12px;"><img src="checkboxs.jpg" style="float:left;padding-right:5px;height: 8px;margin-top: 7px;"  />   ';
						preText1 = '<p style="font-size:12px;"><img src="cchecks.jpg" style="float:left;padding-right:5px;height: 8px;margin-top: 7px;"  />   ';

						postText= '</p>';
					}
					htmlContent+=header;
					for(var x=0;x<question.optionsArray.length;x++)
					{
						var answerText = question.answerText+' ';
						var optionId ="optOPTNO".replace(/optOPTNO/g,'opts'+currentSectionName.replace(" ","_").replace(".","__")+'q'+c+x);
						

						if(answerText.indexOf("optOPTNO".replace(/optOPTNO/g,'opts'+currentSectionName.replace(" ","_").replace(".","__")+'q'+c+x))>=0)
						{
							htmlContent+=preText1;
						}
						else
						{
						htmlContent+=preText;
						}
						htmlContent+=' '+question.optionsArray[x].optionText;
						htmlContent+=postText;
					}
					htmlContent+=footer;
				}
				else
				{
					htmlContent+='<p style="font-size:12px;padding-top:5px;"><b> '+question.plainText+'</b></p>';
				} 
				htmlContent+='<br>';
				
				
	}
	return htmlContent;

	
}