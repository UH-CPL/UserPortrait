<html>
 <head>
	<title> User Portrait </title>
	<meta name="Author" content="Karl Kyeongan Kwon">
	<meta name="Keywords" content="Karl Kyeongan Kwon">
	<meta name="Description" content="Karl Kyeongan Kwon">


	<script type="text/javascript">
		
		function alertIt()
		{
			alert("Not Available ...");
		}
		
	</script>


<?php 

// ==================== Default Values ====================
// if there are no parameters,
// it generates a User Portrait with default values


$study_title = "Your project name will be here.";
$subjects = 7; // define number of subjects
$namesSubjects = array(S001,S002,S003,S004,S005,S006,S007,S008,S009,S010); // names of Subjects
$cols = 3;// define number of columns for display
$genders = array(M,F,F,M,M,F,M,M,M,F); // Male or Female
$exams = 5;
$f_letter_exams = E;	// For example (E: Exam, T: Task)
$traits = array(0,-1,1,0,0,0,0);	// -1, 0, 1 (Relaxed, Normal, Stressed)
$hideButton = no;
$titleGrades = Grade;
$exLinks;
$studyNo;

// Added two parameters for toyota project
// on Mar 15, 2016 - Karl
$SAIs_Percentile = array(25,50,75);
$grade_Percentile = array(25,50,75);


$namesExams = array
	(
		array(E1,E2,E3,E4,E5,E6,E7,E8),
		array(E1,E2,E3,E4,E5,E6,E7,E8),
		array(E1,E2,E3,E4,E5,E6,E7,E8),
		array(E1,E2,E3,E4,E5,E6,E7,E8),
		array(E1,E2,E3,E4,E5,E6,E7,E8),
		array(E1,E2,E3,E4,E5,E6,E7,E8),
		array(E1,E2,E3,E4,E5,E6,E7,E8),
		array(E1,E2,E3,E4,E5,E6,E7,E8),
		array(E1,E2,E3,E4,E5,E6,E7,E8),
		array(E1,E2,E3,E4,E5,E6,E7,E8)
	);

$grades = array
	(
		array(),
		array(),
		array(),
		array()
	);

$hsv = 'yes';	// (yes, no) if yes, width size is 6px otherwise 0 [hsv = has SAI Value]
$SAIs = array
	(
		array(),
		array(),
		array(),
		array(),
		array()
	);

$stressBar = array
	(
		array(),
		array(),
		array(),
		array(),
		array()
	);

// echo '<pre>';
// print_r($stressBar);
// echo '</pre>';


// ==================== Assignments ====================
// Assignment to Subject Data from URL parameters


$study_title = isset($_GET["title"]) ? $_GET["title"] : $study_title;
$subjects = isset($_GET["subjects"]) ? $_GET["subjects"] : $subjects;
$namesSubjects = isset($_GET['namesSubjects']) ? explode(',', strtoupper($_GET['namesSubjects'])) : $namesSubjects;
$cols = isset($_GET["cols"]) ? $_GET["cols"] : $cols;
$genders = isset($_GET['genders']) ? explode(',', strtoupper($_GET['genders'])) : $genders;
$exams = isset($_GET["exams"]) ? $_GET["exams"] : $exams;
$f_letter_exams = isset($_GET["f_letter_exams"]) ? $_GET["f_letter_exams"] : $f_letter_exams;
$traits = isset($_GET['traits']) ? explode(',', strtoupper($_GET['traits'])) : $traits;
$hideButton = isset($_GET['hideButton']) ? explode(',', strtoupper($_GET['hideButton'])) : $hideButton;
$titleGrades = isset($_GET["titleGrades"]) ? $_GET["titleGrades"] : $titleGrades;

$exLinks = isset($_GET["exLinks"]) ? $_GET["exLinks"] : $exLinks;
$studyNo = isset($_GET["studyNo"]) ? $_GET["studyNo"] : $studyNo;

// Added two parameters for toyota project
// on Mar 15, 2016 - Karl
$SAIs_Percentile = isset($_GET['SAIs_Percentile']) ? explode(',', strtoupper($_GET['SAIs_Percentile'])) : $SAIs_Percentile;
$grade_Percentile = isset($_GET['grade_Percentile']) ? explode(',', strtoupper($_GET['grade_Percentile'])) : $grade_Percentile;

// echo '<pre>';
// print_r($genders);
// echo '</pre>';
// $genders = explode(',', $genders1);


// echo "1: ". $grade_Percentile[0];
// echo "<br>2: ". $grade_Percentile[1];
// echo "<br>3: ". $grade_Percentile[2];



// ==================== Grades ====================

$strGrades = isset($_GET['grades']) ? $_GET['grades'] : $grades;


$strGrades = explode(';', $strGrades);

// echo '<pre>';
// print_r($strGrades);
// echo '</pre>';

if ( isset($strGrades) )
	$grades = array();

foreach ($strGrades as $temp) {
	$grades[] = explode(",", $temp);
}

// echo '<pre>';
// print_r($grades);
// echo '</pre>';


// ==================== Names of Exams ====================

$strNamesExams = isset($_GET['namesExams']) ? $_GET['namesExams'] : $namesExams;


$strNamesExams = explode(';', $strNamesExams);

// echo '<pre>';
// print_r($strNamesExams);
// echo '</pre>';

if ( isset($strNamesExams) )
	$namesExams = array();

foreach ($strNamesExams as $temp) {
	$namesExams[] = explode(",", $temp);
}

// echo '<pre>';
// print_r($namesExams);
// echo '</pre>';

// ==================== StressBars ====================

$strStressBars = isset($_GET['sBars']) ? $_GET['sBars'] : $stressBar;

 // $strStressBars = "10,20,70:5,85,10;30,50,20:15,15,70";

$strStressBars = explode(';', $strStressBars);

// echo '<pre>';
// print_r($strStressBars);
// echo '</pre>';

if ( isset($strStressBars) )
	$stressBar = array();


$idx = 0;
foreach ($strStressBars as $temp)
{
	$tempArray = explode(":", $temp);

	foreach ($tempArray as $temp2)
	{
		$stressBar[$idx][] = explode(",", $temp2);
	}
	$idx++;
}

// echo '<pre>';
// print_r($stressBar);
// echo '</pre>';


// ==================== SAI Values ====================
$hsv = isset($_GET["hsv"]) ? $_GET["hsv"] : $hsv;

if ( $hsv == 'no' )		
	$width_SAI = 0;
else		
	$width_SAI = 6;

$width_Perfromance = $width_SAI*2;

$strSAIs = isset($_GET['SAIs']) ? $_GET['SAIs'] : $SAIs;

$strSAIs = explode(';', $strSAIs);

// echo '<pre>';
// print_r($strSAIs);
// echo '</pre>';

if ( isset($strSAIs) )
	$SAIs = array();


$idx = 0;
foreach ($strSAIs as $temp)
{
	$tempArray = explode(":", $temp);

	foreach ($tempArray as $temp2)
	{
		$SAIs[$idx][] = explode(",", $temp2);
	}
	$idx++;
}

// echo '<pre>';
// print_r($strSAIs);
// echo '</pre>';




// ==================== Generate HTML ====================

$array_point = 0;
$subject_index = 1;

echo "<table width='1050' border='0' align='center' cellpadding='0' cellspacing='2'>";
echo "<tr>
<td colspan='3'>
<h1>".$study_title."</h1>
</td>

</tr>";

echo "<tr>";

for( $tr=1 ; $tr<=$subjects ; $tr++ )
{
	// Decide subject's gender
	if ( $genders[$array_point] == 'M' )
		$selected_gender = "face_with_male";
	else if ( $genders[$array_point] == 'F' )
		$selected_gender = "face_with_female";
	else 
		$selected_gender = "gender_na";

	// Decide subject's trait status
	if ( $selected_gender != "gender_na" )
	{
		if ( $traits[$array_point] == -1 )
			$selected_gender = $selected_gender."_r";	// relaxed (r)
		else if ( $traits[$array_point] == 1 )
			$selected_gender = $selected_gender."_s";	// stressed (s)
		else
			$selected_gender = $selected_gender;	// No changed for normal trait
	}

	// Add prefix file name (png)
	$selected_gender = $selected_gender.".png";

	// print_r($selected_gender);
	// echo "<p>";

	

	echo "
		<td width='350'>

			<table width='345' border='0' cellpadding='0' cellspacing='3' style='border:1px solid #000' align='center'>
				  <tr>
					<td width='224' align='center' valign='middle'><div id='".$namesSubjects[$array_point]."'><h2>Subject ".$namesSubjects[$array_point]."</h2><a target='_parent' href='".$exLinks."?&studyNo=".$studyNo."&SubjectId=".$namesSubjects[$array_point]."'><img src='./../common/img/".$selected_gender."' width='140'/></a></div></td></td>
				  <td width='151' rowspan='2' valign='middle'>

				<!-- Profile Table -->
				<table width='175' border='0' cellpadding='0' cellspacing='4' style='border:1px solid #6098EC'>
					<tr>
						<th colspan='1'></th>
						<th colspan='3' align='center'>Stress<!--<img src='./../common/img/title_stress_grade_large_new.png' align='right' width='160'/>--></th>
						<th colspan='1' align='right'>".$titleGrades."</th>
					</tr>";

		$pSAI = 0;

		for ( $idx = 1; $idx <= $exams ; $idx++ )
		{
			$left = true;

			for ( $two = 0 ; $two < 2 ; $two ++ )
			{
				/*if ( $two == 0 )
				{
					$selected_sai_left = "sai_left";

					if ( $SAIs[$array_point][$idx-1][$two] == -1 )
						$selected_sai_left = $selected_sai_left."_r";	// relaxed (r)
					else if ( $SAIs[$array_point][$idx-1][$two] == 1 )
						$selected_sai_left = $selected_sai_left."_s";	// stressed (s)
					else
						$selected_sai_left = $selected_sai_left;	// No changed for normal trait

					$left = false;
				}
				else
				{*/
			if ( $two == 0 ) {
					$selected_sai_right = "c";

					if ( $SAIs[$array_point][$idx-1][$two] >= $SAIs_Percentile[2] )
						$selected_sai_right = $selected_sai_right."6";	// relaxed (r)
					else if ( $SAIs[$array_point][$idx-1][$two] >= $SAIs_Percentile[1] )
						$selected_sai_right = $selected_sai_right."4";	// stressed (s)
					else if ( $SAIs[$array_point][$idx-1][$two] >= $SAIs_Percentile[0] )
						$selected_sai_right = $selected_sai_right."1";	// stressed (s)
					else if ( $SAIs[$array_point][$idx-1][$two] >= 0 )
						$selected_sai_right = $selected_sai_right."0";	// stressed (s)
					/*else if ( $SAIs[$array_point][$idx-1][$two] > 20 )
						$selected_sai_right = $selected_sai_right."5";	// stressed (s)
					else if ( $SAIs[$array_point][$idx-1][$two] > 0 )
						$selected_sai_right = $selected_sai_right."6";	// stressed (s)*/
			}
			//	}
				
				$pSAI++;
			}			

			$selected_sai_left = $selected_sai_left.".png";
			$selected_sai_right = $selected_sai_right.".png";

			// echo "<pre>";
			// print_r($stressBar);
			// echo ", ";

			echo "
			<tr>
				<td width='15'>".$namesExams[$array_point][$idx-1]."</td>
				<!-- <td><img src='./../common/img/".$selected_sai_left."' height='12' width='".$width_SAI."'/></td>  -->
				<td width=''>";

			$width_sbar_r;
			$width_sbar_n;
			$width_sbar_s;



			for ( $three = 2 ; $three >= 0 ; $three -- )
			{
				if( !isset($stressBar[$array_point][$idx-1]) || count($stressBar[$array_point][$idx-1]) != 3 )
				{
					echo "<img src='./../common/img/profile_under_construction.png' height='12' width='100'/>";
					break;
				}

				if ( $three == 0 )
				{
					$width_sbar_r = isset($stressBar[$array_point][$idx-1][$three]) ? $stressBar[$array_point][$idx-1][$three] : 0;
					// print_r($width_sbar_r);
					// if ( $width_sbar_r != 0 )
					echo "<img src='./../common/img/sbar_r.png' height='12' width='".$width_sbar_r."'/>";
				}
				else if ( $three == 1 )
				{
					$width_sbar_n = isset($stressBar[$array_point][$idx-1][$three]) ? $stressBar[$array_point][$idx-1][$three] : 0;
					// $width_sbar_n = $stressBar[$array_point][$idx-1][$three];
					// print_r($width_sbar_n);
					// if ( $width_sbar_n != 0 )
					echo "<img src='./../common/img/sbar_n.png' height='12' width='".$width_sbar_n."'/>";
				}
				else
				{
					$width_sbar_s = isset($stressBar[$array_point][$idx-1][$three]) ? $stressBar[$array_point][$idx-1][$three] : 0;
					// $width_sbar_s = $stressBar[$array_point][$idx-1][$three];
					// print_r($width_sbar_s);
					//if ( $width_sbar_s != 0 )
					echo "<img src='./../common/img/sbar_s.png' height='12' width='".$width_sbar_s."'/>";
				}
				// echo "three: ".$three;

				// if ( $width_sbar_r == 0 & $width_sbar_n == 0 & $width_sbar_s == 0 )
					//echo "<img src='./../common/img/profile_under_construction.png' height='12' width='100'/>";
					// break;

			}

			echo "</td>";

			echo "<td><img src='./../common/img/".$selected_sai_right."' height='12' width='".$width_SAI."'/></td>";


			if($grades[$array_point][$idx-1] <= $grade_Percentile[0]) {
				echo "<td> </td><td width='35' align='right'> <img src='./../common/img/20p.png' height='12' width='".$width_Perfromance."'/> </td>";
			}
			else if($grades[$array_point][$idx-1] <= $grade_Percentile[1])
				echo "<td> </td><td width='35' align='right' > <img src='./../common/img/40p.png' height='12' width='".$width_Perfromance."'/> </td>";
			else if($grades[$array_point][$idx-1] <= $grade_Percentile[2])
				echo "<td> </td><td width='35' align='right'> <img src='./../common/img/80p.png' height='12' width='".$width_Perfromance."'/> </td>";
			else if($grades[$array_point][$idx-1] == "NA")
				echo "<td> </td><td width='35' align='right'>NA</td>";
			else 
				echo "<td> </td><td width='35' align='right'> <img src='./../common/img/100p.png' height='12' width='".$width_Perfromance."'/> </td>";

			echo "</tr>";
		}

			echo "</table>

				</td>
			  </tr>
		  <tr align='center' valign='middle'>
			<td width='224' valign='middle'>
			
			<table border='0' cellpadding='1' cellspacing='0'>
				<tr>
					<td>";
					if ( $hideButton == no ) {
						echo "<a href='#' onclick='alertIt(); return false' target='_blank' class='btn'>BR</a>
						<a href='#' onclick='alertIt(); return false' target='_blank' class='btn'>HR</a>
						<a href='#' onclick='alertIt(); return false' target='_blank' class='btn'>EDA</a>";
					}

					echo "</td>
				</tr>
				<tr>
					<td>";
					if ( $hideButton == no ) {

						echo "<a href='#' onclick='alertIt(); return false' target='_blank' class='btn'>FOOT</a>
						<a href='#' onclick='alertIt(); return false' target='_blank' class='btn'>CORE</a>
						<a href='#' onclick='alertIt(); return false' target='_blank' class='btn'>HAND</a>";
					}
					
					echo "</td>
				</tr>
			</table>
		
		  </td>
		  </tr>
			</table>        
        
        </td>
	";
	
	$array_point++;
	$subject_index++;

	if( $tr % $cols == 0 )
	{
		echo "</tr>";
		echo "<tr><td height='10'></td></tr>";
		echo "<tr>";
	}
}

echo "</tr></table>";

 
?>

<script src="./js/jquery.blockUI.js"></script>

<style type="text/css">

	body{
		font-family: verdana, sans-serif;
		font-size: 11px;
		background-color: #FFFFFF;
		/*margin:5em 5em 5em 5em;*/
		line-height:150%;
		margin:10 0 10 0;
		padding:0;
	}

	td {
		font-family: verdana, sans-serif;
		font-size: 11px;
		line-height:150%;
	}

	th {
		font-family: ColaborateThinRegular, Arial, sans-serif;
		font-size: 13px;
		color: #003366;
	}

	h1 {
		font-family: ColaborateThinRegular, Arial, sans-serif;
		font-size: 2.5em;
		line-height: 1.2em;
		margin: 0 0 .5em;
		color: #00728F;
	}

	h2 {
		font-family: ColaborateThinRegular, Arial, sans-serif;
		font-size: 1.7em;
		line-height: 1.2em;
		margin: 0 0 .5em;
		color: #00728F;
	}

	.btn {
		-moz-box-shadow:inset 0px 1px 0px 0px #bbdaf7;
		-webkit-box-shadow:inset 0px 1px 0px 0px #bbdaf7;
		box-shadow:inset 0px 1px 0px 0px #bbdaf7;
		background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #79bbff), color-stop(1, #378de5) );
		background:-moz-linear-gradient( center top, #79bbff 5%, #378de5 100% );
		filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#79bbff', endColorstr='#378de5');
		background-color:#79bbff;
		-moz-border-radius:6px;
		-webkit-border-radius:6px;
		border-radius:6px;
		border:1px solid #84bbf3;
		display:inline-block;
		color:#ffffff;
		font-family:arial;
		font-size:10px;

		padding:1px 5px;
		text-decoration:none;
		text-shadow:1px 1px 0px #528ecc;
		text-align:center;
		width:30px;

	}.btn:hover {
		background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #378de5), color-stop(1, #79bbff) );
		background:-moz-linear-gradient( center top, #378de5 5%, #79bbff 100% );
		filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#378de5', endColorstr='#79bbff');
		background-color:#378de5;
	}.btn:active {
		position:relative;
		top:1px;
	}

	sbar {
    	float: left;
	}

</style>
  

</html>