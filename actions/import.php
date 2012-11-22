<?php 
$test = simplexml_load_file($_FILES['xml_import']['tmp_name']);

foreach ($test->children() as $FILM => $FILS){
	echo $FILM . '<br>';
	foreach ($FILS->children() as $DESC => $VALUE) {
		echo $DESC;
		if($DESC == "TITRE" || $DESC == "GENRES" || $DESC == "ACTEURS"){
			echo '<br>';
			foreach ($VALUE->children() as $OBJ => $TRUCK){
				echo $OBJ . ' = ' . utf8_decode($TRUCK) . '<br>';
			} 
		}
		else{
			echo ' = ' . utf8_decode($VALUE) . '<br>'; 
		}
	}
}




?>