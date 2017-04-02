<?php
include ('includes/model.php');
class api extends REST {
	public function processApi() {
		if (isset ( $_REQUEST ['rquest'] )) {
			$func = strtolower ( trim ( str_replace ( "/", "", $_REQUEST ['rquest'] ) ) );
			if (( int ) method_exists ( $this, $func ) > 0) {
				$this->$func ();
			} else {
				$this->response ( 'Page not found', 404 );
			}
		} else {
			$this->response ( 'Page not found', 404 );
		}
		// If the method not exist with in this class, response would be "Page not found".
	}
	function register() {
		if ($this->get_request_method () != "POST") {
			$this->response ( 'Not Acceptable', 406 );
		} else {
			// Get Data From Json
			$input = json_decode ( file_get_contents ( 'php://input' ), true );
			
			// Make New Object
			$model = new model ();
			
			// Check Empty Or not
			if (! empty ( $input ['username'] ) && ! empty ( $input ['password'] )) {
				// Register Data
				$exe_status = $model->register ( $input ['username'], $input ['password'] );
				if ($exe_status) {
					$error = array (
							'status' => "SUCCESS",
							"msg" => "Insert Successfully.." 
					);
					$this->response ( $this->json ( $error ), 200 );
				} else {
					$error = array (
							'status' => "FAILED",
							"msg" => "Something Wrong.." 
					);
					$this->response ( $this->json ( $error ), 400 );
				}
			} else {
				$error = array (
						'status' => "FAILED",
						"msg" => "Invalid Email address or Password" 
				);
				$this->response ( $this->json ( $error ), 400 );
				// If Empty
			}
		}
	} // Register
	function login() {
		if ($this->get_request_method () != "POST") {
			$this->response ( 'Not Acceptable', 406 );
		} 
		else {
			
			// Get Data From Json
			$input = json_decode ( file_get_contents ( 'php://input' ), true );
			
			// Make New Object
			$model = new model ();
			
			// Check Empty Or not
			if (! empty ( $input ['username'] ) && ! empty ( $input ['password'] )) {
				// Register Data
				$user_detail = $model->login ( $input ['username'], $input ['password'] );
				if ($user_detail != null) {
					$error = array (
							'status' => "SUCCESS",
							"msg" => "Insert Successfully..",
							"data" => $user_detail 
					);
					$this->response ( $this->json ( $error ), 200 );
				}
			} else {
				$error = array (
						'status' => "FAILED",
						"msg" => "Invalid Email address or Password" 
				);
				$this->response ( $this->json ( $error ), 400 );
				// If Empty
			}
		}
	} // login
	  
	// Encode array into JSON
	private function json($data) {
		if (is_array ( $data )) {
			return json_encode ( $data );
		}
	}
} // class api
$api = new api ();
$api->processApi ();

?>
	
	