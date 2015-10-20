<html>
<head>
	<title> Home | User Portrait</title>
	<meta name="Generator" content="EditPlus">
	<meta name="Generator" content="Sublime Text">
	<meta name="Author" content="Kyeongan (Karl) Kwon">
	<meta name="Keywords" content="Data Visualization, Information Visualization, Tools">
	<meta name="Description" content="User Portrait is a visualization tool to condense large-scale data in User Study.">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
</head>

<?php

// ==================== Default Values ====================
// if there are no parameters,
// it generates a User Portrait with default values


$hsv = 'yes';	// (yes, no) if yes, width size is 6px otherwise 0 [hsv = has SAI Value]
$SAIs = array
(
	array(), array(), array(), array(), array(), array(), array()
	);

$stressBar = array
(
	array(
			array(20,50,30),		// Percentile of Relaxed (30%)
			array(80,5,15),			// Percentile of Normal (50%)
			array(15)				// Percentile of Stressed (30%)
			),
	array(
			array(30,40,30),		// Percentile of Relaxed (30%)
			array(0,0,40),			// Percentile of Normal (50%)
			array(10,10,10)			// Percentile of Stressed (30%)
			),
	array(),
	array(),
	array(),
	array(),
	array()
	);


// ==================== Assignments ====================
// Assignment to Subject Data from URL parameters


$study_title = isset($_GET["t"]) ? $_GET["t"] : $study_title;
$subjects = isset($_GET["subjects"]) ? $_GET["subjects"] : $subjects;
$cols = isset($_GET["cols"]) ? $_GET["cols"] : $cols;
$genders = isset($_GET['genders']) ? explode(',', strtoupper($_GET['genders'])) : $genders;
$no_exams = isset($_GET["no_exams"]) ? $_GET["no_exams"] : $no_exams;
$traits = isset($_GET['traits']) ? explode(',', strtoupper($_GET['traits'])) : $traits;



// ==================== Grades ====================

$strGrades = isset($_GET['grades']) ? $_GET['grades'] : $grades;


$strGrades = explode(';', $strGrades);

if ( isset($strGrades) )
	$grades = array();

foreach ($strGrades as $temp) {
	$grades[] = explode(",", $temp);
}



// ==================== StressBars ====================

$strStressBars = isset($_GET['sBars']) ? $_GET['sBars'] : $stressBar;
$strStressBars = explode(';', $strStressBars);

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


// ==================== SAI Values ====================
$hsv = isset($_GET["hsv"]) ? $_GET["hsv"] : $hsv;

if ( $hsv == 'no' )
	$width_SAI = 0;
else
	$width_SAI = 6;



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



	echo "
		<td width='350'>

			<table width='345' border='0' cellpadding='0' cellspacing='3' style='border:1px solid #000' align='center'>
				<tr>
					<td width='224' align='center' valign='middle'><h2>Subject S".str_pad($subject_index, 3, "0", STR_PAD_LEFT)."</h2><img src='./../common/img/".$selected_gender."' width='140'/></td></td>
					<td width='151' rowspan='2' valign='middle'>

				<!-- Profile Table -->
				<table width='175' border='0' cellpadding='0' cellspacing='4' style='border:1px solid #6098EC'>
					<tr>
						<td colspan='5'><img src='./../common/img/title_stress_grade_large.png' align='right' width='160'/></td>
					</tr>";

		$pSAI = 0;

		for ( $idx = 1; $idx <= $no_exams ; $idx++ )
		{
			$left = true;

			for ( $idx_SAI = 0 ; $idx_SAI < 2 ; $idx_SAI ++ )
			{
				if ( $left == true )
				{
					$selected_sai_left = "sai_left";

					if ( $SAIs[$array_point][$pSAI] == -1 )
						$selected_sai_left = $selected_sai_left."_r";	// relaxed (r)
					else if ( $SAIs[$array_point][$pSAI] == 1 )
						$selected_sai_left = $selected_sai_left."_s";	// stressed (s)
					else
						$selected_sai_left = $selected_sai_left;	// No changed for normal trait

					$left = false;
				}
				else
				{

					$selected_sai_right = "sai_right";

					if ( $SAIs[$array_point][$pSAI] == -1 )
						$selected_sai_right = $selected_sai_right."_r";	// relaxed (r)
					else if ( $SAIs[$array_point][$pSAI] == 1 )
						$selected_sai_right = $selected_sai_right."_s";	// stressed (s)
				}
				$pSAI++;
			}

			$selected_sai_left = $selected_sai_left.".png";
			$selected_sai_right = $selected_sai_right.".png";


			echo "
			<tr>
				<td width='15'>E".$idx."</td>
				<td><img src='./../common/img/".$selected_sai_left."' height='12' width='".$width_SAI."'/></td>
				<td width=''>";

			$width_sbar_r = 0;
			$width_sbar_n = 0;
			$width_sbar_s = 0;

			for ( $three = 0 ; $three < 3 ; $three ++ )
			{
				if( !isset($stressBar[$array_point][$idx-1]) )
				{
					echo "<img src='./../common/img/profile_under_construction.png' height='12' width='100'/>";
					break;
				}

				if ( $three == 0 )
				{
					$width_sbar_r = isset($stressBar[$array_point][$idx-1][$three]) ? $stressBar[$array_point][$idx-1][$three] : 0;
					// print_r($width_sbar_r);
					echo "<img src='./../common/img/sbar_r.png' height='12' width='".$width_sbar_r."'/>";
				}
				else if ( $three == 1 )
				{
					$width_sbar_n = isset($stressBar[$array_point][$idx-1][$three]) ? $stressBar[$array_point][$idx-1][$three] : 0;
					// $width_sbar_n = $stressBar[$array_point][$idx-1][$three];
					// print_r($width_sbar_n);
					echo "<img src='./../common/img/sbar_n.png' height='12' width='".$width_sbar_n."'/>";
				}
				else
				{
					$width_sbar_s = isset($stressBar[$array_point][$idx-1][$three]) ? $stressBar[$array_point][$idx-1][$three] : 0;
					// $width_sbar_s = $stressBar[$array_point][$idx-1][$three];
					// print_r($width_sbar_s);
					echo "<img src='./../common/img/sbar_s.png' height='12' width='".$width_sbar_s."'/>";
				}
				// echo "three: ".$three;
			}

			echo "</td>";

			echo "<td><img src='./../common/img/".$selected_sai_right."' height='12' width='".$width_SAI."'/></td>
				<td width='35' align='right'><!--<font color='white'>0</font>-->".$grades[$array_point][$idx-1]."%</td>
			</tr>";

		}

			echo "</table>

				</td>
			</tr>
			<tr align='center' valign='middle'>
			<td width='224' valign='middle'>

			<table border='0' cellpadding='1' cellspacing='0'>
				<tr>
					<td>
						<a href='#' onclick='alertIt(); return false' target='_blank' class='btn'>BR</a>
						<a href='#' onclick='alertIt(); return false' target='_blank' class='btn'>HR</a>
						<a href='#' onclick='alertIt(); return false' target='_blank' class='btn'>EDA</a>
					</td>
				</tr>
				<tr>
					<td>
						<a href='#' onclick='alertIt(); return false' target='_blank' class='btn'>FOOT</a>
						<a href='#' onclick='alertIt(); return false' target='_blank' class='btn'>CORE</a>
						<a href='#' onclick='alertIt(); return false' target='_blank' class='btn'>HAND</a>
					</td>
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

<script src="./js/functions.js"></script>

</html>
