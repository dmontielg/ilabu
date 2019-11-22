<?php

	include_once ("Database.php");

	class Question
	{
			private $id_question	    ;			            
            private $question  	        ;			
			private $question_number	;
			private $response_options   ;            
			private $type   			;            
			private $name_form   		;            
			private $id_survey	        ;
			private $connection  	    ;
			private $table  	        ;

		function __construct()
		{
				$ob = new Database();
				$this->connection = $ob->getConnection();
				$this->table = "question" ;
		}

		function insert($question)
		{
					$sql = "INSERT INTO $this->table VALUES
					(						
						".  $question['id_question'] .",
						'". $question['question'] ."',
						'". $question['question_number'] ."',
                        '". $question['response_options'] ."',                        
                        '". $question['type'] ."',                        
                        '". $question['name_form'] ."',                        
						'". $question['id_survey'] ."',                        
                                                '')";
			$this->connection->query($sql) ;
                        
			return $this->connection->insert_id ;
		}

		function update($question)
		{
				$sql = "UPDATE $this->table SET
						id_survey 	        = '". $question['id_survey'] ."',						
                        question 	        = '". $question['question'] ."',						
						question_number     = '". $question['question_number'] ."',						
						response_options 	= '". $question['response_options'] ."'                        
						type 	            = '". $question['type'] ."',						
						name_form 	        = '". $question['name_form'] ."'						                                                
						WHERE id_question   = "  .$question['id_question'] ;

					return 	$this->connection->query($sql) ;
		}
                
               
		function delete($id_question)
		{
				$sql = "DELETE FROM $this->table WHERE id_question = ".$id_question ;
				return 	$this->connection->query($sql) ;
		}

		function loadById($id_question)
		{
			$sql = " SELECT * FROM $this->table WHERE id_question = $id_question" ;
			$resultado = $this->connection->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc() ;
				$this->id_question      = $row['id_question'] ;
				$this->id_survey        = $row['id_survey'] ;				
                $this->question         = $row['question'] ;				
				$this->question_number  = $row['question_number'] ;
				$this->response_options = $row['response_options'] ;				                
				$this->type 			= $row['type'] ;				                
				$this->name_form 		= $row['name_form'] ;				                
			}
			return $resultado->num_rows ;
		}

		function loadIdByNameForm($name_form)
		{			
			$sql = " SELECT * FROM $this->table WHERE name_form = '".$name_form."' LIMIT 1";
			
			$resultado = $this->connection->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc() ;
				$this->id_question      = $row['id_question'] ;
				$this->id_survey        = $row['id_survey'] ;				
                $this->question         = $row['question'] ;				
				$this->question_number  = $row['question_number'] ;
				$this->response_options = $row['response_options'] ;				                
				$this->type 			= $row['type'] ;				                
				$this->name_form 		= $row['name_form'] ;				                
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

		function getAllSorted()
		{
				$sql = "SELECT * FROM $this->table
				order by name_form ASC, id_survey ASC

				" ;
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

		function getQuestionaire($survey, $id_role)
		{
			## Receives two variables string names: 
			## survey e.g. "Registation", "Speed date etc.
			## Role e.g. "public" or "scientist"	

			$sql = "SELECT * FROM ilabu.survey AS survey, ilabu.role AS role, ilabu.question AS question
			WHERE question.id_survey = survey.id_survey 
			AND survey.id_role = $id_role
			AND survey.survey = '$survey'			
			AND survey.id_role = role.id_role
			ORDER BY question.question_number ASC";
			
			$resultado = $this->connection->query($sql) ;
			$arrayquestionaire = array() ;
			
			if($resultado->num_rows>0)
			{
				while ($row = $resultado->fetch_assoc())
				{
					$arrayquestionaire[] = $row ;
				}
			}
			return $arrayquestionaire ;
		}

		function getAllDateNames($id_info_event, $id_role)
		{			
			$sql = "			
			SELECT user.* FROM event, user_event, user
			where user_event.id_event = event.id_event
			and user_event.waiting_list = 1
			and event.id_role != ".$id_role."
			and event.id_info_event = ".$id_info_event."
			and user_event.id_user = user.id_user" ;
			
			$resultado = $this->connection->query($sql) ;
			$arrayquestionaire = array() ;
			
			if($resultado->num_rows>0)
			{
				while ($row = $resultado->fetch_assoc())
				{
					$arrayquestionaire[] = $row ;
				}
			}
			return $arrayquestionaire ;
		}

		function getAllIdDates($id_user)
		{			
			$sql = "
			SELECT distinct username_date FROM ilabu.response where id_user = ".$id_user."
			and username_date != 'NA'
			";					
			$resultado = $this->connection->query($sql) ;
			$arrayquestionaire = array() ;
			
			if($resultado->num_rows>0)
			{
				while ($row = $resultado->fetch_assoc())
				{
					$arrayquestionaire[] = $row ;
				}
			}
			return $arrayquestionaire ;
		}
		
		function getFilteredDateNames($id_info_event,$id_role, $array_id_user)
		{
			$sql = "SELECT user.* FROM event, user_event, user
			where user_event.id_event = event.id_event
			and user_event.waiting_list = 1
			and event.id_role != ".$id_role."
			and event.id_info_event = ".$id_info_event."
			and user_event.id_user = user.id_user
			and user_event.id_user not in (".$array_id_user.")";			
			#echo $sql;
			$resultado = $this->connection->query($sql) ;
			$arrayquestionaire = array() ;
			
			if($resultado->num_rows>0)
			{
				while ($row = $resultado->fetch_assoc())
				{
					$arrayquestionaire[] = $row ;
				}
			}
			return $arrayquestionaire ;
		}


		function getAllJson()
		{
			return json_encode($this->getAll(), true);
		}
		
		function getId()
		{
			return $this->id_question ;
		}	     
		
		function getIdSurvey()
		{
			return $this->id_survey ;
		}

		function getQuestion()
		{
			return $this->question ;
		}		

		function getQuestionNumber()
		{
			return $this->question_number ;
		}

		function getResponseOptions()
		{
			return $this->response_options ;
		}        
		
		function getType()
		{
			return $this->type ;
		}        
		
		function getNameForm()
		{
			return $this->name_form ;
		}        		

		function getFormComponents($query_question)
		{						
				$form = "";    
				$i = 0;    
				foreach ($query_question as $query):							  
					#echo $query["name_form"]."<br/>";            		
					#$form .= $query["question_number"]. ".-";
					#$form .= "<label>" . utf8_encode($query["question"]) . "</label>";
					$form .= "<label>" .$query["question_number"]. ". ". utf8_encode($query["question"]) . "</label>";
					$form .= "<br/>";                                      
						  ### In case for radio button
						  if(strpos($query["type"], 'radio') !== false)
						  {                     
							$pieces = explode(";", $query["response_options"]);                                        
							foreach ($pieces as $piece):
								$option = explode(":", $piece);                                            
								
								#$option = utf8_encode($option);

								$name_other_radio = $query["name_form"]."_other";
								//$name_other_input = $query["name_form"]."_other_input";
								$name_other_input = $query["name_form"]."_other";
								$name_other_div = $query["name_form"]."_ifopt";
								$name_function = "selectedRadio".$query["question_number"];
		
								if(strpos( $option[1], 'TEXT') !== false )
								{                                                            
									  $form .= "<input required type='radio' onclick='javascript:$name_function();' value='" .$name_other_radio."' name='". 
									  			$query["name_form"] ."' id='".$name_other_radio."'/>";                                                                                                     
									  $form .= utf8_encode($option[0]);                              
									  $form .= "<div id='".$name_other_div."' style='visibility:hidden'><label for='opt'>Please explain:</label>
											  <input type='text'  id=".$name_other_input."  name=" .$name_other_input."></div>";                          
									  echo "
									  <html>
									  <head>
									  <script>
										  function ".$name_function."() 
										  {
											  if (document.getElementById('".$name_other_radio."').checked)
											  {
												  document.getElementById('".$name_other_div."').style.visibility = 'visible';
											  }
											  else
											  {
												document.getElementById('".$name_other_div."').style.visibility = 'hidden';
												document.getElementById('".$name_other_input."').value = '';
											  }                                                                            
										  }                              
									  </script>
									  </head>
									  </html>
									  ";
								}
								else
								{
									  #$form .= "<input type='radio' name= '". $query["name_form"] ."' value= ". $option[1] ." /> ";                                                                                    
									  $form .= "<input required type='radio' onclick='javascript:$name_function();' value=".$option[1]. " name='". $query["name_form"]."' id='noCheck'/>";
									  #$form .= "<label>" .utf8_encode($option[0]). "</label>"; #this highlight in bold the answer for radio button
									  $form .= utf8_encode($option[0]);
									  $form .= "<br/>";                                          
								}
							endforeach;                                          							
							$form .= "<br/>";                                          
						  }                  
						  if(strpos($query["type"], 'select') !== false)
						  {                                           
							$form .= "<select required name='" . $query["name_form"] . "'>";
							$pieces = explode(";", $query["response_options"]);        
							foreach ($pieces as $piece):
							  $option = explode(":", $piece);                                            
							  $form .= "<option value='$option[0]' > ".$option[0]." </option>";                        
							endforeach;                                                                                                                                                    
							$form .= "</select>";
							$form .= "<br/>";                                      
						  }
						  if(strpos($query["type"], 'input') !== false)
						  {                    
							$form .= "<input type='text' placeholder='Please, fill here' name='" . $query["name_form"] . "' >";
							$form .= "<br/>";                                      
						  }
						  ### In case for multiple choice closed
						  if(strpos($query["type"], "checkbox") !== false)
						  {                                        
							$pieces = explode(";", $query["response_options"]);                                        
							foreach ($pieces as $piece):
							  $option = explode(":", $piece);                                      
							  if(strpos($option[1], "TEXT") !== false){$form .= "<input type='text' placeholder='".$option[0]."' name= '". $query["name_form"] ."[]' /> ";
								#$form .= $option[0]; 
								}
							  else{ $form .= "<input type='checkbox' name= '". $query["name_form"] ."[]' value= '". $option[1] ."' /> ";
								$form .= $option[0]; 
								}                         
							  $form .= "<br/>";   
							endforeach;                                            
							$form .= "<br/>";                                          
						  }                                   
				  	endforeach;					
				  	return $form;					 
		}

		function getForm($query_question)
		{						
				$form = "<form id='personalinfo' name='personalinfo' action='' method='post'>";    
				$i = 0;    
				foreach ($query_question as $query):							  
					#echo $query["name_form"]."<br/>";            		
					#$form .= $query["question_number"]. ".-";					
					#$form .= $query["name_form"]. ".-";					
					$form .= "<label>" .$query["name_form"]. ".-". utf8_encode($query["question"]) . "</label>";
					$form .= "<br/>";                                      
						  ### In case for radio button
						  if(strpos($query["type"], 'radio') !== false)
						  {                     
							$pieces = explode(";", $query["response_options"]);                                        
							foreach ($pieces as $piece):
								$option = explode(":", $piece);                                            
								
								$name_other_radio = $query["name_form"]."_other";
								//$name_other_input = $query["name_form"]."_other_input";
								$name_other_input = $query["name_form"]."_other";
								$name_other_div = $query["name_form"]."_ifopt";
								$name_function = "selectedRadio".$query["question_number"];
		
								if(strpos( $option[1], 'TEXT') !== false )
								{                                                            
									  $form .= "<input required type='radio' onclick='javascript:$name_function();' value='" .$name_other_radio."' name='". 
									  			$query["name_form"] ."' id='".$name_other_radio."'/>";                                                                                                     
									  $form .= utf8_encode($option[0]);                              
									  $form .= "<div id='".$name_other_div."' style='visibility:hidden'><label for='opt'>Please specify:</label>
											  <input type='text' id=".$name_other_input."  name=" .$name_other_input."></div>";                          
									  echo "
									  <html>
									  <head>
									  <script>
										  function ".$name_function."() 
										  {
											  if (document.getElementById('".$name_other_radio."').checked)
											  {
												  document.getElementById('".$name_other_div."').style.visibility = 'visible';
											  }
											  else
											  {
												document.getElementById('".$name_other_div."').style.visibility = 'hidden';
												document.getElementById('".$name_other_input."').value = '';
											  }                                                                            
										  }                              
									  </script>
									  </head>
									  </html>
									  ";
								}
								else
								{
									  #$form .= "<input type='radio' name= '". $query["name_form"] ."' value= ". $option[1] ." /> ";                                                                                    
									  $form .= "<input required type='radio' onclick='javascript:$name_function();' value=".$option[1]. " name='". $query["name_form"]."' id='noCheck'/>";
									  $form .= "<label>" .$option[0]. "</label>";
									  $form .= "<br/>";                                          
								}
							endforeach;                                          							
							$form .= "<br/>";                                          
						  }                  
						  if(strpos($query["type"], 'select') !== false)
						  {                                           
							$form .= "<select required name='" . $query["name_form"] . "'>";
							$pieces = explode(";", $query["response_options"]);        
							foreach ($pieces as $piece):
							  $option = explode(":", $piece);                                            
							  $form .= "<option value='$option[0]' > ".$option[0]." </option>";                        
							endforeach;                                                                                                                                                    
							$form .= "</select>";
							$form .= "<br/>";                                      
						  }
						  if(strpos($query["type"], 'input') !== false)
						  {                    
							$form .= "<input type='text' name='" . $query["name_form"] . "' >";
							$form .= "<br/>";                                      
						  }
						  ### In case for multiple choice closed
						  if(strpos($query["type"], "checkbox") !== false)
						  {                                        
							$pieces = explode(";", $query["response_options"]);                                        
							foreach ($pieces as $piece):
							  $option = explode(":", $piece);                                      
							  if(strpos($option[1], "TEXT") !== false){$form .= "<input type='text' name= '". $query["name_form"] ."[]' /> " . $option[0]; }
							  else{ $form .= "<input type='checkbox' name= '". $query["name_form"] ."[]' value= '". $option[1] ."' /> " . $option[0]; }                         
							  $form .= "<br/>";   
							endforeach;                                            
							$form .= "<br/>";                                          
						  }                                   
				  	endforeach;
					$form .= "<input class='btn btn-primary' type='submit' value='Submit' name='submit'></form>";    		
				  	return $form;					 
		}
	}
?>