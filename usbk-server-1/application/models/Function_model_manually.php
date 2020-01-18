<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Function_model_manually extends CI_Model {
	public function readDataJoin(){
	
		$query = $this->db->query("
		select * from ujian as a 
		join data_pegawai as b 
		join mapel as c 
		join data_kelas as d 
		on a.guru = b.id_data_pegawai && a.mapel = c.id_mapel && a.kelas = d.id_data_kelas");
		
		return $query->result_array();
	}
	public function readDataJoinSoal(){
		$query = $this->db->query("
			select * from soal where id_soal = $_GET[id]
		");
		return $query->result_array();
	}
	public function readDataJawabSoal(){
		$query = $this->db->query("
			

			select distinct a.*, b.*, b.jawaban as jwbn, a.jawaban as jawaban_soal from soal as a left join jawaban_soal_siswa as b 
			on a.id_soal = b.no && a.token_id = $_SESSION[tokenSession] && b.NISN = $_SESSION[username] 
			where a.token_id = $_SESSION[tokenSession] order by id_soal asc


			");
		return $query->result_array();
	}
	public function readDataManuallyController($query){
		$query = $this->db->query($query);
		return $query->result_array();
	}
	public function readDataLimit($nameTable, $select, $where, $orderBy, $limit){
		$query = $this->db->select($select);
		$query = $this->db->where($where);
		$query = $this->db->order_by($orderBy);
		$query = $this->db->get($nameTable, $limit);
		
		return $query->result_array();
	}
	
	
	
	
	
	
	// public function migrasi_soal_model(){
		// $query = $this->db->query("select * from kkpi_1_sheet1");
		// return $query->result_array();
	// }
}