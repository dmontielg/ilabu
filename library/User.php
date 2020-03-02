<?php

	include_once ("Database.php");

	class User
	{
			private $id_user	;
			
			private $username  	;			
			private $email		;
			private $password	;
			private $verified	;
			private $vkey		;
			private $createdate	;

			private $token		;
			private $token_expire	;

			private $connection ;
			private $table  	;

		function __construct()
		{
				$ob = new Database();
				$this->connection = $ob->getConnection();
				$this->table = "user" ;
		}
		
		function escape_string($variable){

			return $this->connection->real_escape_string($variable) ;
		}

		function errorMessage(){

			return $this->connection->error ;
		}
		
		function insert($user)
		{
					$sql = "INSERT INTO $this->table(email, password, vkey)				
					VALUES
					(											
						'". $user['email'] ."',
						'". $user['password'] ."',						
						'". $user['vkey'] ."')";
			
			$this->connection->query($sql) ;            
			return $this->connection->insert_id ;
		}

		function update($user)
		{
				$sql = "UPDATE $this->table SET												
						email 		= " . $user['email'] .",						
						password 	= '". $user['password'] ."'						
						
						WHERE id_user = " .$user['id_user'] ;

					return 	$this->connection->query($sql) ;
		}                
			   
		function updateTokenByEmail($user)				
		{			
				$sql = "UPDATE $this->table SET												
				token 		  = '". $user['selector'] ."',						
				token_expire  = '". $user['token'] ."'						
				WHERE email = " . $user['email'] ;				
				#echo $sql;
				return $this->connection->query($sql) ;
				
		}


		function updateVerifiedById($id_user)
		{
				$sql = "UPDATE $this->table SET																		
						verified 	= '2'												
						WHERE id_user = " .$id_user ;
				#echo $sql;
				return 	$this->connection->query($sql) ;
		}                

		function delete($id_user)
		{
				$sql = "DELETE FROM $this->table WHERE id_user = ".$id_user ;

				return 	$this->connection->query($sql) ;
		}

		function loadById($id_user)
		{
			$sql = " SELECT * FROM $this->table WHERE id_user = $id_user LIMIT 1" ;
			$resultado = $this->connection->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc() ;
				$this->id_user  = $row['id_user'] ;
				$this->username = $row['username'] ;
				$this->password = $row['password'] ;
				$this->email   	= $row['email'] ;
				$this->verified = $row['verified'] ;				
				$this->vkey     = $row['vkey'] ;				
				$this->createdate = $row['createdate'] ;				
				#$this->token     = $row['token'] ;				
				#$this->token_expire = $row['token_expire'] ;				
			}
			return $resultado->num_rows ;
		}
				
		function loadByIdEvents($id_user){

			$sql = "				
					SELECT username, email, verified, id_event, waiting_list, email_confirmation
					from user, user_event
					where user.id_user = user_event.id_user										
					and user.id_user = ".$id_user."
					LIMIT 1
					";						
					$resultado = $this->connection->query($sql) ;
					$arrayusers = array() ;
					if($resultado->num_rows>0)
					{
						while ($row = $resultado->fetch_assoc())
						{
							$arrayusers[] = $row ;
						}
					}
					return $arrayusers ;

		}

		function loadIdByEmail($email)
		{
			$sql = " SELECT * FROM $this->table WHERE email = '".$email."' LIMIT 1" ;
			$resultado = $this->connection->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc() ;
				$this->id_user  = $row['id_user'] ;
				$this->username = $row['username'] ;
				$this->password = $row['password'] ;
				$this->email   	= $row['email'] ;
				$this->verified = $row['verified'] ;				
				$this->vkey     = $row['vkey'] ;				
				$this->createdate = $row['createdate'] ;				
			}
			return $resultado->num_rows ;
		}

		function loadByVkeyNotVerify($vkey)
		{
			$sql = " SELECT * FROM $this->table WHERE vkey = '".$vkey."' AND verified = 0 LIMIT 1 ";
			
			$resultado = $this->connection->query($sql);			
			return $resultado->num_rows ;
		}

		function updateVerifyAccount($vkey)
		{
				$sql = "UPDATE $this->table SET																		
						verified = 1						
						WHERE vkey = '".$vkey."'";

					return 	$this->connection->query($sql) ;
		}                

		function updatePassword($password, $email)
		{
				$sql = "UPDATE $this->table SET																		
						password = '".$password."'						
						WHERE email = '".$email."'";

					return $this->connection->query($sql) ;
					

		}                

		function updateAdmin($query)
		{
				$sql = "UPDATE $this->table SET																		
						username = '".$query['username']."',
						email = '".$query['email']."',
						verified = '".$query['verified']."'
						WHERE id_user = '".$query['id_user']."'";				
					return $this->connection->query($sql) ;					
		}
		
		function updateEventAdmin($query)
		{
				
				if($query["id_event"] == "NA"){
					$sql = "UPDATE user_event SET																								
					waiting_list = '".$query['waiting_list']."'				
					WHERE id_user = '".$query['id_user']."'";					

				}else{
					$sql = "UPDATE user_event SET																								
						waiting_list = '".$query['waiting_list']."',
						id_event = '".$query['id_event']."'
						WHERE id_user = '".$query['id_user']."'";				
					}
				
					return $this->connection->query($sql) ;					
		}                

		function getAll()
		{
				$sql = "SELECT * FROM $this->table" ;
				$resultado = $this->connection->query($sql) ;
				$arrayusers = array() ;
				if($resultado->num_rows>0)
				{
					while ($row = $resultado->fetch_assoc())
					{
						$arrayusers[] = $row ;
					}
				}
				return $arrayusers ;
		}


		function getAffectedRows(){
			return $this->connection->affected_rows;
		}
		
		
		function getAllByEmail($email)
		{
				$sql = "SELECT * FROM $this->table WHERE email = '".$email."'" ;
				$resultado = $this->connection->query($sql) ;
				$arrayusers = array() ;
				if($resultado->num_rows>0)
				{
					while ($row = $resultado->fetch_assoc())
					{
						$arrayusers[] = $row ;
					}
				}
				return $arrayusers ;
		}

		function getAllByIdPass($user)
		{
				$sql = "SELECT * FROM $this->table 
				WHERE id_user = '".$user['id_user']."' 
				AND password = '".$user['password']."'
				LIMIT 1	";				

				$resultado = $this->connection->query($sql) ;
				$arrayusers = array() ;
				if($resultado->num_rows>0)
				{
					while ($row = $resultado->fetch_assoc())
					{
						$arrayusers[] = $row ;
					}
				}
				return $arrayusers ;
		}
		
		function getAllByEmailPass($user)
		{
				$sql = "SELECT * FROM $this->table 
				WHERE email = '".$user['email']."' 
				AND password = '".$user['password']."'
				LIMIT 1	";				
				#print($sql);
				$resultado = $this->connection->query($sql) ;
				$arrayusers = array() ;
				if($resultado->num_rows>0)
				{
					while ($row = $resultado->fetch_assoc())
					{
						$arrayusers[] = $row ;
					}
				}
				return $arrayusers ;
		}


		function getAllUsersAdmin()
		{
				$sql = "SELECT id_user, email, verified, createdate FROM $this->table" ;
				$resultado = $this->connection->query($sql) ;
				$arrayusers = array() ;
				if($resultado->num_rows>0)
				{
					while ($row = $resultado->fetch_assoc())
					{
						$arrayusers[] = $row ;
					}
				}
				return $arrayusers ;
		}

		function getAllUsersJoinedAndNotJoined()
		{
				$sql = "
				
					SELECT user.id_user as id_user, user.email as email, user.verified as verified, 
					IF(user_event.id_user is null or user_event.id_user = '', '0', '1') as joined,
					user.createdate as createdate					
					FROM user
					LEFT OUTER JOIN user_event
					ON user.id_user = user_event.id_user
					WHERE user_event.id_user IS NULL
					OR user_event.id_user IS NOT NULL
					Order by user.id_user DESC				
				" 
				;
				$resultado = $this->connection->query($sql) ;
				$arrayusers = array() ;
				if($resultado->num_rows>0)
				{
					while ($row = $resultado->fetch_assoc())
					{
						$arrayusers[] = $row ;
					}
				}
				return $arrayusers ;
		}

		function getAllUsersEventAdmin()
		{
			$sql = "						
			select user.id_user,user_event.waiting_list, email, verified, createdate, role, event, time
			from user, user_event, role, event, info_event			
			where user.id_user = user_event.id_user
			and user_event.id_event = event.id_event
			and info_event.id_info_event = event.id_info_event
			and event.id_role = role.id_role
			"			
			;			
				$resultado = $this->connection->query($sql) ;
				$arrayusers = array() ;
				if($resultado->num_rows>0)
				{
					while ($row = $resultado->fetch_assoc())
					{
						$arrayusers[] = $row ;
					}
				}
				return $arrayusers ;
		}

		function getAllUsersResponseAdmin()
		{
			$sql = "						
		
			select user.id_user,user_event.waiting_list, email, verified, createdate, role, event, name_form, response, username_date, timestamp 
            from user, user_event, role, event, info_event, response, question
			where user.id_user = user_event.id_user
			and user_event.id_event = event.id_event
			and info_event.id_info_event = event.id_info_event
			and event.id_role = role.id_role
			and response.id_user = user.id_user
            and response.id_question = question.id_question
			"			
			;			
				$resultado = $this->connection->query($sql) ;
				$arrayusers = array() ;
				if($resultado->num_rows>0)
				{
					while ($row = $resultado->fetch_assoc())
					{
						$arrayusers[] = $row ;
					}
				}
				return $arrayusers ;
		}

		function getAllQuestionsAdmin()
		{
			$sql = 
			"						
			SELECT id_question, question, question_number, response_options, name_form, survey, role 
			FROM ilabu.question, survey, role
			where survey.id_survey = question.id_survey
			and role.id_role = survey.id_role		
			"			
			;			
				$resultado = $this->connection->query($sql) ;
				$arrayusers = array() ;
				if($resultado->num_rows>0)
				{
					while ($row = $resultado->fetch_assoc())
					{
						$arrayusers[] = $row ;
					}
				}
				return $arrayusers ;
		}

		



		function getAllJson()
		{
			return json_encode($this->getAll(), true);
		}
		
		function getId()
		{
			return $this->id_user ;
		}	     
		
		function getUsername()
		{
			return $this->username ;
		}

		function getPassword()
		{
			return $this->password ;
		}

		function getEmail()
		{
			return $this->email ;
		}

		function getVerified()
		{
			return $this->verified ;
		}

		function getVkey()
		{
			return $this->vkey ;
		}

		function getCreateDate()
		{
			return $this->createdate ;
		}		

		function getToken()
		{
			return $this->token ;
		}

		function getTokenExpire()
		{
			return $this->token_expire ;
		}		
	}
?>