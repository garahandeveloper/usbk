<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model("crud_function_model");
		if(empty($_SESSION['username'])){
			redirect('login');
		} else {	
		}
	}
	public function index()
	{
		if($_SESSION['status'] == "admin"){
			$data = array(
					"username" => $_SESSION['username']
				);
			$readData = array(
				"tampil" => $this->crud_function_model->readData("user", "username as user", $data, "")
			);
		}else if($_SESSION['status'] == "siswa") {
			$data = array(
					"NISN" => $_SESSION['username']
				);
			$readData = array(
				"tampil" => $this->crud_function_model->readData("data_siswa", "nama_lengkap as user", $data, "")
			);
		}
		
		
		$this->load->view('admin/page/header', $readData);
		$this->load->view('admin/page/body');
		$this->load->view('admin/page/footer');
	}
}
