<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_login_guru_usba extends CI_Controller {

	public function __construct(){
		
		parent:: __construct();
		$this->output->set_header( "Access-Control-Allow-Origin: *" );
		$this->output->set_header( "Access-Control-Allow-Credentials: true" );
		$this->output->set_header( "Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS" );
		$this->output->set_header( "Access-Control-Max-Age: 604800" );
		$this->output->set_header( "Access-Control-Request-Headers: x-requested-with" );
		$this->output->set_header( "Access-Control-Allow-Headers: x-requested-with, x-requested-by" );
		
		$this->load->database();
		// ini untuk crud automatic
		$this->load->model("crud_function_model");
		// ini untuk crud manually
		$this->load->model("Function_model_manually");
		$response = array();
		
	}
	public function index(){
		$response = array();
		$where = array(
			"username" => $this->input->post("username"),
			"password" => sha1($this->input->post("password"))
		);
		$queryLogin = $this->crud_function_model->login("guru", $where);
		if ($queryLogin > 0) {
			$login["message"]  = "1";
			$queryAmbilData = $this->crud_function_model->readData("guru", "", $where, "");
			foreach($queryAmbilData as $item){
				$login["nama_guru"] = $item["nama_guru"];
				$login["username"] = $item["username"];
			}
		} else {
			$login["message"]  = "0";
		}
		array_push($response, $login);
		echo json_encode($response);

	}
}