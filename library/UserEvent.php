<?php

	include_once ("Database.php");

	class UserEvent
	{
			private $id_user_event	;			
			private $id_event  	    ;
			private $id_user	    ;			
			private $waiting_list   ;			
			private $email_confirmation;

			private $connection  	;
			private $table  	    ;

		function __construct()
		{
				$ob = new Database();
				$this->connection = $ob->getConnection();
				$this->table = "user_event" ;
		}

		function insert($user_event)
		{
					$sql = "INSERT INTO $this->table
					(id_event, id_user, waiting_list)
					VALUES
					(						
						0,
						 ". $user_event['id_event'] .",
						 ". $user_event['id_user'] .",                        
						'". $user_event['waiting_list'] ."',                        
                                                '')";
			$this->connection->query($sql) ;
                        
			return $this->connection->insert_id ;
		}

		function insertConcat($user_event)
		{
					$sql = "INSERT INTO $this->table 
					(id_event, id_user, waiting_list)
					VALUES
					(												
						 ". $user_event['id_event'] .",
						 ". $user_event['id_user'] .",                        
						'". $user_event['waiting_list'] ."'); ";			                        
					return $sql;
		}

		function update($user_event)
		{
				$sql = "UPDATE $this->table SET
						id_event 	= '". $user_event['id_event'] ."',
						id_user 	= '". $user_event['id_user'] ."'                                                
						waiting_list = '". $user_event['waiting_list'] ."'                                                
						WHERE id_user_event = " .$user_event['id_user_event'] ;

					return 	$this->connection->query($sql) ;
		}               
		
		function updateEmailConfirmationbyIdUser($id_user)
		{
				$sql = "UPDATE $this->table SET
						email_confirmation = '1'
						WHERE id_user = " .$id_user ;
					return 	$this->connection->query($sql) ;
		}                
               
		function delete($id_user_event)
		{
				$sql = "DELETE FROM $this->table WHERE id_user_event = ".$id_user_event ;

				return 	$this->connection->query($sql) ;
		}

		function loadById($id_user_event)
		{
			$sql = " SELECT * FROM $this->table WHERE id_user_event = $id_user_event" ;
			$resultado = $this->connection->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc() ;
				$this->id_user_event    = $row['id_user_event'] ;
				$this->id_event         = $row['id_event'] ;
				$this->id_user          = $row['id_user'] ;				
				$this->waiting_list     = $row['waiting_list'] ;				
			}
			return $resultado->num_rows ;
        }
        
        function loadByIdUser($id_user)
		{
			$sql = " SELECT * FROM $this->table WHERE id_user = $id_user LIMIT 1" ;
			$resultado = $this->connection->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc() ;
				$this->id_user_event    = $row['id_user_event'] ;
				$this->id_event         = $row['id_event'] ;
				$this->id_user          = $row['id_user'] ;				
				$this->waiting_list     = $row['waiting_list'] ;				
				$this->email_confirmation= $row['email_confirmation'] ;				

			}
			
			return $resultado->num_rows ;
		}

		function getAll()
		{
				$sql = "SELECT * FROM $this->table" ;
				$resultado = $this->connection->query($sql) ;
				$arrayuser_events = array() ;
				if($resultado->num_rows>0)
				{
					while ($row = $resultado->fetch_assoc())
					{
						$arrayuser_events[] = $row ;
					}
				}
				return $arrayuser_events ;
		}

		function getRolByIdUser($id_user)
		{
				$sql = "								
				SELECT  role  FROM event, user_event, role
				where user_event.id_user = ".$id_user."
				and user_event.id_event = event.id_event
				and event.id_role = role.id_role LIMIT 1;				
				";				
				$resultado = $this->connection->query($sql) ;
				$arrayuser_events = array() ;
				if($resultado->num_rows>0)
				{
					while ($row = $resultado->fetch_assoc())
					{
						$arrayuser_events[] = $row ;
					}
				}
				return $arrayuser_events ;
		}

		function getEventByIdUser($id_user)
		{			
			$sql = "								
			SELECT  info_event.event, info_event.description, info_event.code, 
			event.address, event.time, event.date, event.session_number,
			event.id_info_event, event.id_role, user_event.email_confirmation, user_event.waiting_list
			FROM event, user_event, info_event
			where user_event.id_user = ".$id_user."
			and user_event.id_event = event.id_event
			and event.id_info_event = info_event.id_info_event 
			LIMIT 1;			
			";				
			$resultado = $this->connection->query($sql) ;
			$arrayuser_events = array() ;
			if($resultado->num_rows>0)
			{
				while ($row = $resultado->fetch_assoc())
				{
					$arrayuser_events[] = $row ;
				}
			}
			return $arrayuser_events ;
		}

		function getAllJson()
		{
			return json_encode($this->getAll(), true);
		}
		
		function getId()
		{
			return $this->id_user_event ;
		}	     
		
		function getIdEvent()
		{
			return $this->id_event ;
		}

		function getIdUser()
		{
			return $this->id_user ;
		}

		function getWaitingLlist()
		{
			return $this->waiting_list ;
		}

		function getEmailConfirmation()
		{
			return $this->email_confirmation ;
		}
	}
?>