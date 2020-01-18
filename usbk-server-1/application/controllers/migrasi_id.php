<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class migrasi_id extends CI_Controller {

	public function __construct(){
		
		parent:: __construct();
		ini_set('max_execution_time', 0); 
ini_set('memory_limit','20484444M');
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
		$query = $this->Function_model_manually->readDataManuallyController("SELECT * FROM `jawaban_siswa` AS a ORDER BY a.`id_jawaban_siswa` ASC");
		foreach ($query as $key) {
			$nn = $key["no_soal"] - 1;
			$set = array(
					"no_soal" => $nn
				);
			$where = array(
					"id_jawaban_siswa" => $key["id_jawaban_siswa"]
				);
	//$this->crud_function_model->updateData("`jawaban_siswa`", $set, $where);
			//echo $where["id_jawaban_siswa"]."<br />";
		}
	}
}