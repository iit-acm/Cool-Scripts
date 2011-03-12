<?php
//set this to select when the week starts
// 0 = Monday
// 1 = Sunday
$day_start = 0;

//set this to your time zone
date_default_timezone_set("America/Chicago");

$today = date("j");
$first_day = date("w", mktime(0, 0, 0, date("n"), 1, date("Y")))+$day_start;

$total = date("t");
		
$j = $first_day;
		
printf(" %s :: %s\n",date("F"),date("Y"));//nombre_mes($mes));
printf(" M  T  W  TH  F  S  SU\n");

//white spaces
for ($x = 1 ; $x < $j ; $x++)
	printf("   ");

//days of the month
for ($i = 1 ; $i <= $total ; $i++) {
	if($i == $today) {
		$color_day = ($today < 10) ? '  '.$i : ' '.$i;
		echo chr(27),'[','31m',$color_day,chr(27),'[','0m';
	} else
		printf("%3d",$i);

	//end of the week
	if ($j == 7){	
		$j = 0;
		printf("\n");
	}
	$j++;
}
	
printf("\n");
?>
