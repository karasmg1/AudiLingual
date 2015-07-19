<?php
function savePhrase($str,$ln,$fn){
$StringToSpeech="http://translate.google.com/translate_tts?ie=UTF-8&q=".urlencode($str)."&tl=".$ln; 
$fileNameMp3=$fn.".mp3";

$googleUrl = curl_init($StringToSpeech);
try{
$fileDescriptor = fopen($fileNameMp3, "w");
}
catch(Exception $exp)
{
exit('Не могу открыть файл fopen()');
}

curl_setopt($googleUrl, CURLOPT_FILE, $fileDescriptor);
curl_setopt($googleUrl, CURLOPT_HEADER, 0);

curl_exec($googleUrl);
curl_close($googleUrl);
fclose($fileDescriptor);
return true;
}

?> 