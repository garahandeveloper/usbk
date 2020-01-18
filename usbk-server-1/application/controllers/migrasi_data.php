<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class migrasi_data extends CI_Controller {

	public function __construct(){
		
		parent:: __construct();
		$this->load->database();
		// ini untuk crud automatic
		$this->load->model("crud_function_model");
		// ini untuk crud manually
		$this->load->model("Function_model_manually");
		
	}
	public function index(){
			// $www = array(
				"ujian_id" => '63'
			);
		$query = $this->crud_function_model->readData("soal",  "", $www, "id_soal asc");

		foreach ($query as $key) {
			$nomer = $key["id_soal"] - 2228;
			//echo $nomer."-----<br />";
			$ww = array(
					"id" => $nomer
				);
			$query1 = $this->crud_function_model->readData("bahasainggrisxi", "", $ww, "id asc");
			foreach ($query1 as $value1) {
				$w  = array(
					'deskripsi_a' => $value1["a"],
					'soal_id' => $key["id_soal"]
				);
				$this->crud_function_model->insertData("`pilihan_a`", $w);

				$w  = array(
					'deskripsi_b' => $value1["b"],
					'soal_id' => $key["id_soal"]
				);
				$this->crud_function_model->insertData("`pilihan_b`", $w);

				$w  = array(
					'deskripsi_c' => $value1["c"],
					'soal_id' => $key["id_soal"]
				);
				$this->crud_function_model->insertData("`pilihan_c`", $w);

				$w  = array(
					'deskripsi_d' => $value1["d"],
					'soal_id' => $key["id_soal"]
				);
				$this->crud_function_model->insertData("`pilihan_d`", $w);

				$w  = array(
					'deskripsi_e' => $value1["e"],
					'soal_id' => $key["id_soal"]
				);
				$this->crud_function_model->insertData("`pilihan_e`", $w);
				//echo $value1["id"]."<br />";
				//echo '$this->Function_model_manually->readDataManuallyController("INSERT INTO pilihan_a (deskripsi_a, soal_id)VALUES('.$value1["soal"].', '.$key["id_soal"].');'."<br />";
			}
			
		}
		
	}
}