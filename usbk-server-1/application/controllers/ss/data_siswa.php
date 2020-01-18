<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class data_siswa extends CI_Controller {
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
				"nama_lengkap" => $this->input->post("nama_lengkap"),"jenis_kelamin" => $this->input->post("jenis_kelamin"),"NISN" => $this->input->post("NISN"),"NIK" => $this->input->post("NIK"),"ttl" => $this->input->post("ttl"),"agama" => $this->input->post("agama"),"alamat" => $this->input->post("alamat"),"transportasi" => $this->input->post("transportasi"),"jenis_tinggal" => $this->input->post("jenis_tinggal"),"tlp" => $this->input->post("tlp"),"email" => $this->input->post("email"),"nama_ayah" => $this->input->post("nama_ayah"),"pekerjaan_ayah" => $this->input->post("pekerjaan_ayah"),"nama_ibu" => $this->input->post("nama_ibu"),"pekerjaan_ibu" => $this->input->post("pekerjaan_ibu"),"nama_wali" => $this->input->post("nama_wali"),"pekerjaan_wali" => $this->input->post("pekerjaan_wali"),
				);
				$this->form_validation->set_rules("nama_lengkap", "nama_lengkap", "required");
				$this->form_validation->set_rules("jenis_kelamin", "jenis_kelamin", "required");
				$this->form_validation->set_rules("NISN", "NISN", "required");
				$this->form_validation->set_rules("NIK", "NIK", "required");
				$this->form_validation->set_rules("ttl", "ttl", "required");
				$this->form_validation->set_rules("agama", "agama", "required");
				$this->form_validation->set_rules("alamat", "alamat", "required");
				$this->form_validation->set_rules("transportasi", "transportasi", "required");
				$this->form_validation->set_rules("jenis_tinggal", "jenis_tinggal", "required");
				//$this->form_validation->set_rules("tlp", "tlp", "required");
				//$this->form_validation->set_rules("email", "email", "required");
				$this->form_validation->set_rules("nama_ayah", "nama_ayah", "required");
				$this->form_validation->set_rules("pekerjaan_ayah", "pekerjaan_ayah", "required");
				$this->form_validation->set_rules("nama_ibu", "nama_ibu", "required");
				$this->form_validation->set_rules("pekerjaan_ibu", "pekerjaan_ibu", "required");
				// $this->form_validation->set_rules("nama_wali", "nama_wali", "required");
				// $this->form_validation->set_rules("pekerjaan_wali", "pekerjaan_wali", "required");
				if($this->form_validation->run() == true){
					$this->crud_function_model->insertData("data_siswa", $arrayPost);
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
					"tampilData" => $this->crud_function_model->readData("data_siswa", "", "", "nama_lengkap asc"),
					"idDb" => "id_data_siswa"
				);
				$this->load->view("admin/content/data_siswa/table", $queryDataRead);
			} // end load
			else if($_GET["act"] == "transportasi"){
				$id = 
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("transport", "", "", "nama_transportasi desc"),
				);
				echo "<select name='transportasi' class='form-control' style='width:50%; float:left;'>";
				echo "<option value=''>Transportasi</option>";
				foreach($queryDataRead["tampilData"] as $item){
					echo "
						<option value='$item[id_transport]'>$item[nama_transportasi]</option>
					";
				}
				echo "</select>";
 				
			} // end jenis_tinggal
			else if($_GET["act"] == "pekerjaanAyah"){
				$id = 
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("pekerjaan", "", "", ""),
				);
				echo "<select name='pekerjaan_ayah' class='form-control' style='width:50%; float:left;'>";
				echo "<option value=''>Pekerjaan</option>";
				foreach($queryDataRead["tampilData"] as $item){
					echo "
						<option value='$item[id_pekerjaan]'>$item[nama_pekerjaan]</option>
					";
				}
				echo "</select>";
 				
			} // end pekerjaanAyah
			else if($_GET["act"] == "pekerjaanIbu"){
				$id = 
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("pekerjaan", "", "", ""),
				);
				echo "<select name='pekerjaan_ibu' class='form-control' style='width:50%; float:left;'>";
				echo "<option value=''>Pekerjaan</option>";
				foreach($queryDataRead["tampilData"] as $item){
					echo "
						<option value='$item[id_pekerjaan]'>$item[nama_pekerjaan]</option>
					";
				}
				echo "</select>";
 				
			} // end pekerjaanIbu
			else if($_GET["act"] == "pekerjaanWali"){
				$id = 
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("pekerjaan", "", "", ""),
				);
				echo "<select name='pekerjaan_wali' class='form-control' style='width:50%; float:left;'>";
				echo "<option value=''>Pekerjaan</option>";
				foreach($queryDataRead["tampilData"] as $item){
					echo "
						<option value='$item[id_pekerjaan]'>$item[nama_pekerjaan]</option>
					";
				}
				echo "</select>";
 				
			} // end pekerjaanWali
			else if($_GET["act"] == "jenisTinggal"){
				$id = 
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("jenis_tinggal", "", "", ""),
				);
				echo "<select name='jenis_tinggal' class='form-control' style='width:90%; margin:10px auto;'>";
				echo "<option value=''>Jenis Tinggal</option>";
				foreach($queryDataRead["tampilData"] as $item){
					echo "
						<option value='$item[id_jenis_tinggal]'>$item[nama_jenis_tinggal]</option>
					";
				}
				echo "</select>";
 				
			} // end pekerjaanWali
			else if($_GET["act"] == "delete"){
				
				$this->crud_function_model->deleteData("data_siswa", "id_data_siswa = $_GET[id]");
			} // end delete	
			else if($_GET["act"] == "view"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("data_siswa", "", "id_data_siswa = $_GET[id]", "id_data_siswa desc"),
					"idDb" => "id_data_siswa"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
					
						<tr>
							<td>nama_lengkap</td>
							<td>"; echo $item["nama_lengkap"]; echo "</td>
						</tr>
						
						<tr>
							<td>jenis_kelamin</td>
							<td>"; echo $item["jenis_kelamin"]; echo "</td>
						</tr>
						
						<tr>
							<td>NISN</td>
							<td>"; echo $item["NISN"]; echo "</td>
						</tr>
						
						<tr>
							<td>NIK</td>
							<td>"; echo $item["NIK"]; echo "</td>
						</tr>
						
						<tr>
							<td>ttl</td>
							<td>"; echo $item["ttl"]; echo "</td>
						</tr>
						
						<tr>
							<td>agama</td>
							<td>"; echo $item["agama"]; echo "</td>
						</tr>
						
						<tr>
							<td>alamat</td>
							<td>"; echo $item["alamat"]; echo "</td>
						</tr>
						
						<tr>
							<td>transportasi</td>
							<td>"; echo $item["transportasi"]; echo "</td>
						</tr>
						
						<tr>
							<td>jenis_tinggal</td>
							<td>"; echo $item["jenis_tinggal"]; echo "</td>
						</tr>
						
						<tr>
							<td>tlp</td>
							<td>"; echo $item["tlp"]; echo "</td>
						</tr>
						
						<tr>
							<td>email</td>
							<td>"; echo $item["email"]; echo "</td>
						</tr>
						
						<tr>
							<td>nama_ayah</td>
							<td>"; echo $item["nama_ayah"]; echo "</td>
						</tr>
						
						<tr>
							<td>pekerjaan_ayah</td>
							<td>"; echo $item["pekerjaan_ayah"]; echo "</td>
						</tr>
						
						<tr>
							<td>nama_ibu</td>
							<td>"; echo $item["nama_ibu"]; echo "</td>
						</tr>
						
						<tr>
							<td>pekerjaan_ibu</td>
							<td>"; echo $item["pekerjaan_ibu"]; echo "</td>
						</tr>
						
						<tr>
							<td>nama_wali</td>
							<td>"; echo $item["nama_wali"]; echo "</td>
						</tr>
						
						<tr>
							<td>pekerjaan_wali</td>
							<td>"; echo $item["pekerjaan_wali"]; echo "</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view
			else if($_GET["act"] == "viewEdit"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("data_siswa", "", "id_data_siswa = $_GET[id]", "id_data_siswa desc"),
					"idDb" => "id_data_siswa"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
						<tr>
							<input type='hidden' name='id' class='form-control' style='width:100%;' value='"; echo $item["id_data_siswa"]; echo "' hidden>
						
							<td>nama_lengkap</td>
							<td>
							
									<input type='text' name='nama_lengkap' class='form-control' style='width:100%;' value='"; echo $item["nama_lengkap"]; echo "' >
								
							</td>
						</tr>
						
							<td>jenis_kelamin</td>
							<td>
							<select class=form-control name=jenis_kelamin id=jenis_kelamin style=width:50%; float:left;>
								<option value=''>Jenis Kelamin</option>
								<option value='1'>Laki-Laki</option>
								<option value='2'>Perempuan</option>
							</select>
							</td>
						</tr>
						
							<td>NISN</td>
							<td>
							
									<input type='text' name='NISN' class='form-control' style='width:100%;' value='"; echo $item["NISN"]; echo "' >
								
							</td>
						</tr>
						
							<td>NIK</td>
							<td>
							
									<input type='text' name='NIK' class='form-control' style='width:100%;' value='"; echo $item["NIK"]; echo "' >
								
							</td>
						</tr>
						
							<td>ttl</td>
							<td>
							
									<input type='text' name='ttl' class='form-control' style='width:100%;' value='"; echo $item["ttl"]; echo "' >
								
							</td>
						</tr>
						
							<td>agama</td>
							<td>
							
									<input type='text' name='agama' class='form-control' style='width:100%;' value='"; echo $item["agama"]; echo "' readonly>
								
							</td>
						</tr>
						
							<td>alamat</td>
							<td>
							
									<input type='text' name='alamat' class='form-control' style='width:100%;' value='"; echo $item["alamat"]; echo "' >
								
							</td>
						</tr>
						
							<td>transportasi</td>
							<td>
							
									<input type='text' name='transportasi' class='form-control' style='width:100%;' value='"; echo $item["transportasi"]; echo "' >
								
							</td>
						</tr>
						
							<td>jenis_tinggal</td>
							<td>
							
									<input type='text' name='jenis_tinggal' class='form-control' style='width:100%;' value='"; echo $item["jenis_tinggal"]; echo "' >
								
							</td>
						</tr>
						
							<td>tlp</td>
							<td>
							
									<input type='text' name='tlp' class='form-control' style='width:100%;' value='"; echo $item["tlp"]; echo "' >
								
							</td>
						</tr>
						
							<td>email</td>
							<td>
							
									<input type='text' name='email' class='form-control' style='width:100%;' value='"; echo $item["email"]; echo "' >
								
							</td>
						</tr>
						
							<td>nama_ayah</td>
							<td>
							
									<input type='text' name='nama_ayah' class='form-control' style='width:100%;' value='"; echo $item["nama_ayah"]; echo "' >
								
							</td>
						</tr>
						
							<td>pekerjaan_ayah</td>
							<td>
							
									<input type='text' name='pekerjaan_ayah' class='form-control' style='width:100%;' value='"; echo $item["pekerjaan_ayah"]; echo "' >
								
							</td>
						</tr>
						
							<td>nama_ibu</td>
							<td>
							
									<input type='text' name='nama_ibu' class='form-control' style='width:100%;' value='"; echo $item["nama_ibu"]; echo "' >
								
							</td>
						</tr>
						
							<td>pekerjaan_ibu</td>
							<td>
							
									<input type='text' name='pekerjaan_ibu' class='form-control' style='width:100%;' value='"; echo $item["pekerjaan_ibu"]; echo "' >
								
							</td>
						</tr>
						
							<td>nama_wali</td>
							<td>
							
									<input type='text' name='nama_wali' class='form-control' style='width:100%;' value='"; echo $item["nama_wali"]; echo "' >
								
							</td>
						</tr>
						
							<td>pekerjaan_wali</td>
							<td>
							
									<input type='text' name='pekerjaan_wali' class='form-control' style='width:100%;' value='"; echo $item["pekerjaan_wali"]; echo "' >
								
							</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view edit
			else if($_GET["act"] == "update"){
				
				$id = $this->input->post("id");
				$arrayPost = array(
				"nama_lengkap" => $this->input->post("nama_lengkap"),"jenis_kelamin" => $this->input->post("jenis_kelamin"),"NISN" => $this->input->post("NISN"),"NIK" => $this->input->post("NIK"),"ttl" => $this->input->post("ttl"),"agama" => $this->input->post("agama"),"alamat" => $this->input->post("alamat"),"transportasi" => $this->input->post("transportasi"),"jenis_tinggal" => $this->input->post("jenis_tinggal"),"tlp" => $this->input->post("tlp"),"email" => $this->input->post("email"),"nama_ayah" => $this->input->post("nama_ayah"),"pekerjaan_ayah" => $this->input->post("pekerjaan_ayah"),"nama_ibu" => $this->input->post("nama_ibu"),"pekerjaan_ibu" => $this->input->post("pekerjaan_ibu"),"nama_wali" => $this->input->post("nama_wali"),"pekerjaan_wali" => $this->input->post("pekerjaan_wali"),
				);
				$this->form_validation->set_rules("nama_lengkap", "nama_lengkap", "required");$this->form_validation->set_rules("jenis_kelamin", "jenis_kelamin", "required");$this->form_validation->set_rules("NISN", "NISN", "required");$this->form_validation->set_rules("NIK", "NIK", "required");$this->form_validation->set_rules("ttl", "ttl", "required");$this->form_validation->set_rules("agama", "agama", "required");$this->form_validation->set_rules("alamat", "alamat", "required");$this->form_validation->set_rules("transportasi", "transportasi", "required");$this->form_validation->set_rules("jenis_tinggal", "jenis_tinggal", "required");$this->form_validation->set_rules("tlp", "tlp", "required");$this->form_validation->set_rules("email", "email", "required");$this->form_validation->set_rules("nama_ayah", "nama_ayah", "required");$this->form_validation->set_rules("pekerjaan_ayah", "pekerjaan_ayah", "required");$this->form_validation->set_rules("nama_ibu", "nama_ibu", "required");$this->form_validation->set_rules("pekerjaan_ibu", "pekerjaan_ibu", "required");$this->form_validation->set_rules("nama_wali", "nama_wali", "required");$this->form_validation->set_rules("pekerjaan_wali", "pekerjaan_wali", "required");
				if($this->form_validation->run() == true){
					$this->crud_function_model->updateData("data_siswa", $arrayPost, "id_data_siswa = '$id'");
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
					"tampilData" => $this->crud_function_model->readData("data_siswa", "", "id_data_siswa like '%$_GET[id]%'  || nama_lengkap like '%$_GET[id]%' || jenis_kelamin like '%$_GET[id]%' || NISN like '%$_GET[id]%' || NIK like '%$_GET[id]%' || ttl like '%$_GET[id]%' || agama like '%$_GET[id]%' || alamat like '%$_GET[id]%' || transportasi like '%$_GET[id]%' || jenis_tinggal like '%$_GET[id]%' || tlp like '%$_GET[id]%' || email like '%$_GET[id]%' || nama_ayah like '%$_GET[id]%' || pekerjaan_ayah like '%$_GET[id]%' || nama_ibu like '%$_GET[id]%' || pekerjaan_ibu like '%$_GET[id]%' || nama_wali like '%$_GET[id]%' || pekerjaan_wali like '%$_GET[id]%' ", "id_data_siswa desc"),
					"idDb" => "id_data_siswa"
				);
				$this->load->view("admin/content/data_siswa/table", $queryDataRead);
			}// end search
		}// end else // pertama
	}
}
			