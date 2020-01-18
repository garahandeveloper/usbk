<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class jenis_tinggal extends CI_Controller {
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
				"nama_jenis_tinggal" => $this->input->post("nama_jenis_tinggal"),
				);
				$this->form_validation->set_rules("nama_jenis_tinggal", "nama_jenis_tinggal", "required");
				if($this->form_validation->run() == true){
					$this->crud_function_model->insertData("jenis_tinggal", $arrayPost);
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
					"tampilData" => $this->crud_function_model->readData("jenis_tinggal", "", "", "id_jenis_tinggal desc"),
					"idDb" => "id_jenis_tinggal"
				);
				$this->load->view("admin/content/jenis_tinggal/table", $queryDataRead);
			} // end load
			else if($_GET["act"] == "delete"){
				
				$this->crud_function_model->deleteData("jenis_tinggal", "id_jenis_tinggal = $_GET[id]");
			} // end delete	
			else if($_GET["act"] == "view"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("jenis_tinggal", "", "id_jenis_tinggal = $_GET[id]", "id_jenis_tinggal desc"),
					"idDb" => "id_jenis_tinggal"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
					
						<tr>
							<td>nama_jenis_tinggal</td>
							<td>"; echo $item["nama_jenis_tinggal"]; echo "</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view
			else if($_GET["act"] == "viewEdit"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("jenis_tinggal", "", "id_jenis_tinggal = $_GET[id]", "id_jenis_tinggal desc"),
					"idDb" => "id_jenis_tinggal"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
						<tr>
							<input type='hidden' name='id' class='form-control' style='width:100%;' value='"; echo $item["id_jenis_tinggal"]; echo "' hidden>
						
							<td>nama_jenis_tinggal</td>
							<td>
							
									<input type='text' name='nama_jenis_tinggal' class='form-control' style='width:100%;' value='"; echo $item["nama_jenis_tinggal"]; echo "' >
								
							</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view edit
			else if($_GET["act"] == "update"){
				
				$id = $this->input->post("id");
				$arrayPost = array(
				"nama_jenis_tinggal" => $this->input->post("nama_jenis_tinggal"),
				);
				$this->form_validation->set_rules("nama_jenis_tinggal", "nama_jenis_tinggal", "required");
				if($this->form_validation->run() == true){
					$this->crud_function_model->updateData("jenis_tinggal", $arrayPost, "id_jenis_tinggal = '$id'");
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
					"tampilData" => $this->crud_function_model->readData("jenis_tinggal", "", "id_jenis_tinggal like '%$_GET[id]%'  || nama_jenis_tinggal like '%$_GET[id]%' ", "id_jenis_tinggal desc"),
					"idDb" => "id_jenis_tinggal"
				);
				$this->load->view("admin/content/jenis_tinggal/table", $queryDataRead);
			}// end search
		}// end else // pertama
	}
}
			