<?php 


	include 'config.php';

	try{
		$PDO = new PDO(DSN,USER,PASS);
	}
	catch(PDOException $e) {
    	echo 'Connexion échouée : ' . $e->getMessage();
	}

	}

?>