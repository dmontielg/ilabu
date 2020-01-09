<?php

	include_once ("Database.php");

	class Event
	{
			private $id_event	    ;			
			private $id_info_event  ;						
			private $id_role	    ;						
			private $address	    ;
			private $event  	    ;			
			private $description	;
			private $session_number	;
			private $date		    ;
			private $code			;
			            
			private $connection  	;
			private $table  	    ;

		function __construct()
		{
				$ob = new Database();
				$this->connection = $ob->getConnection();
				$this->table = "event" ;
		}

		function insert($event)
		{
					$sql = "INSERT INTO $this->table VALUES
					(						
						".  $event['id_event'] .",
						".  $event['id_info_event'] .",
						".  $event['id_role'] .",
						'". $event['event'] ."',
						'". $event['address'] ."',
						'". $event['description'] ."',
						'". $event['session_number'] ."',
						'". $event['date'] ."',    						
						'". $event['code'] ."'    						
                                                '')";
			$this->connection->query($sql) ;
                        
			return $this->connection->insert_id ;
		}

		function update($event)
		{
				$sql = "UPDATE $this->table SET
						id_info_event 	= '". $event['id_info_event'] ."',
						id_role 		= '". $event['id_role'] ."',
						event 	    	= '". $event['event'] ."',
						address 		= '". $event['address'] ."',						
                        description 	= '". $event['description'] ."',						
						session_number 	= '". $event['session_number'] ."',						
                        date 			= '". $event['date'] ."',
						code 			= '". $event['code'] ."'
                        
						WHERE id_event = " .$event['id_event'] ;

					return 	$this->connection->query($sql) ;
		}
                
               
		function delete($id_event)
		{
				$sql = "DELETE FROM $this->table WHERE id_event = ".$id_event ;

				return 	$this->connection->query($sql) ;
		}

		function loadById($id_event)
		{
			$sql = " SELECT * FROM $this->table WHERE id_event = $id_event" ;
			$resultado = $this->connection->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc() ;
				$this->id_event     	= $row['id_event'] ;
				$this->id_info_event  	= $row['id_info_event'] ;
				$this->id_role	    	= $row['id_role'] ;
				$this->event        	= $row['event'] ;
				$this->address      	= $row['address'] ;
				$this->description  	= $row['description'] ;
				$this->session_number  	= $row['session_number'] ;
				$this->date         	= $row['date'] ;				                
				$this->code         	= $row['code'] ;				                
			}
			return $resultado->num_rows ;
		}
		
		function loadIdByRegistration($id_role,$id_info_event,$session_number)
		{
			$sql = " SELECT * FROM $this->table WHERE 
					id_role = $id_role AND
					id_info_event = $id_info_event AND
					session_number = '".$session_number."'" ;
			
			$resultado = $this->connection->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc() ;
				$this->id_event	= $row['id_event'] ;				
			}
			return $resultado->num_rows ;
		}

		function getAll()
		{
				$sql = "SELECT * FROM event" ;
				$resultado = $this->connection->query($sql) ;
				$arrayevents = array() ;
				if($resultado->num_rows>0)
				{
					while ($row = $resultado->fetch_assoc())
					{
						$arrayevents[] = $row ;
					}
				}
				return $arrayevents ;
		}

		function executeSQL($sql)
		{

			$resultado = $this->connection->query($sql) ;
			$arrayevents = array() ;
			if($resultado->num_rows>0)
			{
				while ($row = $resultado->fetch_assoc())
				{
					$arrayevents[] = $row ;
				}
			}
			return $arrayevents ;
		}

		function getAllByUserEvent($id_user)
		{			
				$sql = "										
				SELECT id_event, event, id_role, time
				FROM event, info_event
				WHERe event.id_info_event = info_event.id_info_event
				AND id_role = 
				(SELECT id_role
				from event, info_event
					where event.id_info_event = info_event.id_info_event
					and id_event = 
						(SELECT id_event
						from event
						where 
							id_event = 
							(SELECT id_event FROM user, user_event 
						where user.id_user = ".$id_user.")));							
					";									

				$resultado = $this->connection->query($sql) ;
				$arrayevents = array() ;
				if($resultado->num_rows>0)
				{
					while ($row = $resultado->fetch_assoc())
					{
						$arrayevents[] = $row ;
					}
				}
				return $arrayevents ;
		}

		function getAllJson()
		{
			return json_encode($this->getAll(), true);
		}
		
		function getId()
		{
			return $this->id_event ;
		}	     

		function getIdInfoEvent()
		{
			return $this->id_info_event ;
		}	     		
		
		function getIdRole()
		{
			return $this->id_role ;
		}	     		

		function getEvent()
		{
			return $this->event ;
		}

		function getAddress()
		{
			return $this->address ;
		}

		function getDescription()
		{
			return $this->description ;
		}

		function getSessionNumber()
		{
			return $this->session_number ;
		}

		function getDate()
		{
			return $this->date ;
		}        
		
		function getCode()
		{
			return $this->code ;
        }        
	}
?>