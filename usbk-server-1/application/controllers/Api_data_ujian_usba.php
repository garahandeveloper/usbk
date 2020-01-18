<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_data_ujian_usba extends CI_Controller {

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
	public function dataujian(){
		if (empty($_POST)) {
			# code...
		} else {
			if (!empty($this->input->post("id_ujian"))) {
				$ps = $this->input->post("id_ujian");
				$where = "WHERE a.`id_ujian` = '$ps'";
			} else {
				$where = "";
			}
			$response = array();
			
			$query = $this->Function_model_manually->readDataManuallyController("
			
			SELECT
			  a.`id_ujian`,
			  a.`nama_ujian` AS ujian,
			  a.`token`,
			  b.`nama_kelas` AS kelas,
			  c.`nama_materi` AS materi,
			  a.`jumlah_ujian` AS jumlah
			FROM
			  `ujian` AS a
			  JOIN `kelas` AS b
			  JOIN `materi` AS c
			    ON a.`kelas_id` = b.`id_kelas`
			    AND a.`materi_id` = c.`id_materi`
			$where
			ORDER BY a.id_ujian DESC
			
			");
			foreach($query as $item){
				$ujian["id_ujian"] = $item["id_ujian"];
				$ujian["ujian"] = $item["ujian"];
				$ujian["token"] = $item["token"];
				$ujian["kelas"] = $item["kelas"];
				$ujian["materi"] = $item["materi"];
				$ujian["jumlah"] = $item["jumlah"];
				array_push($response, $item);
			}
			echo json_encode($response);
		}
		
	}
	public function inputUjian(){
		if(empty($this->input->post("nama_ujian"))){}
		else {
			$response = array();
			$where = array(
					"nama_ujian" => $this->input->post("nama_ujian"),
					"kelas_id" => $this->input->post("kelas"),
					"token" => rand(000000000, 999999999),
					"guru_id" => $this->input->post("guru"),
					"materi_id" => $this->input->post("materi"),
					"jumlah_ujian" => $this->input->post("jumlah_ujian")
				);
			$this->crud_function_model->insertData("ujian", $where);
			$item["message"] = "success";
			array_push($response, $item);
			echo json_encode($response);
		}
	}
	public function updateUjian(){
		if(empty($this->input->post("nama_ujian"))){}
		else {
			$response = array();
			$set = array(
					"nama_ujian" => $this->input->post("nama_ujian"),
					"kelas_id" => $this->input->post("kelas"),
					"guru_id" => $this->input->post("guru"),
					"materi_id" => $this->input->post("materi"),
					"jumlah_ujian" => $this->input->post("jumlah_ujian")
				);
			$where = array(
					"id_ujian" => $this->input->post("id_ujian")
				);
			$this->crud_function_model->updateData("ujian", $set, $where);
			$item["status"] = "1";
			array_push($response, $item);
			echo json_encode($response);
		}
	}
	public function deleteujian(){
			$response = array();
			$id_ujian = $this->input->post("id_ujian");
			
			$whereSoal = array(
					"ujian_id" => $this->input->post("id_ujian")
				);
			$whereUjian = array(
					"id_ujian" => $this->input->post("id_ujian")
				);
			
			$query = $this->crud_function_model->login("soal", $whereSoal);
			if ($query == 0) {
				$delete["message"] = "Data Berhasil Di hapus";
				$this->crud_function_model->deleteData("ujian", $whereUjian);
			} else {
				$delete["message"] = "tidak bisa di hapus karna ada soal yang menggunakan ujian ini";
			}
			array_push($response, $delete);
			echo json_encode($response);
	}
}