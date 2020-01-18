<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api_USBK_client extends CI_Controller {
	public function __construct($config = 'rest'){
		
		parent::__construct();
		// $this->output->set_header('Access-Control-Allow-Origin: *');
		// $this->output->set_header("Access-Control-Allow-Method: GET, POST, OPTIONS, PUT, DELETE");
		
		
		$this->output->set_header('HTTP/1.0 200 OK');
		$this->output->set_header('HTTP/1.1 200 OK');
		//$this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', $last_update).' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		
		$this->load->database();
		// ini untuk crud automatic
		$this->load->model("crud_function_model");
		// ini untuk crud manually
		$this->load->model("Function_model_manually");
		$this->load->helper('url');
	}
	public function apiLoginSiswa(){
		$arrayPost = array(
			"NISN_siswa" => $this->input->post("NISN_siswa"),"time" => $this->input->post("time"),
		);
		$this->form_validation->set_rules("NISN_siswa", "NISN_siswa", "required");
		$this->form_validation->set_rules("time", "time", "required");
		if($this->form_validation->run() == true){
			$this->crud_function_model->insertData("status_login_siswa", $arrayPost);
			$message =  array(
			"message" => "Data Berhasil Di Simpan"
			);
		} else {
			$message =  array(
			"message" => validation_errors()
			);
		}
		$this->load->view("admin/valids/validationmessage", $message);
	}
}