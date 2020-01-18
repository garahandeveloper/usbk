<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migrasi_soal extends CI_Controller {
	public function __construct(){
		
		parent::__construct();
		$this->load->database();
		$this->load->model("crud_function_model");
		// ini untuk crud manually
		$this->load->model("Function_model_manually");
		if(empty($_SESSION['username'])){
			redirect('login');
		} else {	
		}
	}
	public function index(){
		$migrasiQuwey = array(
			"migrasi" => $this->Function_model_manually->migrasi_soal_model()
		);
		foreach($migrasiQuwey["migrasi"] as $item1){
			$arrayPost = array(
				"pertanyaan" => $item1["pertanyaan"],
				"a" => $item1["a"],
				"b" => $item1["b"],
				"c" => $item1["c"],
				"d" => $item1["d"],
				"e" => $item1["e"],
				"jawaban" => $item1["jawaban"],
				"token_id" => "64413"
			);
			$this->crud_function_model->insertData("soal", $arrayPost);
		}
	}
	
}