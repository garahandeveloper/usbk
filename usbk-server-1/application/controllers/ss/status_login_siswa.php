<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class status_login_siswa extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model("crud_function_model");
		if(empty($_SESSION['username'])){
			redirect('login');
		} else {	
		}
	}
	public function index(){
	}
	public function load(){
		if(empty($_GET["act"])){
							
		} else {
			if($_GET["act"] == "insert"){
			
				$arrayPost = array(
				"NISN_siswa" => $this->input->post("NISN_siswa"),"time" => $this->input->post("time"),
				);
				$this->form_validation->set_rules("NISN_siswa", "NISN_siswa", "required");$this->form_validation->set_rules("time", "time", "required");
				if($this->form_validation->run() == true){
					$this->crud_function_model->insertData("status_login_siswa", $arrayPost);
					$message =  array(
					"message" => "Data Berhasil Di Simpan"
					);
				} else {
					$message =  array(
					"message" => validation_errors()
					);
				}
				$this->load->view("admin/valids/validationmessage", $message);
			
			} // end insert
			
			else if($_GET["act"] == "load"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("status_login_siswa", "", "", "id_status_login_siswa desc"),
					"idDb" => "id_status_login_siswa"
				);
				$this->load->view("admin/content/status_login_siswa/table", $queryDataRead);
			} // end load
			else if($_GET["act"] == "delete"){
				
				$this->crud_function_model->deleteData("status_login_siswa", "id_status_login_siswa = $_GET[id]");
			} // end delete	
			else if($_GET["act"] == "view"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("status_login_siswa", "", "id_status_login_siswa = $_GET[id]", "id_status_login_siswa desc"),
					"idDb" => "id_status_login_siswa"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
					
						<tr>
							<td>NISN_siswa</td>
							<td>"; echo $item["NISN_siswa"]; echo "</td>
						</tr>
						
						<tr>
							<td>time</td>
							<td>"; echo $item["time"]; echo "</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view
			else if($_GET["act"] == "viewEdit"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("status_login_siswa", "", "id_status_login_siswa = $_GET[id]", "id_status_login_siswa desc"),
					"idDb" => "id_status_login_siswa"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
						<tr>
							<input type='hidden' name='id' class='form-control' style='width:100%;' value='"; echo $item["id_status_login_siswa"]; echo "' hidden>
						
							<td>NISN_siswa</td>
							<td>
							
									<input type='text' name='NISN_siswa' class='form-control' style='width:100%;' value='"; echo $item["NISN_siswa"]; echo "' >
								
							</td>
						</tr>
						
							<td>time</td>
							<td>
							
									<input type='text' name='time' class='form-control' style='width:100%;' value='"; echo $item["time"]; echo "' >
								
							</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view edit
			else if($_GET["act"] == "update"){
				
				$id = $this->input->post("id");
				$arrayPost = array(
				"NISN_siswa" => $this->input->post("NISN_siswa"),"time" => $this->input->post("time"),
				);
				$this->form_validation->set_rules("NISN_siswa", "NISN_siswa", "required");$this->form_validation->set_rules("time", "time", "required");
				if($this->form_validation->run() == true){
					$this->crud_function_model->updateData("status_login_siswa", $arrayPost, "id_status_login_siswa = '$id'");
					$message =  array(
					"message" => "Data Berhasil Di Simpan"
					);
				} else {
					$message =  array(
					"message" => validation_errors()
					);
				}
				$this->load->view("admin/valids/validationmessage", $message);
			
			}// end update 
			else if($_GET["act"] == "search"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("status_login_siswa", "", "id_status_login_siswa like '%$_GET[id]%'  || NISN_siswa like '%$_GET[id]%' || time like '%$_GET[id]%' ", "id_status_login_siswa desc"),
					"idDb" => "id_status_login_siswa"
				);
				$this->load->view("admin/content/status_login_siswa/table", $queryDataRead);
			}// end search
		}// end else // pertama
	}
}
			