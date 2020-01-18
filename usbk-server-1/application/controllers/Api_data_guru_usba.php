<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_data_guru_usba extends CI_Controller {

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
		
		
	}
	public function index(){
	}
	public function dataGuru(){
		$response = array();
		$query = $this->crud_function_model->readData("guru", "", "", "nama_guru ASC");
		foreach ($query as $value) {
			$guru["id_guru"] = $value["id_guru"];
			$guru["nama_guru"] = $value["nama_guru"];
			$guru["username"] = $value["username"];
			$guru["password"] = $value["password"];
			array_push($response, $guru);
		}
		echo json_encode($response);
	}
	public function inputDataGuru(){
		if(empty($this->input->post("nama_guru"))){}
		else {
			$response = array();
			$where = array(
					"nama_guru" => $this->input->post("nama_guru"),
					"username" => $this->input->post("username"),
					"password" => sha1($this->input->post("password"))
				);
			$this->crud_function_model->insertData("guru", $where);
			$item["message"] ="1";
			array_push($response, $item);
			echo json_encode($response);
		}
	}
	public function deleteDataGuru(){
		if(empty($this->input->post("id_guru"))){}
		else {
			$response = array();
			$whereGabunganData = array(
					"id_guru" => $this->input->post("id_guru")
				);

			$whereUjianSelectIdGuru = array(
				"guru_id" => $this->input->post("id_guru")
			);
			$query = $this->crud_function_model->login("ujian", $whereUjianSelectIdGuru);
			if ($query == 0) {
				$this->crud_function_model->deleteData("guru", $whereGabunganData);
				$item["message"] = "berhasil di hapus";
			} else {
				$item["message"] = "tidak bisa di hapus ada ujian yang menggunakan id guru ini";
			}
			array_push($response, $item);
			echo json_encode($response);
		}
	}
	public function viewEditGuru(){
		$whereView = array(
				"id_guru" => $this->input->post("id_guru")
			);
		$response = array();
		$query = $this->crud_function_model->readData("guru", "", $whereView, "");
		foreach ($query as $value) {
			$guru["id_guru"] = $value["id_guru"];
			$guru["nama_guru"] = $value["nama_guru"];
			$guru["username"] = $value["username"];
			$guru["password"] = $value["password"];
			array_push($response, $guru);
		}
		echo json_encode($response);
	}
	public function editDataGuru(){
		if (empty($this->input->post("id_guru")) || empty($this->input->post("nama_guru")) || empty($this->input->post("username")) || empty($this->input->post("password"))) {
			
		} else {
			$whereEdit = array(
					"id_guru" => $this->input->post("id_guru")
				);

			$whereSet = array(
					"nama_guru" => $this->input->post("nama_guru"),
					"username" => $this->input->post("username"),
					"password" => sha1($this->input->post("password"))
				);

			$this->crud_function_model->updateData("guru", $whereSet, $whereEdit);
			$response = array();
			$edit["message"] = "1";
			array_push($response, $edit);
			echo json_encode($response);
		}
		
	}

}