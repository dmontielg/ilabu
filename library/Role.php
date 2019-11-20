<?php

	include_once ("Database.php");

	class Role
	{
			private $id_role	;			
			private $role  	    ;

			private $connection  	;
			private $table  	    ;

		function __construct()
		{
				$ob = new Database();
				$this->connection = $ob->getConnection();
				$this->table = "role" ;
		}

		function insert($role)
		{
					$sql = "INSERT INTO $this->table VALUES
					(						
						 ". $role['id_role'] .",
						 '". $role['role'] ."',						 
                                                '')";
			$this->connection->query($sql) ;
                        
			return $this->connection->insert_id ;
		}

		function update($role)
		{
				$sql = "UPDATE $this->table SET
						id_role 	    = '". $role['id_role'] ."',
						role 	        = '". $role['role'] ."'                                                						
						WHERE id_role   = " .$role['id_role'] ;

					return 	$this->connection->query($sql) ;
		}                
               
		function delete($id_role)
		{
				$sql = "DELETE FROM $this->table WHERE id_role = ".$id_role ;

				return 	$this->connection->query($sql) ;
		}

		function loadById($id_role)
		{
			$sql = " SELECT * FROM $this->table WHERE id_role = $id_role" ;
			$resultado = $this->connection->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc() ;
				$this->id_role    = $row['id_role'] ;
				$this->role       = $row['role'] ;				
			}
			return $resultado->num_rows ;
        }                

		function getAll()
		{
				$sql = "SELECT * FROM $this->table" ;
				$resultado = $this->connection->query($sql) ;
				$array_role = array() ;
				if($resultado->num_rows>0)
				{
					while ($row = $resultado->fetch_assoc())
					{
						$array_role[] = $row ;
					}
				}
				return $array_role ;
		}

		function getAllJson()
		{
			return json_encode($this->getAll(), true);
		}
		
		function getId()
		{
			return $this->id_role ;
		}	     
		
		function getRole()
		{
			return $this->role ;
		}
	}
?>