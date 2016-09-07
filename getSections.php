<?php include 'config.php' ?>
<?php
session_start();
$sql= "SELECT * FROM section_details where parent_template_id = ".$_POST['templateId'];
$stmt= $db->query($sql);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

class Section{
public $text;
public $nodes;
public $secId;
public $questions;
}
class Option{

	public $optionId;
	public $optionText;

}

class Question{
	public $questionText;
	public $optionsArray;
	public $answerText;
	public $plainText;
	public $questionId;
	public $optionTypeId;
}
$sectionArray= array();

foreach($results as $db_row ) {

	if($db_row['parent_section_id']==-1 || $db_row['parent_section_id']==null)
	{

		$sectionInstance = new Section();
		$sectionInstance->text=$db_row['section_name'];
		$sectionInstance->secId = $db_row['section_id'];
		$qArray = array();
		$qArray = getQuestionArray($db,$db_row['section_id']);
		$sectionInstance->questions = $qArray;
		$nodeArray = array();
		$sql2 = $sql.' and parent_section_id='.$db_row['section_id'];
                
		$stmt2= $db->query($sql2);
        if(!empty($stmt2) AND $stmt2 ->rowCount() > 0)
        {
				$results2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
		        foreach($results2 as $db_child_row ) {
			
				$sectionChildInstance = new Section();
				$sectionChildInstance->text=$db_child_row['section_name'];
				$sectionChildInstance->secId = $db_child_row['section_id'];
				$qArray = array();
				$qArray = getQuestionArray($db,$db_child_row['section_id']);
				$sectionChildInstance->questions = $qArray;
				$nodeArray[] = $sectionChildInstance;
				$sectionInstance->nodes = $nodeArray;
			}
		
		}

		$sectionArray[] = $sectionInstance;
	}

}

function getQuestionArray($dbO,$sectionId)
{
		//Questions loading code starts
$qsql= "select * from question_details where parent_template_id =".$_POST['templateId']." and parent_section_id ='".$sectionId."'";
$qstmt= $dbO->query($qsql);
$qresults = array();

if(!empty($qstmt) AND $qstmt ->rowCount() > 0)
{
$qresults = $qstmt->fetchAll(PDO::FETCH_ASSOC);
}

$questionArray=array();
foreach($qresults as $question)
{
	
	$qI= new Question();
	$qI->optionsArray= array();
	$qI->questionText = $question['question_text'];
	$qI->answerText='';
	$qI->fromDate = '';
	$qI->toDate = '';
	$qI->plainText='';
	$qI->questionId=$question['question_id'];
	$qI->optionTypeId=$question['option_type_id'];
	$hrLine = '';
	if($qI->optionTypeId==2 || $qI->optionTypeId==3)
	{
		$optionArray = array();
		$sql2 = 'select * from options_details where parent_question_id = '.$qI->questionId;
		
		$stmt2= $dbO->query($sql2);
		$optionsResult = array();
		if(!empty($stmt2) AND $stmt2 ->rowCount() > 0)
		{
			$optionsResult = $stmt2->fetchAll(PDO::FETCH_ASSOC);
		}
		foreach($optionsResult as $optionResult)
		{
			$qI->plainText=$qI->plainText.'<br>';
			$option= new Option();
			$option->optionId= $optionResult['option_id'];
			$option->optionText=$optionResult['option_text'];
			$optionArray[] = $option;
		}
		$qI->plainText=$qI->plainText.$hrLine;
		$qI->optionsArray=$optionArray;
		
	}
	else if($qI->optionTypeId==1)
		$qI->plainText='<br><br>';
	else 
		$qI->plainText = '<br>';
	$questionArray[] = $qI;

}
return $questionArray;
		//Questions loading code ends


}
echo str_replace(',"nodes":null','',json_encode($sectionArray));;

?>
			