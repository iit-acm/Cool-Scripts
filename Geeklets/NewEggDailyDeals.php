<?php
function find($findme, $data){
   preg_match_all($findme, $data, $matches);
   return $matches[1];
}

function get_deals(){
   $file ="http://www.newegg.com/DailyDeal.aspx";

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

/*
function get_OldPrice($priceArr, $readDoc){
   $oldPriceArray = array();

   //cut up itemCells
   $itemCell = array();
   for ($i = 1; $i < count($priceArr)+1; $i++) {
      $search = '/cellItem11>(.*?)<a class=\"itemBrand\"/s';      
      if(preg_match($search, $readDoc, $found)){
         $itemCell[$i-1] = $found;
         echo $found[1];
      }else
         echo "cannot retrieve info";
   }

   //see which cuts have old prices
   for ($i = 0; $i < count($priceArr); $i++) {
      $search2 = '/<span class=\"label\">Was: <\/span><span>(.*?)<\/span>/';
      $check = preg_match($search2, $itemCell[$i], $matches2);
      if($check != 0 ){
         //old price was found, use it
         $oldPriceArray[$i] = $matches2[1];
      }else{
         //no old price was present, use the sale price
         $search3 = '/<strong>(.*?)<\/strong>/';
         $prices = find($search3, $itemCell[$i]);
         $oldPriceArray[$i] = $prices[0];
      }
   }

   return $oldPriceArray;
}
 */

function replaceChars($string){
   //check for "
   $pattern = array("/&#34/","/&#40/","/&#41/","/&#47/");
   $replacement = array("\"","(",")","/");
   for ($i = 0; $i < count($pattern); $i++) {
      $string = preg_replace($pattern[$i], $replacement[$i], $string);
   }

   //remove the ";'s"
   $string = preg_replace("/;/", "", $string);
   return $string;
}

$result_doc = get_deals();

$regex = '/block\">(.*?)<\/span>/';
$titles = find($regex, $result_doc);
$titles = replaceChars($titles);

$regex = '/<strong>(.*?)<\/strong>/';
$prices = find($regex, $result_doc);

//$priceWas = get_OldPrice($prices, $result_doc);

//print top
//echo "Was:\t\tNow:\t\tProduct:\n";
echo "$$$:\t\tProduct:\n";

for ($i = 0; $i < count($titles); $i++) {
   //echo $priceWas[$i]."\t\t$".$prices[$i+1]."\t\t".$titles[$i]."\n";
   //the +1 is to ignore the "English" in one of the strong tags
   echo "$".$prices[$i+1]."\t\t".$titles[$i]."\n";

}



?>


