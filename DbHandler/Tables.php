<?php

	require 'dbconn.php';

	$conn->Execute("CREATE TABLE IF NOT EXISTS `login` (
	   `id` INT(25) UNSIGNED NOT NULL AUTO_INCREMENT,
        `username` VARCHAR(100) NOT NULL,
        `password` VARCHAR(100) NOT NULL,
        
        PRIMARY KEY (id)
	)ENGINE=InnoDB CHARSET=DEFAULT AUTO_INCREMENT=1");

	$conn->Execute("CREATE TABLE IF NOT EXISTS `employees` (
	   `id` INT(25) UNSIGNED NOT NULL AUTO_INCREMENT,
        `emp_name` VARCHAR(200) NOT NULL,
        `emp_job` VARCHAR(200) NOT NULL,
        `emp_loc` VARCHAR(200) NOT NULL,
        `emp_dept` VARCHAR(200) NOT NULL,
        `emp_photo` VARCHAR(100) NOT NULL,

        PRIMARY KEY (id)
	)ENGINE=InnoDB CHARSET=DEFAULT AUTO_INCREMENT=1");
    

	$conn->Execute("CREATE TABLE IF NOT EXISTS `depts` (
	   `id` INT(25) UNSIGNED NOT NULL AUTO_INCREMENT,
        `dept_name` VARCHAR(200) UNIQUE NOT NULL,
        
        PRIMARY KEY (id)
	)ENGINE=InnoDB CHARSET=DEFAULT AUTO_INCREMENT=1");
    

	$conn->Execute("CREATE TABLE IF NOT EXISTS `locs` (
	   `id` INT(25) UNSIGNED NOT NULL AUTO_INCREMENT,
        `loc_name` VARCHAR(200) UNIQUE NOT NULL,
        
        PRIMARY KEY (id)
	)ENGINE=InnoDB CHARSET=DEFAULT AUTO_INCREMENT=1");
    

	$conn->Execute("CREATE TABLE IF NOT EXISTS `jobs` (
	   `id` INT(25) UNSIGNED NOT NULL AUTO_INCREMENT,
        `job_name` VARCHAR(200) UNIQUE NOT NULL,
        `job_desc` VARCHAR(2000) NOT NULL,
        
        PRIMARY KEY (id)
	)ENGINE=InnoDB CHARSET=DEFAULT AUTO_INCREMENT=1");
    

	$conn->Execute("CREATE TABLE IF NOT EXISTS `expenses` (
	   `id` INT(25) UNSIGNED NOT NULL AUTO_INCREMENT,
        `merchant` VARCHAR(10) NOT NULL,
        `expense_date` VARCHAR(100) NOT NULL,
        `amount` VARCHAR(50) NOT NULL,
        `comments` VARCHAR(200) NOT NULL,
        `receipt` VARCHAR(100) NOT NULL,

        PRIMARY KEY (id)
	)ENGINE=InnoDB CHARSET=DEFAULT AUTO_INCREMENT=1");

    


?>