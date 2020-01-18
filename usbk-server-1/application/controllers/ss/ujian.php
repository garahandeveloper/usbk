<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ujian extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->database();
		// ini untuk crud automatic
		$this->load->model("crud_function_model");
		// ini untuk crud manually
		$this->load->model("Function_model_manually");
		
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
				"nama_ujian" => $this->input->post("nama_ujian"),"jenis_ujian" => $this->input->post("jenis_ujian"),"tgl_ujian" => $this->input->post("tgl_ujian"),"tgl_input" => $this->input->post("tgl_input"),"guru" => $this->input->post("guru"),"mapel" => $this->input->post("mapel"),"kelas" => $this->input->post("kelas"),"status" => $this->input->post("status"),"token" => $this->input->post("token"),
				);
				$this->form_validation->set_rules("nama_ujian", "nama_ujian", "required");$this->form_validation->set_rules("jenis_ujian", "jenis_ujian", "required");$this->form_validation->set_rules("tgl_ujian", "tgl_ujian", "required");$this->form_validation->set_rules("tgl_input", "tgl_input", "required");$this->form_validation->set_rules("guru", "guru", "required");$this->form_validation->set_rules("mapel", "mapel", "required");$this->form_validation->set_rules("kelas", "kelas", "required");$this->form_validation->set_rules("status", "status", "required");$this->form_validation->set_rules("token", "token", "required");
				if($this->form_validation->run() == true){
					$this->crud_function_model->insertData("ujian", $arrayPost);
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
					"tampilData" => $this->Function_model_manually->readDataJoin(),
					"idDb" => "id_ujian"
				);
				$this->load->view("admin/content/ujian/table", $queryDataRead);
			} // end load
			else if($_GET["act"] == "load_mapel"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("mapel", "", "", "nama_mapel asc"),
					"idDb" => "id_ujian"
				);
				echo "<select name='mapel' class='form-control'>";
				echo "<option value=''>Pilih Mapel</option>";
				foreach($queryDataRead["tampilData"] as $item){
				echo "<option value='$item[id_mapel]'>$item[nama_mapel]</option>";
				}
				echo "</select>";
				
			} // end load_mapel
			else if($_GET["act"] == "load_kelas"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("data_kelas", "", "", "nama_kelas asc"),
					"idDb" => "id_ujian"
				);
				echo "<select name='kelas' class='form-control'>";
				echo "<option value=''>Pilih Kelas</option>";
				foreach($queryDataRead["tampilData"] as $cetak){
				echo "<option value='$cetak[id_data_kelas]'>$cetak[nama_kelas]</option>";
				}
				echo "</select>";
			} // end load_kelas
			else if($_GET["act"] == "load_guru"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("data_pegawai", "", "", "nama_lengkap asc"),
					"idDb" => "id_ujian"
				);
				echo "<select name='guru' class='form-control' >";
				echo "<option value=''>Pilih Guru</option>";
				foreach($queryDataRead["tampilData"] as $guru){
				echo "<option value='$guru[id_data_pegawai]'>$guru[nama_lengkap]</option>";
				}
				echo "</select>";
			} // end load_guru
			else if($_GET["act"] == "delete"){
				
				$this->crud_function_model->deleteData("ujian", "id_ujian = $_GET[id]");
			} // end delete	
			else if($_GET["act"] == "view"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("ujian", "", "id_ujian = $_GET[id]", "id_ujian desc"),
					"idDb" => "id_ujian"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
					
						<tr>
							<td>nama_ujian</td>
							<td>"; echo $item["nama_ujian"]; echo "</td>
						</tr>
						
						<tr>
							<td>jenis_ujian</td>
							<td>"; echo $item["jenis_ujian"]; echo "</td>
						</tr>
						
						<tr>
							<td>tgl_ujian</td>
							<td>"; echo $item["tgl_ujian"]; echo "</td>
						</tr>
						
						<tr>
							<td>tgl_input</td>
							<td>"; echo $item["tgl_input"]; echo "</td>
						</tr>
						
						<tr>
							<td>guru</td>
							<td>"; echo $item["guru"]; echo "</td>
						</tr>
						
						<tr>
							<td>mapel</td>
							<td>"; echo $item["mapel"]; echo "</td>
						</tr>
						
						<tr>
							<td>kelas</td>
							<td>"; echo $item["kelas"]; echo "</td>
						</tr>
						
						<tr>
							<td>status</td>
							<td>"; echo $item["status"]; echo "</td>
						</tr>
						
						<tr>
							<td>token</td>
							<td>"; echo $item["token"]; echo "</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view
			else if($_GET["act"] == "viewEdit"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("ujian", "", "id_ujian = $_GET[id]", "id_ujian desc"),
					"idDb" => "id_ujian"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
						<tr>
							<input type='hidden' name='id' class='form-control' style='width:100%;' value='"; echo $item["id_ujian"]; echo "' hidden>
						
							<td>nama_ujian</td>
							<td>
							
									<input type='text' name='nama_ujian' class='form-control' style='width:100%;' value='"; echo $item["nama_ujian"]; echo "' >
								
							</td>
						</tr>
						
							<td>jenis_ujian</td>
							<td>
							
									<input type='text' name='jenis_ujian' class='form-control' style='width:100%;' value='"; echo $item["jenis_ujian"]; echo "' >
								
							</td>
						</tr>
						
							<td>tgl_ujian</td>
							<td>
							
									<input type='text' name='tgl_ujian' class='form-control' style='width:100%;' value='"; echo $item["tgl_ujian"]; echo "' >
								
							</td>
						</tr>
						
							<td>tgl_input</td>
							<td>
							
									<input type='text' name='tgl_input' class='form-control' style='width:100%;' value='"; echo $item["tgl_input"]; echo "' >
								
							</td>
						</tr>
						
							<td>guru</td>
							<td>
							
									<input type='text' name='guru' class='form-control' style='width:100%;' value='"; echo $item["guru"]; echo "' >
								
							</td>
						</tr>
						
							<td>mapel</td>
							<td>
							
									<input type='text' name='mapel' class='form-control' style='width:100%;' value='"; echo $item["mapel"]; echo "' >
								
							</td>
						</tr>
						
							<td>kelas</td>
							<td>
							
									<input type='text' name='kelas' class='form-control' style='width:100%;' value='"; echo $item["kelas"]; echo "' >
								
							</td>
						</tr>
						
							<td>status</td>
							<td>
							
									<input type='text' name='status' class='form-control' style='width:100%;' value='"; echo $item["status"]; echo "' >
								
							</td>
						</tr>
						
							<td>token</td>
							<td>
							
									<input type='text' name='token' class='form-control' style='width:100%;' value='"; echo $item["token"]; echo "' >
								
							</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view edit
			else if($_GET["act"] == "update"){
				
				$id = $this->input->post("id");
				$arrayPost = array(
				"nama_ujian" => $this->input->post("nama_ujian"),"jenis_ujian" => $this->input->post("jenis_ujian"),"tgl_ujian" => $this->input->post("tgl_ujian"),"tgl_input" => $this->input->post("tgl_input"),"guru" => $this->input->post("guru"),"mapel" => $this->input->post("mapel"),"kelas" => $this->input->post("kelas"),"status" => $this->input->post("status"),"token" => $this->input->post("token"),
				);
				$this->form_validation->set_rules("nama_ujian", "nama_ujian", "required");$this->form_validation->set_rules("jenis_ujian", "jenis_ujian", "required");$this->form_validation->set_rules("tgl_ujian", "tgl_ujian", "required");$this->form_validation->set_rules("tgl_input", "tgl_input", "required");$this->form_validation->set_rules("guru", "guru", "required");$this->form_validation->set_rules("mapel", "mapel", "required");$this->form_validation->set_rules("kelas", "kelas", "required");$this->form_validation->set_rules("status", "status", "required");$this->form_validation->set_rules("token", "token", "required");
				if($this->form_validation->run() == true){
					$this->crud_function_model->updateData("ujian", $arrayPost, "id_ujian = '$id'");
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
					"tampilData" => $this->crud_function_model->readData("ujian", "", "id_ujian like '%$_GET[id]%'  || nama_ujian like '%$_GET[id]%' || jenis_ujian like '%$_GET[id]%' || tgl_ujian like '%$_GET[id]%' || tgl_input like '%$_GET[id]%' || guru like '%$_GET[id]%' || mapel like '%$_GET[id]%' || kelas like '%$_GET[id]%' || status like '%$_GET[id]%' || token like '%$_GET[id]%' ", "id_ujian desc"),
					"idDb" => "id_ujian"
				);
				$this->load->view("admin/content/ujian/table", $queryDataRead);
			}// end search
		}// end else // pertama
	}
}
			