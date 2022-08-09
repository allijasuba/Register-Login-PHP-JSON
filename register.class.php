<?php 
class addUser{
	private $username;
	private $raw_password;
	private $encrypted_password;
	private $month;
	private $day;
	private $year;
	private $student_number;
	private $family_name;
	public $error;
	public $success;
	private $storage = "data.json";
	private $stored_users;
	private $new_user; 
	
	public function __construct($username, $password, $month, $day, $year, $student_number,$family_name){
		
		$this->username = filter_var(trim($username), FILTER_SANITIZE_STRING);
		$this->month = filter_var(trim($month), FILTER_SANITIZE_STRING);
		$this->day = filter_var(trim($day), FILTER_SANITIZE_STRING);
		$this->student_number = filter_var(trim($student_number), FILTER_SANITIZE_STRING);
		$this->year = filter_var(trim($year), FILTER_SANITIZE_STRING);
		$this->family_name = filter_var(trim($family_name), FILTER_SANITIZE_STRING);
		$this->raw_password = filter_var(trim($password), FILTER_SANITIZE_STRING);
		$this->encrypted_password = password_hash($this->raw_password, PASSWORD_DEFAULT);
		$this->stored_users = json_decode(file_get_contents($this->storage), true);
		$this->new_user = [
			"student number" => $this->student_number,
			"family name" => $this->family_name,
			"month" => $this->month,
			"day" => $this->day,
			"year" => $this->year,
			"username" => $this->username,
			"password" => $this->encrypted_password
		];

		if($this->checkPassword()&&$this->checkUsername()&&$this->checkStudentNum()){
			$this->insertUser();
		}
	}
	private function checkStudentNum(){
		if(strlen($this->student_number) == 15){
			$num = $_POST ['student_number'];
			if(!preg_match("/^[2][0][0-9]{2}[\-][0-9]{5}[\-][A-Z]{2}[\-][0-9]{1}+$/", $num)){
				$this->error = "Enter a valid Student Number.";
				return false;
			}else{
				return true;
			}
			return true;
		}
		else{
			$this->error = "Enter a valid Student Number.";
			return false;
		}
	}

	private function checkPassword(){
		if(strlen($this->raw_password) < 8 || strlen($this->raw_password) > 32){
			$this->error = "Password must be between 8-32 characters long.";
			return false;
		}else{
			return true;
		}
	}
	private function checkUsername(){
		$un = $_POST ['username'];
		if(!preg_match("/^[a-zA-Z\d\_]+$/", $un)){
			$this->error = "Username must only contain letter, numbers or underscores.";
			return false;
		}
		else{
			return true;
		}
	}


	private function studentnumExists(){
		foreach($this->stored_users as $user){
			if($this->student_number == $user['student number']){
				$this->error = "Student Number has already been registered.";
				return true;
			}
		}
		return false;
	}
	private function usernameExists(){
		foreach($this->stored_users as $user){
			if($this->username == $user['username']){
				$this->error = "Username has already been taken.";
				return true;
			}
		}
		return false;
	}


	private function insertUser(){
		if(($this->usernameExists() == FALSE)&&($this->studentnumExists() == FALSE)){
			array_push($this->stored_users, $this->new_user);
			if(file_put_contents($this->storage, json_encode($this->stored_users, JSON_PRETTY_PRINT))){
				session_start();
				$_SESSION['user'] = $this->username;
				header("location: account.php"); exit();
			}else{
				return $this->error = "Something went wrong, please try again";
			}
		}
	}
}
