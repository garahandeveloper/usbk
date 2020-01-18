<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_jawaban_soal_siswa extends CI_Controller {

	public function __construct(){
		
		parent:: __construct();
		$this->load->database();
		// ini untuk crud automatic
		$this->load->model("crud_function_model");
		// ini untuk crud manually
		$this->load->model("Function_model_manually");
		$response = array();
		
	}
	public function index(){
		if(empty($this->input->post("NISN")) && empty($this->input->post("NIK")) && empty($this->input->post("no")) && empty($this->input->post("token")) && empty($this->input->post("jawaban"))){
			echo "Empty Page";
		} else {
			$response = array();
			$whereId = array(
				"NISN" => $this->input->post("NISN"),
				"NIK" => $this->input->post("NIK"),
				"no" => $this->input->post("no"),
				"token" => $this->input->post("token"),
				"jawaban" => $this->input->post("jawaban")
			);
			
			$query = $this->crud_function_model->insertData("jawaban_soal_siswa", $whereId);
			
			$insert = array();
			$insert["messages"] = "1";
			
			array_push($response, $insert);
			echo json_encode($response);
		}
		
	}
}