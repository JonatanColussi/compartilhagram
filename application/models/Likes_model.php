<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Likes_model extends CI_Model{

	public function getNumberOfLikes($idPost){
		$this->db->select('COUNT(*) AS qtdLikes');
		$this->db->where('idPost', $idPost);
		return $this->db->get('Likes')->row()->qtdLikes;
	}

	public function liked($idPost, $idUser){
		$this->db->select('COUNT(*) AS qtdLikes');
		$this->db->where('idPost', $idPost);
		$this->db->where('idUser', $idUser);
		return !($this->db->get('Likes')->row()->qtdLikes == 0);
	}
	public function like($idPost, $idUser){
		if($this->liked($idPost, $idUser)){
			$this->undoLike($idPost, $idUser);
			$liked = false;
		}else{
			$this->doLike($idPost, $idUser);
			$liked = true;
		}
		return array($liked, $this->getNumberOfLikes($idPost));
	}

	private function doLike($idPost, $idUser){
		$this->db->insert('Likes', array('idPost' => $idPost, 'idUser' => $idUser));
	}

	private function undoLike($idPost, $idUser){
		$this->db->where('idPost', $idPost);
		$this->db->where('idUser', $idUser);
		$this->db->delete('Likes');
	}
}