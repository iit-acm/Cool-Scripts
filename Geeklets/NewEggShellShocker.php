<?php
function find($findme, $data){
   preg_match_all($findme, $data, $matches);
   return $matches[1];
}

function get_deals(){
   $file ="http://www.newegg.com/";

   $ch=curl_init();
   curl_setopt($ch,CURLOPT_URL,$file);
   curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
   $_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'],0);
   curl_setopt($ch,CURLOPT_REFERER,$_SERVER['REQUEST_URI']);
   $result_raw=curl_exec($ch);
   $result = utf8_encode($result_raw);
   curl_close($ch);

  return $result;
}

function replaceChars($string){
   //check for "
   $pattern = array("/&#34/","/&#40/","/&#41/","/&#47/","/<span>/","/<\/span>/","/&#39/");
   $replacement = array("\"","(",")","/","","","'");
   for ($i = 0; $i < count($pattern); $i++) {
      $string = preg_replace($pattern[$i], $replacement[$i], $string);
   }

   //remove the ";'s"
   $string = preg_replace("/;/", "", $string);
   return $string;
}

//find the results
$result_doc = get_deals();

$regex = '/prodTitle\">(.*?)<\/strong>/';
$title = find($regex, $result_doc);
$title = replaceChars($title);

$regex = '/dollars\">(.*?)<\/span>/';
$old_prices = find($regex, $result_doc);
$old_prices = replaceChars($old_prices);

$regex = '/dollars\">(.*?)<\/strong>/';
$new_prices = find($regex, $result_doc);
$new_prices = replaceChars($new_prices);

//print results back to user
//**see color list at end of file for custom colors
echo "\033[37m"."Product Spotlight:\n".$title[0].":\n was: ".$old_prices[0]." \tnow: \033[36m".$new_prices[0]."\n\n";
echo "\033[37m"."Shell Shocker:\n".$title[1].":\n was: ".$old_prices[2]." \tnow: \033[36m".$new_prices[1];

/*=== COLOR NUMBERS!! ===================================
change the numbers after the "[" to change the color
i.e. \033[37m will turn the text white

the number below correspond to their appropriate color:

30 -> black
31 -> red
32 -> green
33 -> yellow
34 -> blue
35 -> magenta
36 -> cyan
37 -> white
=========================================================*/
?>


