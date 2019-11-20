<?php

	include_once ("Database.php");

	class InfoEvent
	{
			private $id_info_event	;			
			private $event  	    ;

			private $connection  	;
			private $table  	    ;

		function __construct()
		{
				$ob = new Database();
				$this->connection = $ob->getConnection();
				$this->table = "event" ;
		}

		function insert($info_event)
		{
					$sql = "INSERT INTO $this->table VALUES
					(						
						 ". $info_event['id_info_event'] .",
						 '". $info_event['event'] ."',						 
                                                '')";
			$this->connection->query($sql) ;
                        
			return $this->connection->insert_id ;
		}

		function update($info_event)
		{
				$sql = "UPDATE $this->table SET
						id_info_event 	= '". $info_event['id_info_event'] ."',
						event 	        = '". $info_event['event'] ."'                                                						
						WHERE id_info_event   = " .$info_event['id_info_event'] ;

					return 	$this->connection->query($sql) ;
		}                
               
		function delete($id_info_event)
		{
				$sql = "DELETE FROM $this->table WHERE id_info_event = ".$id_info_event ;

				return 	$this->connection->query($sql) ;
		}

		function loadById($id_info_event)
		{
			$sql = " SELECT * FROM $this->table WHERE id_info_event = $id_info_event" ;
			$resultado = $this->connection->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc() ;
				$this->id_info_event    = $row['id_info_event'] ;
				$this->event       = $row['event'] ;				
			}
			return $resultado->num_rows ;
        }                

		function getAll()
		{
				$sql = "SELECT * FROM $this->table" ;
				$resultado = $this->connection->query($sql) ;
				$array_event = array() ;
				if($resultado->num_rows>0)
				{
					while ($row = $resultado->fetch_assoc())
					{
						$array_event[] = $row ;
					}
				}
				return $array_event ;
		}

		function getAllJson()
		{
			return json_encode($this->getAll(), true);
		}
		
		function getId()
		{
			return $this->id_info_event ;
		}	     
		
		function getEvent()
		{
			return $this->event ;
		}
	}
?>