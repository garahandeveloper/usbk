<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_jawaban_soal_siswa_usba extends CI_Controller {

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
		if(empty($this->input->post("nisn")) && empty($this->input->post("nik")) && empty($this->input->post("token")) && empty($this->input->post("no_soal")) && empty($this->input->post("jawaban"))){}
		else {
			$whereJawaban = array(
				"nisn" => $this->input->post("nisn"),
				"nik" => $this->input->post("nik"),
				"token" => $this->input->post("token"),
				"no_soal" => $this->input->post("no_soal"),
				"jawaban" => $this->input->post("jawaban"),
			);
			
			if ($this->crud_function_model->login("jawaban_siswa", $whereJawaban) == 0) {
				$this->crud_function_model->insertData("jawaban_siswa", $whereJawaban);
				$jawaban["message"] = "1";
			} else {
				$jawaban["message"] = "0";
			}
			
			array_push($response, $jawaban);
		}
		
		
		echo json_encode($response);
		
	}
}