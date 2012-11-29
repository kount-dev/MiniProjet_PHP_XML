<?php 

class DB {

	private static $oPDO;

	/**
	 * @param data source name
	 * @param user'name
	 * @param password'name
	 **/
	public static function connect($sDsn, $sUser, $sPassword){
		try
		{
			self::$oPDO = new PDO($sDsn, $sUser, $sPassword);
		}
		catch (PDOException $e) 
		{
			echo "Connexion échouée : " . $e->getMessage();
			die();
		}
	}

	/**
	 * @return PDO
	 **/
	public static function getInstance(){
		return self::$oPDO;
	}

	/**
	 * @param query execute on database
	 * @param data array to be processed
	 * 
	 * @return query result
	 **/
	public static function query($sQuery, $aData){
		$oPDOStatement = self::getInstance()->prepare($sQuery);
		if($aData == NULL) $oPDOStatement->execute();
		else $oPDOStatement->execute($aData);

		return $oPDOStatement->fetchAll();
	}


}



?>