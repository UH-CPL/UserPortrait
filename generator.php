<html>
 <head>
	<title> User Portrait </title>
	<meta name="Generator" content="EditPlus">
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
$cols = 3;// define number of columns for display
$genders = array(M,F,F,M,M,F,M,M,M,F); // Male or Female
$no_exams = 5;
$traits = array(0,-1,1,0,0,0,0);	// -1, 0, 1 (Relaxed, Normal, Stressed)

$grades = array
	(
		array(96,95,100),
		array(),
		array(),
		array(), array(), array(), array(), array()
	);

$hsv = 'yes';	// (yes, no) if yes, width size is 6px otherwise 0 [hsv = has SAI Value]
$SAIs = array
	(
		array(), array(), array(), array(), array(), array(), array()
	);

$stressBar = array
	(
		array(
			array(20,50,30),		// Percentile of Relaxed (30%)
			array(80,5,15),		// Percentile of Normal (50%)
			array(15)		// Percentile of Stressed (30%)
			),
		array(
			array(30,40,30),		// Percentile of Relaxed (30%)
			array(0,0,40),		// Percentile of Normal (50%)
			array(10,10,10)		// Percentile of Stressed (30%)
			),
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


$study_title = isset($_GET["t"]) ? $_GET["t"] : $study_title;
$subjects = isset($_GET["subjects"]) ? $_GET["subjects"] : $subjects;
$cols = isset($_GET["cols"]) ? $_GET["cols"] : $cols;
$genders = isset($_GET['genders']) ? explode(',', strtoupper($_GET['genders'])) : $genders;
$no_exams = isset($_GET["no_exams"]) ? $_GET["no_exams"] : $no_exams;
$traits = isset($_GET['traits']) ? explode(',', strtoupper($_GET['traits'])) : $traits;

// echo '<pre>';
// print_r($genders);
// echo '</pre>';
// $genders = explode(',', $genders1);



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

// echo $hsv;
//$subjects = count($genders);





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

			// echo "<pre>";
			// print_r($stressBar);
			// echo ", ";

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
