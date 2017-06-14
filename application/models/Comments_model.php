<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comments_model extends CI_Model{

	public function getComments($idPost = null, $idComment = null){
		$this->db->select('u.name, c.*');
		$this->db->join('users u', 'u.idUser = c.idUser');
		if(!is_null($idPost))
			$this->db->where('idPost', $idPost);
		if(!is_null($idComment))
			$this->db->where('idComment', $idComment);
		$this->db->order_by('date', 'ASC');
		return $this->db->get('comments c')->result();
	}

	public function getComment($idComment){
		$comment = $this->getComments(null, $idComment);
		return $comment[0];
	}

	public function comment($dados){
		if($dados){
			if($this->db->insert('comments', $dados)){
				return $this->db->insert_id();
			}else{
				return false;
			}
		}		
	}
}