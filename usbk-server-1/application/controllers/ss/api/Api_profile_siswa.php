<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_profile_siswa extends CI_Controller {

	public function __construct(){
		
		parent:: __construct();
		$this->load->database();
		// ini untuk crud automatic
		$this->load->model("crud_function_model");
		// ini untuk crud manually
		$this->load->model("Function_model_manually");
		$response = array();
		
	}
	public function index(){
		$response = array();
		
		if(empty($this->input->post("NISN")) && empty($this->input->post("NIK"))){
			echo "Empty page";
		} else {
			$where = array(
				"NISN" => $this->input->post("NISN"),
				"NIK" => $this->input->post("NIK")
			);
			
			$queryLihatData = $this->crud_function_model->readData("data_siswa", "", $where, "");
			$profile = array();
			foreach($queryLihatData as $item);
				
				$profile["nama_lengkap"] = $item["nama_lengkap"];
				if($item["jenis_kelamin"] == "1"){
					$profile["jenis_kelamin"] = "Laki-laki";
				} else if($item["jenis_kelamin"] == "2") {
					$profile["jenis_kelamin"] = "Perempuan";
				} else {
					$profile["jenis_kelamin"] = "Laki-laki";
				}
				$profile["NISN"] = $item["NISN"];
				$profile["NIK"] = $item["NIK"];
				$profile["ttl"] = $item["ttl"];
				if($item["agama"] == "1"){
					$profile["agama"] = "Islam";
				}else {
					$profile["agama"] = "Islam";
				}
				$profile["alamat"] = $item["alamat"];
				if($item["transportasi"] == "2"){
					$profile["transportasi"] = "Sepeda";
				} else if($item["transportasi"] == "3"){
					$profile["transportasi"] = "Sepeda Motor";
				} else if($item["transportasi"] == "4"){
					$profile["transportasi"] = "Jalan Kaki";
				} else {
					$profile["transportasi"] = "Sepeda";
				}
				if($item["jenis_tinggal"] == "3"){
					$profile["jenis_tinggal"] = "Orang Tua";
				} else if($item["jenis_tinggal"] == "4"){
					$profile["jenis_tinggal"] = "Wali";
				} else if($item["jenis_tinggal"] == "5"){
					$profile["jenis_tinggal"] = "Asrama";
				} else if($item["jenis_tinggal"] == "6"){
					$profile["jenis_tinggal"] = "Kost";
				} else if($item["jenis_tinggal"] == "7"){
					$profile["jenis_tinggal"] = "Panti Asuhan";
				} else if($item["jenis_tinggal"] == "8"){
					$profile["jenis_tinggal"] = "Lainnya / Pesantren";
				} else {
					$profile["jenis_tinggal"] = "Orang Tua";
				}
				
				$profile["tlp"] = $item["tlp"];
				$profile["email"] = $item["email"];
				$profile["nama_ayah"] = $item["nama_ayah"];
				if($item["pekerjaan_ayah"] == "2"){
					$profile["pekerjaan_ayah"] = "Petani";
				} else if($item["pekerjaan_ayah"] == "3"){
					$profile["pekerjaan_ayah"] = "Nelayan";
				} else if($item["pekerjaan_ayah"] == "4"){
					$profile["pekerjaan_ayah"] = "Wiraswata";
				} else {
					$profile["pekerjaan_ayah"] = "Petani";
				}
				
				$profile["nama_ibu"] = $item["nama_ibu"];
				$profile["pekerjaan_ibu"] = $item["pekerjaan_ibu"];
				
				if($item["pekerjaan_ibu"] == "2"){
					$profile["pekerjaan_ibu"] = "Petani";
				} else if($item["pekerjaan_ibu"] == "3"){
					$profile["pekerjaan_ibu"] = "Nelayan";
				} else if($item["pekerjaan_ibu"] == "4"){
					$profile["pekerjaan_ibu"] = "Wiraswata";
				} else {
					$profile["pekerjaan_ibu"] = "Petani";
				}
				
				if($item["nama_wali"] == "-" || $item["nama_wali"] == "0" || $item["nama_wali"] == ""){
					$profile["nama_wali"] = "";
				} else {
					$profile["nama_wali"] = $item["nama_wali"];
				}
				
				if($item["pekerjaan_wali"] == "-" || $item["pekerjaan_wali"] == "0" || $item["pekerjaan_wali"] == ""){
					$profile["pekerjaan_wali"] = "";
				} else {
					$profile["pekerjaan_wali"] = $item["pekerjaan_wali"];
				}
				
				array_push($response, $profile);
			
			echo json_encode($response);
		}
		
		
	}
}