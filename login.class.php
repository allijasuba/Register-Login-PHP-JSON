<?php 
class LoginUser{
	private $username;
	private $password;
	private $month;
	private $day;
	private $year;
	private $student_number;
	private $family_name;
	public $error;
	public $success;
	private $storage = "data.json";
	private $stored_users;

	public function __construct($username, $password, $month, $day, $year, $student_number, $family_name){
		$this->username = $username;
		$this->password = $password;
		$this->month = $month;
		$this->day = $day;
		$this->year = $year;
		$this->family_name = $family_name;
		$this->student_number = $student_number;
		$this->stored_users = json_decode(file_get_contents($this->storage), true);
		$this->login();
	}

	private function login(){
		foreach ($this->stored_users as $user) {
			if(($user['student number'] == $this->student_number)&&($user['month'] == $this->month)&& ($user['day'] == $this->day)&&($user['year'] == $this->year)&&($user['family name'] == $this->family_name)){
				if($user['username'] == $this->username){
					if(password_verify($this->password, $user['password'])){
						session_start();
						$_SESSION['user'] = $this->username;
						header("location: account.php"); exit();
					}
				}
			}
		}
		return $this->error = "Invalid log in details.";
	}

}