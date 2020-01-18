<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper("file");
		$this->load->model("crud_function_model");
		if(empty($_SESSION['username'])){
			redirect('login');
		} else {
				echo "
					<link rel='stylesheet' href='http://localhost/api/bootstrap/bootstrap.min.css'>
					<script src='http://localhost/api/bootstrap/1.12.0_jquery.min.js'></script>
					<script src='http://localhost/api/bootstrap/bootstrap.min.js'></script>
				";
		}
	}
	public function index(){}
	public function set(){
		$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("user", "", "", ""),
					"postAction" => $this->input->post('for'),
					"jumlah" => $this->input->post('jumlah'),
					"db" => $this->input->post('dbName')
				);
		
		if($_GET['pR'] == 2){
		//bikin folder dengan nama tabel di database
		// dan bikin file.php		
		$dirF = $this->input->post("dbName");
		dir('./application/views/admin/content/'.$dirF.'/');
		write_file("./application/controllers/".$dirF.".php", "// untuk controller nya");
		mkdir('./application/views/admin/content/'.$dirF.'/');
		
		write_file("./application/views/admin/content/".$dirF."/depan.php", "// di sini untuk depan");
		write_file("./application/views/admin/content/".$dirF."/table.php", "// di sini untuk tabel");
		
			echo "<a href='../dashboard?dashboard=setting'>back</a><br /><br />";
			echo '<div style="border:1px solid #000; background:#e5e5e5; padding:10px;">kita buat dulu 3 file / 1 file di controller dan 2 file di view ( di dalm folder view )';
			echo '<br />controller/';echo $this->input->post("dbName");
			echo '<br />admin/content/';echo $this->input->post("dbName"); echo '/depan';
			echo '<br />admin/content/';echo $this->input->post("dbName"); echo '/table</div><br /><br />';
			echo "<div style='border:1px solid #000; background:#e5e5e5; padding:10px;'>database nya</div>";
			echo '<textarea style="margin:10px; width:98%; height:100px;border:2px solid #000;">
CREATE TABLE `';echo $this->input->post("dbName"); echo '` (
`id_';echo $this->input->post("dbName"); echo '` INT NULL AUTO_INCREMENT,
';for($i = 0; $i < $queryDataRead['jumlah']; $i++){
	echo '`'; echo $this->input->post($i); echo '` ';
	if($this->input->post("type-".$i) == "VARCHAR"){
		echo 'VARCHAR('; echo $this->input->post("length-".$i);echo ') NULL, ';
	} else {
		echo $this->input->post("type-".$i).' NULL, ';
	}
}echo 'INDEX `Index 1` (`id_';echo $this->input->post("dbName"); echo '`))COLLATE=\'latin1_swedish_ci\'ENGINE=InnoDB;
			</textarea>';
			echo "<div style='border:1px solid #000; background:#e5e5e5; padding:10px;'>ini di letakkan di controller/link.php untuk kemudian link mengaraha ke sini
			<br /><br />
			../..?dashboard=";echo $this->input->post("dbName"); echo "
			</div>";
			echo '<textarea style="margin:10px; width:98%; height:100px;border:2px solid #000;">
else if($_GET[\'dashboard\'] == \'';echo $this->input->post("dbName"); echo '\'){
	$this->load->view(\'admin/content/';echo $this->input->post("dbName"); echo '/depan\');
}
			</textarea>';
			echo 'ini leyakkan di header.php / page / ';
			echo '<textarea style="margin:10px; width:98%; height:100px;border:2px solid #000;">
$("#';echo $this->input->post("dbName"); echo '").click(function(){
	localStorage.setItem("link" , "link?dashboard=';echo $this->input->post("dbName"); echo '");
	$(".body-load-all").load("link?dashboard=';echo $this->input->post("dbName"); echo '");
});
			</textarea>';
			echo "<div style='border:1px solid #000; background:#e5e5e5; padding:10px;'>ini di letakkan yang akan di load</div>";
			echo '<textarea style="margin:10px; width:98%; height:300px;border:2px solid #000;">
<?php
defined(\'BASEPATH\') OR exit(\'No direct script access allowed\');

class ';echo $this->input->post("dbName"); echo ' extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model("crud_function_model");
		if(empty($_SESSION[\'username\'])){
			redirect(\'login\');
		} else {	
		}
	}
	public function index(){
	}
	public function load(){
		if(empty($_GET["act"])){
							
		} else {
			if($_GET["act"] == "insert"){
			';
			for($i = 0; $i < $queryDataRead['jumlah']; $i++){
				if($this->input->post("type-form-".$i) == "file"){
					$a[] = "1";
					$text[] = "0";
					$namaTable = $this->input->post($i);
				} else {
					$a[] =  "0";
					$text[] = "1";
					$namaTable = "";
				}	
			}
			// mengambil logika jika lebih besar dari 0 maka akan memakai ajax upload file
			// jika sebalik nya maka akan memakai ajak input text
			if(implode($a) > 1000000000000){
				// file
				echo '
					// mulai
					$config["file_name"]          = "smk-nurul-mannan-.jpg";
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
						';
							for($i = 0; $i < $queryDataRead['jumlah']; $i++){
								if($this->input->post("type-form-".$i) == "file"){
									echo '"'; echo $this->input->post($i); echo '" => $this->upload->data("file_name"), ';
								} else {
									 echo '"'; echo $this->input->post($i); echo '" => $this->input->post("'; echo $this->input->post($i); echo '"), ';
								}	
							}
							echo '
						);
						';
						// nyampek sini dulu insyaAllah lajutin besok
						for($i = 0; $i < $queryDataRead['jumlah']; $i++){
							if($this->input->post("type-form-".$i) == "file"){
							} else {
								echo '$this->form_validation->set_rules("'; echo $this->input->post($i); echo '", "'; echo $this->input->post($i); echo '", "required");';
							}
						}
						if(implode($text) > 0){
							$pes = "1";
							$headValidation =  '
						if($this->form_validation->run() == true){';
							$footerValidation = '
						} else {
							$message =  array(
								"message" => validation_errors()
							);
						}
							';
						}else {
							$footerValidation = '';
							$headValidation =  '';
							$pes = "0";
						}
						echo $headValidation;
						echo '
							$this->crud_function_model->insertData("';echo $this->input->post("dbName"); echo '", $arrayPost);
							$message =  array(
							"message" => "Data Berhasil Di Simpan"
							);
							'; echo $footerValidation; echo '
						// end 
						$this->load->view("admin/valids/validationmessage", $message);
					}					
			';
			} else {
				echo '
				$arrayPost = array(
				';
					for($i = 0; $i < $queryDataRead['jumlah']; $i++){
						 echo '"'; echo $this->input->post($i); echo '" => $this->input->post("'; echo $this->input->post($i); echo '"),';
								
						}
					echo '
				);
				';
					for($i = 0; $i < $queryDataRead['jumlah']; $i++){
						echo '$this->form_validation->set_rules("'; echo $this->input->post($i); echo '", "'; echo $this->input->post($i); echo '", "required");';
					}
				echo '
				if($this->form_validation->run() == true){
					$this->crud_function_model->insertData("';echo $this->input->post("dbName"); echo '", $arrayPost);
					$message =  array(
					"message" => "Data Berhasil Di Simpan"
					);
				} else {
					$message =  array(
					"message" => validation_errors()
					);
				}
				$this->load->view("admin/valids/validationmessage", $message);
			'; } echo '
			} // end insert
			
			else if($_GET["act"] == "load"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("';echo $this->input->post("dbName"); echo '", "", "", "id_';echo $this->input->post("dbName"); echo ' desc"),
					"idDb" => "id_';echo $this->input->post("dbName"); echo '"
				);
				$this->load->view("admin/content/';echo $this->input->post("dbName"); echo '/table", $queryDataRead);
			} // end load
			else if($_GET["act"] == "delete"){
				
				$this->crud_function_model->deleteData("';echo $this->input->post("dbName"); echo '", "id_';echo $this->input->post("dbName"); echo ' = $_GET[id]");
			} // end delete	
			else if($_GET["act"] == "view"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("';echo $this->input->post("dbName"); echo '", "", "id_';echo $this->input->post("dbName"); echo ' = $_GET[id]", "id_';echo $this->input->post("dbName"); echo ' desc"),
					"idDb" => "id_';echo $this->input->post("dbName"); echo '"
				);	
				echo "<table class=\'table\'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
					';
					for($i = 0; $i < $queryDataRead['jumlah']; $i++){
					echo '
						<tr>
							<td>'; echo $this->input->post($i); echo '</td>
							<td>"; echo $item["'; echo $this->input->post($i); echo '"]; echo "</td>
						</tr>
						';
					}
						echo '
					"; 
				}
				echo "</table>";
			} // end view
			else if($_GET["act"] == "viewEdit"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("';echo $this->input->post("dbName"); echo '", "", "id_';echo $this->input->post("dbName"); echo ' = $_GET[id]", "id_';echo $this->input->post("dbName"); echo ' desc"),
					"idDb" => "id_';echo $this->input->post("dbName"); echo '"
				);	
				echo "<table class=\'table\'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
						<tr>
							<input type=\'hidden\' name=\'id\' class=\'form-control\' style=\'width:100%;\' value=\'"; echo $item["id_';echo $this->input->post("dbName"); echo '"]; echo "\' hidden>
						';
					for($i = 0; $i < $queryDataRead['jumlah']; $i++){
					echo '
							<td>'; echo $this->input->post($i); echo '</td>
							<td>
							';
							if(empty($this->input->post("type-form-".$i))){
								echo '
								<input type=\'text\' name=\''; echo $this->input->post($i); echo '\' class=\'form-control\' style=\'width:100%;\' value=\'"; echo $item["'; echo $this->input->post($i); echo '"]; echo "\' >
								';
							}else {
								echo '
									<input type=\'text\' name=\''; echo $this->input->post($i); echo '\' class=\'form-control\' style=\'width:100%;\' value=\'"; echo $item["'; echo $this->input->post($i); echo '"]; echo "\' >
								';	
							}
							echo '
							</td>
						</tr>
						';
					}
					echo '
					"; 
				}
				echo "</table>";
			} // end view edit
			else if($_GET["act"] == "update"){
				';
			for($i = 0; $i < $queryDataRead['jumlah']; $i++){
				if($this->input->post("type-form-".$i) == "file"){
					$a[] = "1";
					$text[] = "0";
					$namaTable = $this->input->post($i);
				} else {
					$a[] =  "0";
					$text[] = "1";
					$namaTable = "";
				}	
			}
			// mengambil logika jika lebih besar dari 0 maka akan memakai ajax upload file
			// jika sebalik nya maka akan memakai ajak input text
			if(implode($a) > 1000000000000000){
				// file
				echo '
					// mulai
					$config["file_name"]          = "smk-nurul-mannan-.jpg";
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
						';
							for($i = 0; $i < $queryDataRead['jumlah']; $i++){
								if($this->input->post("type-form-".$i) == "file"){
									echo '"'; echo $this->input->post($i); echo '" => $this->upload->data("file_name"), ';
								} else {
									 echo '"'; echo $this->input->post($i); echo '" => $this->input->post("'; echo $this->input->post($i); echo '"), ';
								}	
							}
							echo '
						);
						
						';
						// nyampek sini dulu insyaAllah lajutin besok
						for($i = 0; $i < $queryDataRead['jumlah']; $i++){
							if($this->input->post("type-form-".$i) == "file"){
							} else {
								echo '$this->form_validation->set_rules("'; echo $this->input->post($i); echo '", "'; echo $this->input->post($i); echo '", "required");';
							}
						}
						if(implode($text) > 0){
							$pes = "1";
							$headValidation =  '
						if($this->form_validation->run() == true){';
							$footerValidation = '
						} else {
							$message =  array(
								"message" => validation_errors()
							);
						}
							';
						}else {
							$footerValidation = '';
							$headValidation =  '';
							$pes = "0";
						}
						echo $headValidation;
						echo '
							
							$this->crud_function_model->updateData("';echo $this->input->post("dbName"); echo '", $arrayPost, "id_';echo $this->input->post("dbName"); echo ' = \'$id\'");
							$message =  array(
							"message" => "Data Berhasil Di Simpan"
							);
							'; echo $footerValidation; echo '
						// end 
						$this->load->view("admin/valids/validationmessage", $message);
					}					
			';
			} else {
				echo '
				$id = $this->input->post("id");
				$arrayPost = array(
				';
					for($i = 0; $i < $queryDataRead['jumlah']; $i++){
						 echo '"'; echo $this->input->post($i); echo '" => $this->input->post("'; echo $this->input->post($i); echo '"),';
								
						}
					echo '
				);
				';
					for($i = 0; $i < $queryDataRead['jumlah']; $i++){
						echo '$this->form_validation->set_rules("'; echo $this->input->post($i); echo '", "'; echo $this->input->post($i); echo '", "required");';
					}
				echo '
				if($this->form_validation->run() == true){
					$this->crud_function_model->updateData("';echo $this->input->post("dbName"); echo '", $arrayPost, "id_';echo $this->input->post("dbName"); echo ' = \'$id\'");
					$message =  array(
					"message" => "Data Berhasil Di Simpan"
					);
				} else {
					$message =  array(
					"message" => validation_errors()
					);
				}
				$this->load->view("admin/valids/validationmessage", $message);
			'; } echo '
			}// end update 
			else if($_GET["act"] == "search"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("';echo $this->input->post("dbName"); echo '", "", "id_';echo $this->input->post("dbName"); echo ' like \'%$_GET[id]%\' ';for($i = 0; $i < $queryDataRead['jumlah']; $i++){ echo ' || ';echo $this->input->post($i); echo ' like \'%$_GET[id]%\'';}echo ' ", "id_';echo $this->input->post("dbName"); echo ' desc"),
					"idDb" => "id_';echo $this->input->post("dbName"); echo '"
				);
				$this->load->view("admin/content/';echo $this->input->post("dbName"); echo '/table", $queryDataRead);
			}// end search
		}// end else // pertama
	}
}
			';
			echo '</textarea>';
			echo "<div style='border:1px solid #000; background:#e5e5e5; padding:10px;'>ini di letakkan di depan.php </div>";
			echo '<textarea style="margin:10px; width:98%; height:300px;border:2px solid #000;">';
			echo '
<style>
	.form-control {
		margin-bottom:5px;
	}
</style>
<script type="text/javascript">
	ajaxload();
	$(document).ready(function(){
		$(".new-data-class").click(function(){
			$("#form").show();
			$(".view-class-modal").hide();
		});
		';
		for($i = 0; $i < $queryDataRead['jumlah']; $i++){
			if($this->input->post("type-form-".$i) == "file"){
				$a[] = "1";
			} else {
				$this->input->post("type-form-".$i);
				$a[] =  "0";
			}	
		}
		// mengambil logika jika lebih besar dari 0 maka akan memakai ajax upload file
		// jika sebalik nya maka akan memakai ajak input text
		if(implode($a) > 100000000000000000){
			echo '
		$(".btn-submit-class").click(function(){
			// untuk menyimpan data
			var formData = new FormData();
			
			// ini untuk mengambil value dari input=file
			// code seperti ini sudah bisa upload foto
			';
			for($i = 0; $i < $queryDataRead['jumlah']; $i++){
				if($this->input->post("type-form-".$i) == "file"){
					// jika file maka input[name=DI SINI DI GANTI NAMA FIELD DI TABLE]
					echo 'var inputFile'; echo $i; echo ' = $("input[name=';echo $this->input->post($i); echo ']");';
					echo 'var fileToUpload = inputFile'; echo $i; echo '[0].files[0];';
					echo 'formData.append("'; echo $this->input->post($i); echo '", fileToUpload);';
				} else {
					//untuk menambahkan input text seperti contoh di bawah ini
					echo 'var '.$this->input->post($i).' = $("#'; echo $this->input->post($i); echo '").val();';
					echo 'formData.append("'; echo $this->input->post($i); echo '", '; echo $this->input->post($i); echo ');';
				}	
			}
			echo '		
				$.ajax({
					url: "';echo $this->input->post("dbName"); echo '/load?act=insert",
					type: "post",
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					success: function(data){
						$(".message-errors").html(data);
						';
						for($i = 0; $i < $queryDataRead['jumlah']; $i++){
							echo '$("#'; echo $this->input->post($i); echo '").val("");';
						}
						echo '
						ajaxload();
					}
				});
		});
			';
		} else {
			echo '
			$("#form").submit(function(){
			//jangan lupa url nya di ganti sesuai dengan link nya
			$.ajax({
				type : "POST",
				url : "';echo $this->input->post("dbName"); echo '/load?act=insert",
				data : $(this).serialize(),
				success : function(data){
					ajaxload();
					$(".message-errors").html(data);
					';
			for($i = 0; $i < $queryDataRead['jumlah']; $i++){
				 echo '$("#'; echo $this->input->post($i); echo '").val("");';
						
				}
			echo '
				}
			})
			return false;
		});
		';
		}
		echo '
		$("#form2").submit(function(){
			//jangan lupa url nya di ganti sesuai dengan link nya
			$.ajax({
				type : "POST",
				url : "';echo $this->input->post("dbName"); echo '/load?act=update",
				data : $(this).serialize(),
				success : function(data){
					ajaxload();
					$(".message-errors2").html(data);
					';
			for($i = 0; $i < $queryDataRead['jumlah']; $i++){
				 echo '$("#'; echo $this->input->post($i); echo '").val("");';	
				}
			echo '
				}
			})
			return false;
		});
		$(".class-reloaded").click(function(){
			if(confirm("load data lagi / fungsi ini seperti refres")){
				ajaxload();
			}
		});
		$(".class-upload-to-exel").click(function(){
			alert("warning !!! untuk mengupload data menggunakan exel harus sesuai tabel di bawah");
		});
		$("#search").keyup(function(){
			var id = $(this).val();
			//jangan lupa url nya di ganti sesuai dengan link nya
			$.ajax({
				type : "POST",
				url : "';echo $this->input->post("dbName"); echo '/load?act=search&id=" + id,
				data : $(this).serialize(),
				success : function(data){
					$("#displaydata").html(data);
				}
			})
		});
	});
	function ajaxload(){
		//jangan lupa url nya di ganti sesuai dengan link nya
		$.ajax({
			type : "POST",
			url : "';echo $this->input->post("dbName"); echo '/load?&act=load",
			data : $(this).serialize(),
			success : function(data){
				$("#displaydata").html(data);
			}
		})
	}
</script>
<div class="container"> 
	<button type="button" class="btn btn-info new-data-class" data-toggle="modal" data-target="#myModal">New Data</button>
	<button type="button" class="btn btn-success class-reloaded">Reloaded</button>
	<button type="button" class="btn btn-primary class-upload-to-exel">Upload to exel</button>
	<hr />
	<input type="text" class="form-control" id="search" style="float:none; width:100%;" placeholder="Cari......">
	<hr />
	<div class="modal fade" id="myModal" role="dialog" style="overflow:scroll;">
		<div class="modal-dialog">
		
			<div class="modal-content">
				';
				if(implode($a) > 0){
					echo '<?php echo form_open_multipart("upload/do_upload", "id=\'form\'");?>';
				}else {
					echo '<form  method="POST" action="#" id="form" name="form1" >';
				} 
				echo '
					<div class="message-errors"></div>
					<div class="modal-body">
						';
						for($i = 0; $i < $queryDataRead['jumlah']; $i++){
							if(empty($this->input->post("type-form-".$i))){
								echo '<input type="text" class="form-control" name="'; echo $this->input->post($i); echo '" id="'; echo $this->input->post($i); echo '" placeholder="'; echo $this->input->post($i); echo '" >';
							} else {
								if($this->input->post("type-form-".$i)){
									echo '<input type="text" class="form-control" name="'; echo $this->input->post($i); echo '" id="'; echo $this->input->post($i); echo '" placeholder="'; echo $this->input->post($i); echo '" >';
								}
							}
							
						}
							echo '				
					</div>
					<div class="modal-footer" style="background:#99bbff; margin-top:20px; border-radius:0px 0px 5px 5px;">
						<button type="'; 
						if(implode($a) > 0){echo 'button';}else {echo 'submit';}
						echo '" class="btn btn-primary btn-submit-class" >Simpan</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</div>
				</form>
				<div class="view-class-modal">
				';
				if(implode($a) > 0){
					echo '<?php echo form_open_multipart("upload/do_upload", "id=\'form2\'");?>';
				}else {
					echo '<form  method="POST" action="#" id="form2" name="form1" >';
				} 
				echo '
				<div class="message-errors2"></div>
					<div class="modal-body">
						<div class="table-view-class"></div>
					</div>
					<div class="modal-footer " style="background:#99bbff; border-radius:0px 0px 5px 5px;">
						<button type="submit" class="btn btn-primary btn-view-edit" >Simpan</button>
						<button type="button" class="btn btn-default btn-view-edit" data-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-danger btn-view-close" data-dismiss="modal">Close</button>
					</div>
				</div>
				</form>
			</div>

		</div>
	</div>

	<div class="table-responsive">          
		<div id="displaydata"></div>
	</div>
</div>
					
					</textarea>';
					
		echo '
		<div style="border:1px solid #000; background:#e5e5e5; padding:10px;">ini di letakkan di table.php</div>
		<textarea style="margin:10px; width:98%; height:300px;border:2px solid #000;">
<script type="text/javascript">
$(document).ready(function(){
	$(".delete-class").click(function(){
		var element = $(this);
		var id = element.attr("id");
		if(confirm("Yakin Mau Di Hapus")){
			//ajax proses delete
			//jangan lupa url nya di ganti sesuai dengan link nya
			$.ajax({
				type : "POST",
				url : "';echo $this->input->post("dbName"); echo '/load?act=delete&id=" + id,
				data : $(this).serialize(),
				success : function(data){
					ajaxload();
				}
			})
		}
	});
	$(".view-class").click(function(){
		var element = $(this);
		var id = element.attr("id");
		//jangan lupa url nya di ganti sesuai dengan link nya
		$.ajax({
				type : "POST",
				url : "';echo $this->input->post("dbName"); echo '/load?act=view&id=" + id,
				data : $(this).serialize(),
				success : function(data){
					$("#form").hide();
					$(".view-class-modal").show();
					$(".btn-view-close").show();
					$(".btn-view-edit").hide();
					$(".message-errors2").hide();
					$(".table-view-class").html(data);
				}
			})
	});
	$(".edit-class").click(function(){
		var element = $(this);
		var id = element.attr("id");
		//jangan lupa url nya di ganti sesuai dengan link nya
		$.ajax({
				type : "POST",
				url : "';echo $this->input->post("dbName"); echo '/load?act=viewEdit&id=" + id,
				data : $(this).serialize(),
				success : function(data){
					$("#form").hide();
					$(".view-class-modal").show();
					$(".btn-view-close").hide();
					$(".btn-view-edit").show();
					$(".message-errors2").show();
					$(".table-view-class").html(data);
				}
			})
	});
});
</script>
	<table class="table">
		<thead>
		  <tr>
			';for($i = 0; $i < $queryDataRead['jumlah']; $i++){
				echo '<th>'; echo $this->input->post($i); echo '</th>';		
			}echo '
			<th>action</th>
		  </tr>
		</thead>
		<tbody>
			';echo '<?php foreach($tampilData as $item){ ?>
			<tr>';for($i = 0; $i < $queryDataRead['jumlah']; $i++){echo '
				<td>
				';
				if(empty($this->input->post("type-form-".$i))){
					echo '<img src="../uploads/<?php echo "$item['; echo $this->input->post($i); echo ']"; ?>" style="width:30px; height:30px; border-radius:50%;" />';
				} else {
					echo '<?php echo "$item['; echo $this->input->post($i); echo ']"; ?>';
				}
				echo '
				</td>';}
				echo '
				<td>
					<button type="button" class="btn btn-success view-class" id="<?php echo $item["$idDb"]; ?>" data-toggle="modal" data-target="#myModal">View</button>
					<button type="button" class="btn btn-primary edit-class" id="<?php echo $item["$idDb"]; ?>" data-toggle="modal" data-target="#myModal">Edit</button>
					<button type="button" class="btn btn-danger delete-class" id="<?php echo $item["$idDb"]; ?>">Delete</button>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	  </table>
		</textarea>';
		} else if($_GET['pR'] == 1) {
			echo '<div class="container"> ';
			$this->load->view('admin/content/setting/depan', $queryDataRead);
		}
	}
}