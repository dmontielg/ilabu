<?php

	include_once ("Database.php");

	class ResetPassword
	{
			private $id_reset_password	;						
			private $email		        ;
			private $selector	        ;
			private $token	            ;
			private $expires		    ;  						

			private $connection ;
			private $table  	;

		function __construct()
		{
				$ob = new Database();
				$this->connection = $ob->getConnection();
				$this->table = "reset_password" ;
		}						
		
		function insert($reset_password)
		{
					$sql = "INSERT INTO $this->table
                    (id_reset_password, email, selector, token, expires)				
					VALUES
					(	0,						
						'". $reset_password['email'] ."',
						'". $reset_password['selector'] ."',						
                        '". $reset_password['token'] ."',						
						'". $reset_password['expires'] ."')";			
			$this->connection->query($sql) ;            
			return $this->connection->insert_id ;
		}

		function update($reset_password)
		{
				$sql = "UPDATE $this->table SET												
						email 		= " . $reset_password['email'] .",						
						selector 	= '". $reset_password['selector'] ."'						
						
						WHERE id_reset_password = " .$reset_password['id_reset_password'] ;

					return 	$this->connection->query($sql) ;
		}                
			   		

		function delete($id_reset_password)
		{
                $sql = "DELETE FROM $this->table WHERE id_reset_password = ".$id_reset_password ;
                print($sql);

				return 	$this->connection->query($sql) ;
        }
        
        function deleteByEmail($email)
		{
                $sql = "DELETE FROM $this->table WHERE email = '".$email."'" ;                            
            
				return 	$this->connection->query($sql) ;
		}

		function loadById($id_reset_password)
		{
			$sql = " SELECT * FROM $this->table WHERE id_reset_password = $id_reset_password LIMIT 1" ;
			$resultado = $this->connection->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc() ;
				$this->id_reset_password  = $row['id_reset_password'] ;				
				$this->selector = $row['selector'] ;
				$this->email   	= $row['email'] ;
				$this->token    = $row['token'] ;				
				$this->expires  = $row['expires'] ;												
			}
			return $resultado->num_rows ;
        }

    
        function loadByEmail($email)
		{
            $sql = " SELECT * FROM $this->table WHERE email = '" . $email . "' LIMIT 1" ;
            
			$resultado = $this->connection->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc() ;
				$this->id_reset_password  = $row['id_reset_password'] ;				
				$this->selector = $row['selector'] ;
				$this->email   	= $row['email'] ;
				$this->token    = $row['token'] ;				
				$this->expires  = $row['expires'] ;												
            }            
            
			return $resultado->num_rows ;
		}
	

		function getAll()
		{
				$sql = "SELECT * FROM $this->table" ;
				$resultado = $this->connection->query($sql) ;
				$arrayreset_passwords = array() ;
				if($resultado->num_rows>0)
				{
					while ($row = $resultado->fetch_assoc())
					{
						$arrayreset_passwords[] = $row ;
					}
				}
				return $arrayreset_passwords ;
		}


		function getAllBySelectorExpires($selector, $expires)
		{
				$sql = "
				SELECT * FROM $this->table
				WHERE selector = '". $selector ."'
				AND expires >= '". $expires ."'
				" ;				
				$resultado = $this->connection->query($sql) ;
				$arrayreset_passwords = array() ;
				if($resultado->num_rows>0)
				{
					while ($row = $resultado->fetch_assoc())
					{
						$arrayreset_passwords[] = $row ;
					}
				}
				return $arrayreset_passwords ;
		}

		function getAllJson()
		{
			return json_encode($this->getAll(), true);
		}
		
		function getId()
		{
			return $this->id_reset_password ;
		}	     
		

		function getSelector()
		{
			return $this->selector ;
		}

		function getEmail()
		{
			return $this->email ;
		}

		function getToken()
		{
			return $this->token ;
		}

		function getExpires()
		{
			return $this->expires ;
		}
		
	}
?>