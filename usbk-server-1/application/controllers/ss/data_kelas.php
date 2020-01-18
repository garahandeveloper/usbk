<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class data_kelas extends CI_Controller {
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
				"nama_kelas" => $this->input->post("nama_kelas"),
				);
				$this->form_validation->set_rules("nama_kelas", "nama_kelas", "required");
				if($this->form_validation->run() == true){
					$this->crud_function_model->insertData("data_kelas", $arrayPost);
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
					"tampilData" => $this->crud_function_model->readData("data_kelas", "", "", "id_data_kelas desc"),
					"idDb" => "id_data_kelas"
				);
				$this->load->view("admin/content/data_kelas/table", $queryDataRead);
			} // end load
			else if($_GET["act"] == "delete"){
				
				$this->crud_function_model->deleteData("data_kelas", "id_data_kelas = $_GET[id]");
			} // end delete	
			else if($_GET["act"] == "view"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("data_kelas", "", "id_data_kelas = $_GET[id]", "id_data_kelas desc"),
					"idDb" => "id_data_kelas"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
					
						<tr>
							<td>nama_kelas</td>
							<td>"; echo $item["nama_kelas"]; echo "</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view
			else if($_GET["act"] == "viewEdit"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("data_kelas", "", "id_data_kelas = $_GET[id]", "id_data_kelas desc"),
					"idDb" => "id_data_kelas"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
						<tr>
							<input type='hidden' name='id' class='form-control' style='width:100%;' value='"; echo $item["id_data_kelas"]; echo "' hidden>
						
							<td>nama_kelas</td>
							<td>
							
									<input type='text' name='nama_kelas' class='form-control' style='width:100%;' value='"; echo $item["nama_kelas"]; echo "' >
								
							</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view edit
			else if($_GET["act"] == "update"){
				
				$id = $this->input->post("id");
				$arrayPost = array(
				"nama_kelas" => $this->input->post("nama_kelas"),
				);
				$this->form_validation->set_rules("nama_kelas", "nama_kelas", "required");
				if($this->form_validation->run() == true){
					$this->crud_function_model->updateData("data_kelas", $arrayPost, "id_data_kelas = '$id'");
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
					"tampilData" => $this->crud_function_model->readData("data_kelas", "", "id_data_kelas like '%$_GET[id]%'  || nama_kelas like '%$_GET[id]%' ", "id_data_kelas desc"),
					"idDb" => "id_data_kelas"
				);
				$this->load->view("admin/content/data_kelas/table", $queryDataRead);
			}// end search
		}// end else // pertama
	}
}
			