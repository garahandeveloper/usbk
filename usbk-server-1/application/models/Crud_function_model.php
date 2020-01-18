<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Crud_function_model extends CI_Model {
	// function memasukan data oop
	public function insertData($table,  $fieldInTable){
		$query = $this->db->insert($table, $fieldInTable);
	}
	public function readData($nameTable, $select, $where, $orderBy){
		// untuk menselect
		$query = $this->db->select($select);
		if(empty($where)){
		} else {
		//untuk where
			$query = $this->db->where($where);
		}
		if(empty($orderBy)){
		} else {
		// order by
		$query = $this->db->order_by($orderBy);
		}
		// milih table
		// sama dengan select * from nameTable
		// dan harus di paling bawah
		$query = $this->db->get($nameTable);
		
		return $query->result_array();
	}
	public function deleteData($nameTable, $where){
		//catatan
		//untuk where harus di atas nameTable
		// where id = id
		$query = $this->db->where($where);
		
		// delete form nameTable
		$query = $this->db->delete($nameTable);
	}
	public function updateData($nameTable, $set, $where){
		$query = $this->db->set($set);
		$query = $this->db->where($where);
		$query = $this->db->update($nameTable);
	}
	public function login($nameTable, $where){
		$query = $this->db->where($where);
		$query = $this->db->get($nameTable);
		return $query->num_rows();
	}
}