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
		return $this->db->get($this->table);
	}

	public function getNumberOfLikes($idPost){
		$this->db->select('COUNT(*) AS qtdLikes');
		$this->db->where('idPost', $idPost);
		return $this->db->get('likes')->row()->qtdLikes;
	}
	public function getComments($idPost){
		$this->db->where('idPost', $idPost);
		return $this->db->get('comments')->result();
	}

	public function like($idPost, $idUser){
		$this->db->select('COUNT(*) AS qtdLikes');
		$this->db->where('idPost', $idPost);
		$this->db->where('idUser', $idUser);
		if($this->db->get('likes')->row()->qtdLikes == 0)
			$this->doLike($idPost, $idUser);
		else
			$this->undoLike($idPost, $idUser);
		return $this->getNumberOfLikes($idPost);
	}

	private function doLike($idPost, $idUser){
		$this->db->insert('likes', array('idPost' => $idPost, 'idUser' => $idUser));
	}

	private function undoLike($idPost, $idUser){
		$this->db->where('idPost', $idPost);
		$this->db->where('idUser', $idUser);
		$this->db->delete('likes');
	}
}