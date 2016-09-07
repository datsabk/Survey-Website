<?php include 'config.php' ?>
<?php
session_start();
$sql= "select * from question_details where parent_template_id =".$_POST['templateId']." and parent_section_id = (select section_id from section_details where section_name =".$_POST['sectionname'].")";
$stmt= $db->query($sql);
$results = array();

if(!empty($stmt) AND $stmt ->rowCount() > 0)
{
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
class Option{

	public $optionId;
	public $optionText;

}

class Question{
	public $questionText;
	public $optionsArray;
	public $answerText;
	public $questionId;
	public $optionTypeId;
}
$questionArray=array();
foreach($results as $question)
{
	$qI= new Question();
	$qI->optionsArray= array();
	$qI->questionText = $question['question_text'];
	$qI->answerText='';
	$qI->questionId=$question['question_id'];
	$qI->optionTypeId=$question['option_type_id'];
	if($qI->optionTypeId==2 || $qI->optionTypeId==3)
	{
		$optionArray = array();
		$sql2 = 'select * from options_details where parent_question_id = '.$qI->questionId;

		$stmt2= $db->query($sql2);
		$optionsResult = array();
		if(!empty($stmt2) AND $stmt2 ->rowCount() > 0)
		{
			$optionsResult = $stmt2->fetchAll(PDO::FETCH_ASSOC);
		}
		foreach($optionsResult as $optionResult)
		{
			$option= new Option();
			$option->optionId= $optionResult['option_id'];
			$option->optionText=$optionResult['option_text'];
			$optionArray[] = $option;
		}
		$qI->optionsArray=$optionArray;

	}
	$questionArray[] = $qI;

}
echo json_encode($questionArray);
?>	