<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Link extends CI_Controller {

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
		if(empty($_GET)){
		} else {
			if($_GET['dashboard'] == 'dashboard'){
				if($_SESSION['status'] == "admin"){
					$this->load->view('admin/content/user/depan');
				} else if($_SESSION['status'] == "siswa") {
					$this->load->view('admin/content/jawab_soal/depan');
				}
			} 
			else if($_GET['dashboard'] == 'user'){
				$this->load->view('admin/content/user/depan');
			}
			else if($_GET['dashboard'] == 'setting'){
				$queryDataRead = array(
					"postAction" => $this->input->post('for'),
					"jumlah" => $this->input->post('jumlah')
				);
				$this->load->view('admin/content/setting/depan', $queryDataRead);
			}
			else if($_GET['dashboard'] == 'gambar'){
				$this->load->view('admin/content/gambar/depan');
			}
			else if($_GET['dashboard'] == 'pekerjaan'){
				$this->load->view('admin/content/pekerjaan/depan');
			}
			else if($_GET['dashboard'] == 'jenis_pegawai'){
				$this->load->view('admin/content/jenis_pegawai/depan');
			}
			else if($_GET['dashboard'] == 'transport'){
				$this->load->view('admin/content/transport/depan');
			}
			else if($_GET['dashboard'] == 'jenis_tinggal'){
				$this->load->view('admin/content/jenis_tinggal/depan');
			}
			else if($_GET['dashboard'] == 'data_siswa'){
				$this->load->view('admin/content/data_siswa/depan');
			}
			else if($_GET['dashboard'] == 'data_kelas'){
				$this->load->view('admin/content/data_kelas/depan');
			}
			else if($_GET['dashboard'] == 'mapel'){
				$this->load->view('admin/content/mapel/depan');
			}
			else if($_GET['dashboard'] == 'ujian'){
				$this->load->view('admin/content/ujian/depan');
			}
			else if($_GET['dashboard'] == 'data_sekolah'){
				$this->load->view('admin/content/data_sekolah/depan');
			}
			else if($_GET['dashboard'] == 'data_pegawai'){
				$this->load->view('admin/content/data_pegawai/depan');
			}
			else if($_GET['dashboard'] == 'soal'){
				$this->load->view('admin/content/soal/depan');
			}
			else if($_GET['dashboard'] == 'status_login_siswa'){
				$this->load->view('admin/content/status_login_siswa/depan');
			}
			else if($_GET['dashboard'] == 'jawaban_soal_siswa'){
				$this->load->view('admin/content/jawaban_soal_siswa/depan');
			}
			else if($_GET['dashboard'] == 'jawab_soal'){
				$this->load->view('admin/content/jawab_soal/depan');
			}
			else if($_GET['dashboard'] == 'jumlah_soal_ujian'){
				$this->load->view('admin/content/jumlah_soal_ujian/depan');
			}
		}
	}
}