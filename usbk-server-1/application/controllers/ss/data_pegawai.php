<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class data_pegawai extends CI_Controller {
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
				"nama_sekolah" => $this->input->post("nama_sekolah"),"nama_lengkap" => $this->input->post("nama_lengkap"),"NIK" => $this->input->post("NIK"),"jenis_kelamin" => $this->input->post("jenis_kelamin"),"ttl" => $this->input->post("ttl"),"nama_ibu_kandung" => $this->input->post("nama_ibu_kandung"),"alamat" => $this->input->post("alamat"),"agama" => $this->input->post("agama"),"tlp" => $this->input->post("tlp"),
				);
				$this->form_validation->set_rules("nama_sekolah", "nama_sekolah", "required");$this->form_validation->set_rules("nama_lengkap", "nama_lengkap", "required");$this->form_validation->set_rules("NIK", "NIK", "required");$this->form_validation->set_rules("jenis_kelamin", "jenis_kelamin", "required");$this->form_validation->set_rules("ttl", "ttl", "required");$this->form_validation->set_rules("nama_ibu_kandung", "nama_ibu_kandung", "required");$this->form_validation->set_rules("alamat", "alamat", "required");$this->form_validation->set_rules("agama", "agama", "required");$this->form_validation->set_rules("tlp", "tlp", "required");
				if($this->form_validation->run() == true){
					$this->crud_function_model->insertData("data_pegawai", $arrayPost);
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
					"tampilData" => $this->crud_function_model->readData("data_pegawai", "", "", "id_data_pegawai desc"),
					"idDb" => "id_data_pegawai"
				);
				$this->load->view("admin/content/data_pegawai/table", $queryDataRead);
			} // end load
			else if($_GET["act"] == "load_sekolah"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("data_sekolah", "", "", "id_data_sekolah desc"),
					"idDb" => "id_data_pegawai"
				);
				echo "<select name='nama_sekolah' class='form-control'>
						<option value=''>Pilih Sekolah</option>
				";
				foreach($queryDataRead["tampilData"] as $item){
					echo "<option value='$item[id_data_sekolah]'>$item[nama_sekolah]</option>";
				}
				echo "</select>";
			} // end load
			else if($_GET["act"] == "delete"){
				
				$this->crud_function_model->deleteData("data_pegawai", "id_data_pegawai = $_GET[id]");
			} // end delete	
			else if($_GET["act"] == "view"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("data_pegawai", "", "id_data_pegawai = $_GET[id]", "id_data_pegawai desc"),
					"idDb" => "id_data_pegawai"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
					
						<tr>
							<td>nama_sekolah</td>
							<td>"; echo $item["nama_sekolah"]; echo "</td>
						</tr>
						
						<tr>
							<td>nama_lengkap</td>
							<td>"; echo $item["nama_lengkap"]; echo "</td>
						</tr>
						
						<tr>
							<td>NIK</td>
							<td>"; echo $item["NIK"]; echo "</td>
						</tr>
						
						<tr>
							<td>jenis_kelamin</td>
							<td>"; echo $item["jenis_kelamin"]; echo "</td>
						</tr>
						
						<tr>
							<td>ttl</td>
							<td>"; echo $item["ttl"]; echo "</td>
						</tr>
						
						<tr>
							<td>nama_ibu_kandung</td>
							<td>"; echo $item["nama_ibu_kandung"]; echo "</td>
						</tr>
						
						<tr>
							<td>alamat</td>
							<td>"; echo $item["alamat"]; echo "</td>
						</tr>
						
						<tr>
							<td>agama</td>
							<td>"; echo $item["agama"]; echo "</td>
						</tr>
						
						<tr>
							<td>tlp</td>
							<td>"; echo $item["tlp"]; echo "</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view
			else if($_GET["act"] == "viewEdit"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("data_pegawai", "", "id_data_pegawai = $_GET[id]", "id_data_pegawai desc"),
					"idDb" => "id_data_pegawai"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
						<tr>
							<input type='hidden' name='id' class='form-control' style='width:100%;' value='"; echo $item["id_data_pegawai"]; echo "' hidden>
						
							<td>nama_sekolah</td>
							<td>
							
									<input type='text' name='nama_sekolah' class='form-control' style='width:100%;' value='"; echo $item["nama_sekolah"]; echo "' >
								
							</td>
						</tr>
						
							<td>nama_lengkap</td>
							<td>
							
									<input type='text' name='nama_lengkap' class='form-control' style='width:100%;' value='"; echo $item["nama_lengkap"]; echo "' >
								
							</td>
						</tr>
						
							<td>NIK</td>
							<td>
							
									<input type='text' name='NIK' class='form-control' style='width:100%;' value='"; echo $item["NIK"]; echo "' >
								
							</td>
						</tr>
						
							<td>jenis_kelamin</td>
							<td>
							
									<input type='text' name='jenis_kelamin' class='form-control' style='width:100%;' value='"; echo $item["jenis_kelamin"]; echo "' >
								
							</td>
						</tr>
						
							<td>ttl</td>
							<td>
							
									<input type='text' name='ttl' class='form-control' style='width:100%;' value='"; echo $item["ttl"]; echo "' >
								
							</td>
						</tr>
						
							<td>nama_ibu_kandung</td>
							<td>
							
									<input type='text' name='nama_ibu_kandung' class='form-control' style='width:100%;' value='"; echo $item["nama_ibu_kandung"]; echo "' >
								
							</td>
						</tr>
						
							<td>alamat</td>
							<td>
							
									<input type='text' name='alamat' class='form-control' style='width:100%;' value='"; echo $item["alamat"]; echo "' >
								
							</td>
						</tr>
						
							<td>agama</td>
							<td>
							
									<input type='text' name='agama' class='form-control' style='width:100%;' value='"; echo $item["agama"]; echo "' >
								
							</td>
						</tr>
						
							<td>tlp</td>
							<td>
							
									<input type='text' name='tlp' class='form-control' style='width:100%;' value='"; echo $item["tlp"]; echo "' >
								
							</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view edit
			else if($_GET["act"] == "update"){
				
				$id = $this->input->post("id");
				$arrayPost = array(
				"nama_sekolah" => $this->input->post("nama_sekolah"),"nama_lengkap" => $this->input->post("nama_lengkap"),"NIK" => $this->input->post("NIK"),"jenis_kelamin" => $this->input->post("jenis_kelamin"),"ttl" => $this->input->post("ttl"),"nama_ibu_kandung" => $this->input->post("nama_ibu_kandung"),"alamat" => $this->input->post("alamat"),"agama" => $this->input->post("agama"),"tlp" => $this->input->post("tlp"),
				);
				$this->form_validation->set_rules("nama_sekolah", "nama_sekolah", "required");$this->form_validation->set_rules("nama_lengkap", "nama_lengkap", "required");$this->form_validation->set_rules("NIK", "NIK", "required");$this->form_validation->set_rules("jenis_kelamin", "jenis_kelamin", "required");$this->form_validation->set_rules("ttl", "ttl", "required");$this->form_validation->set_rules("nama_ibu_kandung", "nama_ibu_kandung", "required");$this->form_validation->set_rules("alamat", "alamat", "required");$this->form_validation->set_rules("agama", "agama", "required");$this->form_validation->set_rules("tlp", "tlp", "required");
				if($this->form_validation->run() == true){
					$this->crud_function_model->updateData("data_pegawai", $arrayPost, "id_data_pegawai = '$id'");
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
					"tampilData" => $this->crud_function_model->readData("data_pegawai", "", "id_data_pegawai like '%$_GET[id]%'  || nama_sekolah like '%$_GET[id]%' || nama_lengkap like '%$_GET[id]%' || NIK like '%$_GET[id]%' || jenis_kelamin like '%$_GET[id]%' || ttl like '%$_GET[id]%' || nama_ibu_kandung like '%$_GET[id]%' || alamat like '%$_GET[id]%' || agama like '%$_GET[id]%' || tlp like '%$_GET[id]%' ", "id_data_pegawai desc"),
					"idDb" => "id_data_pegawai"
				);
				$this->load->view("admin/content/data_pegawai/table", $queryDataRead);
			}// end search
		}// end else // pertama
	}
}
			