<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class migrasi_data extends CI_Controller {

	public function __construct(){
		
		parent:: __construct();
		$this->load->database();
		// ini untuk crud automatic
		$this->load->model("crud_function_model");
		// ini untuk crud manually
		$this->load->model("Function_model_manually");
		
	}
	public function index(){
		$query = $this->Function_model_manually->readDataManuallyController("select * from usbk.soal order by id_soal asc");
		$i = 2;
		foreach($query as $item){
			$i++;
			//echo "id_update".$i++."----";
			$ii = $i + -1;
			//echo "id_soal".$item["id_soal"]."----";
			//echo $ii;
			$query2 = $this->Function_model_manually->readDataManuallyController("select * from usbk.pilihan_e where id_pilihan_e = '$ii' order by id_pilihan_e asc limit 1");
			foreach($query2 as $pila){
				//echo "id_pilihan_a"."--".$pila["id_pilihan_a"]."---";
				//echo $pila["deskripsi_a"]."----".$ii;
				
				$set = array(
					"soal_id" => $item["id_soal"]
				);
				$where = array(
					"id_pilihan_e" => $pila["id_pilihan_e"]-1
				);
				$mm = $ii -1;
				//$this->crud_function_model->updateData("usbk.pilihan_e", $set, $where);
				echo '$this->crud_function_model->updateData("usbk.pilihan_e", '.$set["soal_id"].', '.$where["id_pilihan_e"]."--".$mm.')'."<br />";
				
			}
		}
	}
}