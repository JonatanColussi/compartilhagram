<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts_model extends CI_Model{
	private $table = 'posts';

	public function store($dados = null, $id = null){
		if($dados){
			if($id){
				$this->db->where('idPost', $id);
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

	public function getPost($idPost){
		$this->db->where('idPost', $idPost);
		return $this->db->get($this->table);
	}

	public function getAllPosts(){
		$this->db->select('p.*, u.name');
		$this->db->join('users u', 'u.idUser = p.idUser');
		$this->db->order_by('date', 'DESC');
		return $this->db->get($this->table.' p');
	}

	public function delete($idPost){
		$this->db->where('idPost', $idPost);
		$this->db->delete($this->table);
	}
}