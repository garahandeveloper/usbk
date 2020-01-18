<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class gambar extends CI_Controller {
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
					$rand = rand(99999999,0000000);
					// mulai
					$config["file_name"]          = $rand."smk-nurul-mannan-.jpg";
					$config["upload_path"]          = "./uploads/";
					$config["allowed_types"]        = "gif|jpg|png";
					$config["max_size"]             = 1000;
					$config["max_width"]            = 1024;
					$config["max_height"]           = 768;

					$this->load->library("upload", $config);

					if ( ! $this->upload->do_upload("nama_gambar")){
							
							$message =  array(
								"message" => $this->upload->display_errors()
							);
							$this->load->view("admin/valids/validationmessage", $message);
					}
					else {
						
						$arrayPost = array(
						"nama_gambar" => $this->upload->data("file_name"), 
						);
						
							$this->crud_function_model->insertData("gambar", $arrayPost);
							$message =  array(
							"message" => "Data Berhasil Di Simpan"
							);
							
						// end 
						$this->load->view("admin/valids/validationmessage", $message);
					}					
			
			} // end insert
			else if($_GET["act"] == "update"){
					$rand = rand(99999999,0000000);
					// mulai
					$config["file_name"]          = $rand."smk-nurul-mannan-.jpg";
					$config["upload_path"]          = "./uploads/";
					$config["allowed_types"]        = "gif|jpg|png";
					$config["max_size"]             = 1000;
					$config["max_width"]            = 1024;
					$config["max_height"]           = 768;

					$this->load->library("upload", $config);

					if ( ! $this->upload->do_upload("nama_gambar")){
							
							// $message =  array(
								// "message" => $this->upload->display_errors()
							// );
							// $this->load->view("admin/valids/validationmessage", $message);
							echo $this->upload->data("file_name");
					}
					else {
						
						$arrayPost = array(
						"nama_gambar" => $this->upload->data("file_name"), 
						);
						
							$this->crud_function_model->insertData("gambar", $arrayPost);
							$message =  array(
							"message" => "Data Berhasil Di Simpan"
							);
							
						// end 
						$this->load->view("admin/valids/validationmessage", $message);
					}
			}// end update 
			else if($_GET["act"] == "load"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("gambar", "", "", "id_gambar desc"),
					"idDb" => "id_gambar"
				);
				$this->load->view("admin/content/gambar/table", $queryDataRead);
			} // end load
			else if($_GET["act"] == "delete"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("gambar", "", "id_gambar = $_GET[id]", ""),
					"idDb" => "id_gambar"
				);
				foreach($queryDataRead["tampilData"] as $item);
				
				unlink("uploads/$item[nama_gambar]");
				$this->crud_function_model->deleteData("gambar", "id_gambar = $_GET[id]");
			} // end delete	
			else if($_GET["act"] == "view"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("gambar", "", "id_gambar = $_GET[id]", "id_gambar desc"),
					"idDb" => "id_gambar"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
					
						<tr>
							<td>nama_gambar</td>
							<td>"; echo $item["nama_gambar"]; echo "</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view
			else if($_GET["act"] == "viewEdit"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("gambar", "", "id_gambar = $_GET[id]", "id_gambar desc"),
					"idDb" => "id_gambar"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
						<tr>
							<input type='hidden' name='id' class='form-control' style='width:100%;' value='"; echo $item["id_gambar"]; echo "' hidden>
						
							<td>nama_gambar</td>
							<td>
							
									<input type='file' name='nama_gambar' id='nama_gambar'  class='form-control' style='width:100%;' >
								
							</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view edit
			else if($_GET["act"] == "search"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("gambar", "", "id_gambar like '%$_GET[id]%'  || nama_gambar like '%$_GET[id]%' ", "id_gambar desc"),
					"idDb" => "id_gambar"
				);
				$this->load->view("admin/content/gambar/table", $queryDataRead);
			}// end search
		}// end else // pertama
	}
}
			