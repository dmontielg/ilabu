<?php

	include_once ("Database.php");

	class Response
	{
			private $id_response	;			
            private $id_user	    ;
            private $id_question  	;			
			private $response	    ;
            private $username_date  ;            
			private $connection  	;
			private $table  	    ;

		function __construct()
		{
				$ob = new Database();
				$this->connection = $ob->getConnection();
				$this->table = "response" ;
		}

		function insert($response)
		{
					$sql = "INSERT INTO $this->table VALUES
					(	0,											
                        ". $response['id_user'] .",
                        ". $response['id_question'] .",						
                        '". $response['response'] ."',
                        '". $response['username_date'] ."')";			
			$this->connection->query($sql) ;
            
			return $this->connection->insert_id ;
		}

		function executeSQL($sql)
		{								
			return $this->connection->query($sql) ;            
		}
		
		function executeMultiSQL($sql)
		{				
			if ($this->connection->multi_query($sql)) {

				if ($result = $this->connection->store_result()) {
				   //while ($row = $result->fetch_row()) {
					   //print_r($row);
				   }
				   //$result->free();
				   }
				if ($this->connection->more_results()) 
				{	   
						while ($this->connection->next_result())
						{ 
				   			$thisresult = $this->connection->store_result();	   
							#print_r($thisresult).'<br />';
				   		}
				   }	   
		unset($sql);
		$this->connection->close();
	   	}	   

		function insertConcat($response)
		{
					$sql = "INSERT INTO $this->table
					(id_user, id_question, response, username_date)
					VALUES
					(												
                        ". $response['id_user'] .",
                        ". $response['id_question'] .",						
                        '". $response['response'] ."',
                        '". $response['username_date'] ."'); ";						            
			return $sql ;
		}

		function update($response)
		{
				$sql = "UPDATE $this->table SET
						id_user 	        = '". $response['id_user'] ."',						
                        id_question 	    = '". $response['id_question'] ."',						
                        response            = '". $response['response'] ."',						
                        username_date 	    = '". $response['username_date'] ."'                        
						WHERE id_response   = "  .$response['id_response'] ;

					return 	$this->connection->query($sql) ;
		}
                
               
		function delete($id_response)
		{
				$sql = "DELETE FROM $this->table WHERE id_response = ".$id_response ;

				return 	$this->connection->query($sql) ;
		}

		function loadById($id_response)
		{
			$sql = " SELECT * FROM $this->table WHERE id_response = $id_response" ;
			$resultado = $this->connection->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc() ;
				$this->id_response      = $row['id_response'] ;
                $this->id_user          = $row['id_user'] ;
                $this->id_question      = $row['id_question'] ;				
				$this->response         = $row['response'] ;
                $this->username_date    = $row['username_date'] ;				                
			}
			return $resultado->num_rows ;
		}

		function getAll()
		{
				$sql = "SELECT * FROM $this->table" ;
				$resultado = $this->connection->query($sql) ;
				$arrayquestions = array() ;
				if($resultado->num_rows>0)
				{
					while ($row = $resultado->fetch_assoc())
					{
						$arrayquestions[] = $row ;
					}
				}
				return $arrayquestions ;
		}

		function getAllByIdUser($id_user)
		{
				$sql = "SELECT * FROM $this->table WHERE id_user = $id_user LIMIT 1" ;
				$resultado = $this->connection->query($sql) ;
				$arrayquestions = array() ;
				if($resultado->num_rows>0)
				{
					while ($row = $resultado->fetch_assoc())
					{
						$arrayquestions[] = $row ;
					}
				}
				return $arrayquestions ;
		}

		function getAllJson()
		{
			return json_encode($this->getAll(), true);
		}
		
		function getId()
		{
			return $this->id_response ;
		}	     
		
		function getIdQuestion()
		{
			return $this->id_question ;
		}

		function getIdUser()
		{
			return $this->id_user ;
		}

		function getResponse()
		{
			return $this->response ;
		}

		function getUsernameDate()
		{
			return $this->username_date ;
        }        
	}
?>