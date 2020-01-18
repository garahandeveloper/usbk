<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_materi_usba extends CI_Controller {

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
	public function datamateri(){
		$response = array();
		
		$query = $this->crud_function_model->readData("materi", "", "", "nama_materi ASC");
		foreach($query as $item){
			$materi["id_materi"] = $item["id_materi"];
			$materi["materi"] = $item["nama_materi"];
			array_push($response, $materi);
		}
		
		echo json_encode($response);
	}
	public function inputMateri(){
		if(empty($this->input->post("materi"))){
			
		} else {
			$response = array();
			$whereMateri = array(
				"nama_materi" => $this->input->post("materi")
			);
			$this->crud_function_model->insertData("materi", $whereMateri);
			$materiInput["message"] = "1";
			array_push($response, $materiInput);
			echo json_encode($response);
		}
		
		
	}
	public function viewEditMateri(){
		if(empty($this->input->post("id_materi"))){
			
		} else {
			$response = array();
			$whereMateri = array(
				"id_materi" => $this->input->post("id_materi")
			);
			$query = $this->crud_function_model->readData("materi", "", $whereMateri, "");
			foreach($query as $item){
				$materiInput["id_materi"] = $item["id_materi"];
				$materiInput["nama_materi"] = $item["nama_materi"];
			}
			
			array_push($response, $materiInput);
			echo json_encode($response);
		}
	}
	public function editMateri(){
		if(empty($this->input->post("id_materi")) && empty($this->input->post("nama_materi"))){
			
		} else {
			$response = array();
			$whereId = array(
				"id_materi" => $this->input->post("id_materi")
			);
			$whereSet = array(
					"nama_materi" => $this->input->post("nama_materi")
				);
			$query = $this->crud_function_model->updateData("materi", $whereSet, $whereId);
			$materiEdit["message"] = "1";
			
			array_push($response, $materiEdit);
			echo json_encode($response);
		}
	}
	public function deleteMateri(){
		if(empty($this->input->post("id_materi"))){
			
		} else {
			$response = array();
			$whereMateri = array(
				"id_materi" => $this->input->post("id_materi")
			);
			$whereUjianSelectIdMateri = array(
				"materi_id" => $this->input->post("id_materi")
			);
			$query = $this->crud_function_model->login("ujian", $whereUjianSelectIdMateri);
			if ($query == 0) {
				$this->crud_function_model->deleteData("materi", $whereMateri);
				$materiInput["message"] = "berhasil di hapus";
			} else {
				$materiInput["message"] = "tidak bisa di hapus ada ujian yang menggunakan materi ini";
			}
			
			array_push($response, $materiInput);
			echo json_encode($response);
		}
	}
}