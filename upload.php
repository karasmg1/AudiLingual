<?php
header('Content-Type: text/html; charset=UTF-8');//application/json
include 'savePhrase.php';

$data = array();
// print_r ($_POST);
$lang = $_POST[lang];
    $error = false;
    $files = array();
 
    $uploaddir = 'uploads/';

    // переместим файлы из временной директории в указанную
    
		
        if( move_uploaded_file( $_FILES[0]['tmp_name'], $uploaddir.$_FILES[0][name]) ) {
            
	//		 echo "<p>$files:</p>";
	//		 print_r ($files);
        }
        else{
            $error = true;
        }
    
 


$uploadfile = $uploaddir.$_FILES[0][name];
   
$handle = fopen($uploadfile, "r");
$contents =  '<?xml version="1.0" encoding="UTF-8" ?><document>'.fread($handle, filesize($uploadfile)).'</document>';
fclose($handle);
$handle = fopen($uploadfile, "w");
fwrite($handle, $contents);
fclose($handle);
$xml = simplexml_load_file($uploadfile);
include 'delAllMp3inMp3.php';
$counter=0;
foreach($xml->word as $value){
	if($counter>99) break;
	$counter++;
	savePhrase($value,"ru", "mp3/".$counter."phrase"."1");
	$file = 'silence.mp2';
	$newfile = "mp3/".$counter."phrase"."2.mp3";
	if (!copy($file, $newfile)) {
    echo "не удалось скопировать $file...\n";
	}
	$newfile = "mp3/".$counter."phrase"."4.mp3";
	if (!copy($file, $newfile)) {
    echo "не удалось скопировать $file...\n";
	}
//	echo '<p>'.$value.'</p>';
}
$counter=0;
foreach($xml->translation as $value){
	if($counter>99) break;
	$counter++;
	savePhrase($value, $lang, "mp3/".$counter."phrase"."3");
//	echo '<p>'.$value.'</p>';
}
foreach (glob("uploads/*.*") as $filename) {
   unlink($filename);
}
$zip = new ZipArchive();
$ret = $zip->open('mp3.zip', ZipArchive::OVERWRITE);
if ($ret !== TRUE) {
    printf('Ошибка с кодом %d', $ret);
} else {
   // $options = array('add_path' => 'mp3/', 'remove_all_path' => TRUE);
    $zip->addGlob('mp3/*.mp3');
    $zip->close();
	echo '<a href="mp3.zip" download="mp3.zip">mp3.zip</a>';
}

?>
