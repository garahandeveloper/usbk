<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_data_ujian_gabungan_usba extends CI_Controller {

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
	}
	public function ujiangabungan(){
		$response = array();
		
		$query = $this->Function_model_manually->readDataManuallyController("
		
		SELECT
		  *
		FROM
		  `ujian_gabungan` AS a ORDER BY a.`id_ujian_gabungan` DESC
		");
		foreach($query as $item){
			$ujian["id_ujian_gabungan"] = $item["id_ujian_gabungan"];
			$ujian["nama_ujian_gabungan"] = $item["nama_ujian_gabungan"];
			array_push($response, $item);
		}
		echo json_encode($response);
	}
	public function inputUjianGabungan(){
		if(empty($this->input->post("nama_ujian_gabungan"))){}
		else {
			$response = array();
			$whereGabunganData = array(
				"nama_ujian_gabungan" => $this->input->post("nama_ujian_gabungan"),
				"token_ujian_gabungan" => rand(0000000, 9999999)
			);
			$this->crud_function_model->insertData("ujian_gabungan", $whereGabunganData);
			$item["message"] = "1";
			array_push($response, $item);
			echo json_encode($response);
		}
		
	}
	public function inputDataUjianGabungan(){
		if(empty($this->input->post("id_ujian_gabungan")) && empty($this->input->post("id_ujian"))){}
		else {
			$response = array();
			$whereGabunganData = array(
				"ujian_gabungan_id" => $this->input->post("id_ujian_gabungan"),
				"ujian_id" => $this->input->post("id_ujian")
			);
			$this->crud_function_model->insertData("data_ujian_gabungan", $whereGabunganData);
			$item["message"] = "1";
			array_push($response, $item);
			echo json_encode($response);
		}
		
	}
	public function deleteUjianGabungan(){
		if(empty($this->input->post("id_ujian_gabungan"))){}
		else {
			$response = array();
			$whereGabunganData = array(
					"id_ujian_gabungan" => $this->input->post("id_ujian_gabungan")
				);
			$ujianGabunganId = array(
					"ujian_gabungan_id" => $this->input->post("id_ujian_gabungan")
				);
			$query = $this->crud_function_model->login("data_ujian_gabungan", $ujianGabunganId);
			if ($query == 0) {
				$this->crud_function_model->deleteData("ujian_gabungan", $whereGabunganData);
				$item["message"] = "berhasil di hapus";
			} else {
				$item["message"] = "tidak bisa di hapus ada data ujian gabungan yang menggunakan id ujian gabungan ini";
			}
			
			array_push($response, $item);
			echo json_encode($response);
		}
	}
	public function dataujianWhere(){
		$response = array();
		$ww = $this->input->post("id_ujian_gabungan");
		$query = $this->Function_model_manually->readDataManuallyController("
		
		SELECT
		  a.`id_ujian`,
		  a.`nama_ujian`,
		  c.`nama_ujian_gabungan`,
		  d.`nama_materi` AS materi,
		  e.`nama_kelas` AS kelas,
		  a.`token`,
		  b.`id_data_ujian_gabungan`
		FROM
		  `ujian` AS a
		  JOIN `data_ujian_gabungan` AS b
		  JOIN `ujian_gabungan` AS c
		  JOIN `materi` AS d
		  JOIN `kelas` AS e
			ON a.`id_ujian` = b.`ujian_id` && c.`id_ujian_gabungan` = b.`ujian_gabungan_id` && a.`kelas_id` = e.`id_kelas` && a.`materi_id` = d.`id_materi`
		WHERE c.`id_ujian_gabungan` = '$ww' ORDER BY a.`id_ujian` DESC
		
		");
		//$this->input->post(id_ujian_gabungan)
		foreach($query as $item){
			$ujian["id_ujian"] = $item["id_ujian"];
			$ujian["nama_ujian"] = $item["nama_ujian"];
			$ujian["nama_ujian_gabungan"] = $item["nama_ujian_gabungan"];
			$ujian["kelas"] = $item["kelas"];
			$ujian["materi"] = $item["materi"];
			$ujian["token"] = $item["token"];
			array_push($response, $item);
		}
		echo json_encode($response);
	}
	public function deleteDataUjianGabungan(){
		if(empty($this->input->post("id_data_ujian_gabungan"))){}
		else {
			$response = array();
			$whereGabunganData = array(
					"id_data_ujian_gabungan" => $this->input->post("id_data_ujian_gabungan")
				);
			$this->crud_function_model->deleteData("data_ujian_gabungan", $whereGabunganData);
			$item["message"] = "1";
			array_push($response, $item);
			echo json_encode($response);
		}
	}
}