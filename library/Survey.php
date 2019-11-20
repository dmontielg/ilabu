<?php

	include_once ("Database.php");

	class Survey
	{
			private $id_survey		;			
			private $id_role  	    ;
			private $id_survey	    ;			
			
			private $connection  	;
			private $table  	    ;

		function __construct()
		{
				$ob = new Database();
				$this->connection = $ob->getConnection();
				$this->table = "survey" ;
		}

		function insert($survey)
		{
					$sql = "INSERT INTO $this->table VALUES
					(						
						 ". $user_event['id_survey'] .",
						 ". $user_event['id_role'] .",
						 ". $user_event['survey'] .",                        						
                                                '')";
			$this->connection->query($sql) ;
                        
			return $this->connection->insert_id ;
		}

		function update($survey)
		{
				$sql = "UPDATE $this->table SET
						id_survey 	= '". $survey['id_survey'] ."',
						id_role 	= '". $survey['id_role'] ."'                                                
						survey = '". $survey['survey'] ."'                                                
						WHERE id_survey = " .$survey['id_survey'] ;

					return 	$this->connection->query($sql) ;
		}                
               
		function delete($id_survey)
		{
				$sql = "DELETE FROM $this->table WHERE id_survey = ".$id_survey ;

				return 	$this->connection->query($sql) ;
		}

		function loadById($id_survey)
		{
			$sql = " SELECT * FROM $this->table WHERE id_survey = $id_survey" ;
			$resultado = $this->connection->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc() ;
				$this->id_survey    = $row['id_survey'] ;
				$this->id_role         = $row['id_role'] ;
				$this->survey          = $row['survey'] ;								
			}
			return $resultado->num_rows ;
        }
        
        function loadByIdRole($id_role)
		{
			$sql = " SELECT * FROM $this->table WHERE id_role = $id_role" ;
			$resultado = $this->connection->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc() ;
				$this->id_survey    = $row['id_survey'] ;
				$this->id_role      = $row['id_role'] ;								
				$this->survey       = $row['survey'] ;				
			}
			return $resultado->num_rows ;
		}

		function getAll()
		{
				$sql = "SELECT * FROM $this->table" ;
				$resultado = $this->connection->query($sql) ;
				$array_survey = array() ;
				if($resultado->num_rows>0)
				{
					while ($row = $resultado->fetch_assoc())
					{
						$array_survey[] = $row ;
					}
				}
				return $array_survey ;
		}

		function getAllJson()
		{
			return json_encode($this->getAll(), true);
		}
		
		function getId()
		{
			return $this->id_survey ;
		}	     
		
		function getIdRole()
		{
			return $this->id_role ;
		}

		function getSurvey()
		{
			return $this->survey ;
		}		
	}
?>