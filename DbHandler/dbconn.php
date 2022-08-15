<?php

	//Class Opens
	class MyDB extends MYSQLi 
	{
		//Constructor To Establish Connection
		function __construct()
		{
			$host="db";
			$user="Fortuneod";
			$pass="seyejames@123";
			$db="php_docker";
			
            $this->connect($host, $user, $pass, $db);
		}
		
		//Function To Execute Queries
		function Execute($x)
		{
			return $this->query($x);
		}
		
		//Function To Execute Queries
		function prepQuery($x)
		{
			return $this->prepare($x);
		}		
		
		//Function To Execute Queries
		function Perform($x)
		{
			return $x->execute();
		}
		
		
		//Function To Check Matching Records
		function getMatches($x)
		{
			return $x->num_rows();
		}
		
		
		//Function To Check Matching Records
		function doStore($x)
		{
			return $x->store_result();
		}
        
		
		//Function To Fetch Data
		function Display($r) 
		{
			return $r->fetch_object();
		}
        
        //Function To Fetch Data
		function DisplayAssoc($r) 
		{
			return $r->fetch_assoc();
		}
		
		//Function To Fetch Data
		function DisplayAll($r) 
		{
			return $r->fetch_row();
		}
		
		//Function To Fetch Data
		function DisplayAllR($r) 
		{
			return $r->fetch_array();
		}
		
		//Counting Matching Rows
		function NumRows($n) 
		{
            return $n->num_rows;
		}
		
		//Cleanup Input
		function cleanUp($x) 
		{
            //$x = preg_replace("/‘/", "'", $x);
            return filter_input(INPUT_POST, $x, FILTER_SANITIZE_SPECIAL_CHARS);
		}
		
		function cleanVar($x) 
		{
            $x = preg_replace("/‘/", "'", $x);
            
            return filter_var($x, FILTER_SANITIZE_SPECIAL_CHARS);
		}
		
		//Check Email
		function inpVerify($x) 
		{
            //$x = preg_replace("/‘/", "'", $x);
            return filter_input(INPUT_POST, $x, FILTER_VALIDATE_EMAIL);
		}

		//Cleanup Input
		function gcleanUp($x) 
		{
            //$x = preg_replace("/‘/", "'", $x);
            return filter_input(INPUT_GET, $x, FILTER_SANITIZE_SPECIAL_CHARS);
		}

		function loginBinder($x, $y, $z)
		{
			return $x->bind_param('ss', $y, $z);
		}
		
		//Check Email
		function ginpVerify($x) 
		{
            //$x = preg_replace("/‘/", "'", $x);
            return filter_input(INPUT_GET, $x, FILTER_VALIDATE_EMAIL);
		}

		function nextNum($x)
		{
			$s="SELECT * FROM `$x`";
			$r=$this->Execute($s);
			$n=$this->NumRows($r);

			return $n + 1;
		}

		function Hash($x)
		{
			$opts = [
		        'rounds' => 10
		    ];

		    return password_hash($x, PASSWORD_BCRYPT, $opts);
		}

		function Pwd($x, $y)
		{
		    return password_verify($x, $y);
		}
        
        //Check File Upload
        function isFile($x)
        {
            return is_uploaded_file($_FILES[$x]['tmp_name']);
        }
        
        //Get File
        function getFile($x)
        {
            return $_FILES[$x]['tmp_name'];
        }
        
        //Get File Name
        function nameFile($x)
        {
            return $_FILES[$x]['name'];
        }
        
        
        //Create Folder
        function makeFolder($x)
        {
            return mkdir($x, 0777, true);
        }
		
	}
	
	
	//Bring Class Into Existence
	$conn = new MyDB();