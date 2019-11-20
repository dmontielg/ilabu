<?php	
	
	include_once ("Database.php");

	class Transaction
	{				
		function __construct(){}			

		function execute($sql){
			
			$db = new Database();												
			$server = $db->getServer();
			$database = $db->getDatabase();
			$username = $db->getUserName();
			$password = $db->getPassword();
			
			try
			{												
				#$dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
				$dbh = new PDO("mysql:host=$server;dbname=$database", $username, $password);
				/*** echo a message saying we have connected ***/				
				#echo 'Connected to database<br />';
				/*** set the PDO error mode to exception ***/
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				/*** begin the transaction ***/
				$dbh->beginTransaction();				
				/***  INSERT statements ***/
				#$dbh->prepare($sql);

				$dbh->exec($sql);
				/*** commit the transaction ***/
				$dbh->commit();
				/*** echo a message to say the database was created ***/
				#echo 'Data entered successfully<br />';
				return true;
			}
			catch(PDOException $e)
			{
				/*** roll back the transaction if we fail ***/
				$dbh->rollback();
				/*** echo the sql statement and error message ***/
				#echo $sql . '<br />' . $e->getMessage();
				return false;
			}
		}
	}
?>