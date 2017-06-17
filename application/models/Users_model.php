<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model{
	private $table = 'Users';

	public function store($dados = null, $id = null){
		if($dados){
			if($id){
				$this->db->where('idUser', $id);
				if($this->db->update($this->table, $dados)){
					return $id;
				}else{
					return false;
				}
			}else{
				if($this->db->insert($this->table, $dados)){
					return $this->db->insert_id();
				}else{
					return false;
				}
			}
		}		
	}

	public function login($user){
		$this->db->where('username', $user);
		return $this->db->get($this->table);
	}

	public function getById($idUser){
		$this->db->where('idUser', $idUser);
		return $this->db->get($this->table);
	}
}