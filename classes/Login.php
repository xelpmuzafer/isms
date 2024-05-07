<?php
require_once '../config.php';
class Login extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;

		parent::__construct();
		ini_set('display_error', 1);
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function index(){
		echo "<h1>Access Denied</h1> <a href='".base_url."'>Go Back.</a>";
	}
	public function login(){
		extract($_POST);

		$stmt = $this->conn->prepare("SELECT * from users where username = ? and password = ? ");
		$password = md5($password);
		$stmt->bind_param('ss',$username,$password);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			foreach($result->fetch_array() as $k => $v){
				if(!is_numeric($k) && $k != 'password'){
					$this->settings->set_userdata($k,$v);
				}

			}
			$this->settings->set_userdata('login_type',1);
		return json_encode(array('status'=>'success'));
		}else{
		return json_encode(array('status'=>'incorrect','last_qry'=>"SELECT * from users where username = '$username' and password = md5('$password') "));
		}
	}
	public function logout(){
		if($this->settings->sess_des()){
			redirect('admin/login.php');
		}
	}
	function login_customer(){
		extract($_POST);
		$stmt = $this->conn->prepare("SELECT * from customer_list where email = ? and `password` = ? ");
		$password = md5($password);
		$stmt->bind_param('ss',$email,$password);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			$res = $result->fetch_array();
			foreach($res as $k => $v){
				$this->settings->set_userdata($k,$v);
			}
			$this->settings->set_userdata('login_type',2);
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = 'Incorrect Email or Password';
		}
		if($this->conn->error){
			$resp['status'] = 'failed';
			$resp['_error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

    public function getLocationList() {
	// API endpoint URL
	$url = DASH_API . '/v1/super-admin/location-list';
	
  
	
	// $accessToken = $this->session->userdata('access_token');
	$accessToken = $this->settings->userdata('token');
		// print_r($accessToken); die;
			// Headers
	$headers = array(
		'Accept: application/json',
		'Authorization: Bearer ' . $accessToken
	);
  
	// Set up HTTP headers
	$header_str = implode("\r\n", $headers);
  
	// Set up stream context options
	$options = array(
		'http' => array(
			'method' => 'GET',
			'header' => $header_str
		)
	);
  
	// Create stream context
	$context = stream_context_create($options);
  
	// Send HTTP request and get response
	$response = file_get_contents($url, false, $context);
  
	$decoded_response = json_decode($response, true); // true for associative array
  
	// Return API response
	return $decoded_response['resource']['data'];
  }

	public function logout_customer(){
		if($this->settings->sess_des()){
			redirect('?');
		}
	}
	public function auth_inventory(){
		


		// print_r($loc_id); die;

		$id =$_GET['platform_user_id'];
		$url = 'http://roster.reverely.ai/api/employee?id='.$id;
		$options = array(
		'http' => array(
			'method' => 'GET',
			// Add headers if necessary
			// 'header' => 'Content-type: application/json\r\n',
			// 'header' => 'Authorization: Bearer your_access_token\r\n'
		)
		);
		$context = stream_context_create($options);
		$response = file_get_contents($url, false, $context);	


		$token = $_GET['token'];
		$loc_id = $_GET['loc_id'];

		$this->settings->set_userdata('token',$token);
		$this->settings->set_userdata('loc_id',$loc_id);

		//fetch Locations
		//save to set_userdata
		

		try{
			$url = DASH_API . '/v1/super-admin/location-list';
	
  
			
			// $accessToken = $this->session->userdata('access_token');
			$accessToken = $this->settings->userdata('token');
				// print_r($accessToken); die;
					// Headers
			$headers = array(
				'Accept: application/json',
				'Authorization: Bearer ' . $accessToken
			);
		
			// Set up HTTP headers
			$header_str = implode("\r\n", $headers);
		
			// Set up stream context options
			$options = array(
				'http' => array(
					'method' => 'GET',
					'header' => $header_str
				)
			);
		
			// Create stream context
			$context = stream_context_create($options);
		
			// Send HTTP request and get response
			$response = file_get_contents($url, false, $context);
		
			$decoded_response = json_decode($response, true);
			
			

			$locations = $decoded_response['resource']['data'];

			$this->settings->set_userdata('locations',$locations);
			

		}catch(Exception $e){
				print_r($e); die;
		}



		$this->settings->set_userdata('type',1);



		// die;	
		  
		// $username = 'admin';
		// $password = 'admin123';
		// $stmt = $this->conn->prepare("SELECT * from users where username = ? and password = ? ");
		// $password = md5($password);
		// $stmt->bind_param('ss',$username,$password);
		// $stmt->execute();
		// $result = $stmt->get_result();
		// if($result->num_rows > 0){

			$responseArray = json_decode($response, true);
			 //print_r($responseArray);die;
				// Access the 'data' array
			$dataArray = $responseArray['data'];

			
			
		//print_r($response);die;
		$this->settings->set_userdata('avatar1',$responseArray['data']['image_url']);
		$this->settings->set_userdata('username',$responseArray['data']['name']);
		$this->settings->set_userdata('login_type',1);
		$this->settings->set_userdata('username',$responseArray['data']->name);
		header('location:'.base_url.'admin/');
		return json_encode(array('status'=>'success'));
		//}else{
		return json_encode(array('status'=>'incorrect','last_qry'=>"SELECT * from users where username = '$username' and password = md5('$password') "));
		//}
	}
}
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$auth = new Login();
switch ($action) {
	case 'login':
		echo $auth->login();
		break;
	case 'logout':
		echo $auth->logout();
		break;
	case 'login_customer':
		echo $auth->login_customer();
		break;
	case 'logout_customer':
		echo $auth->logout_customer();
		break;
	case 'auth_inventory':
		echo $auth->auth_inventory();
		break;
	default:
		echo $auth->index();
		break;
}