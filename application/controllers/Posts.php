<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends CI_Controller{
	public function __construct(){
		parent::__construct();
		if(!($this->session->userdata('idUser') > 0))
			redirect('home');
	}

	public function index(){
		$styles[]  = base_url('assets/css/src/posts.css');
		$scripts[] = base_url('assets/js/src/posts.js');

		$this->load->model('Users_model');
		$this->load->model('Posts_model');
		$this->load->model('Likes_model');
		$this->load->model('Comments_model');

		$variables['user']  =  $this->Users_model->getById($this->session->userdata('idUser'))->row();
		$variables['posts'] =  $this->Posts_model->getAllPosts()->result();

		foreach($variables['posts'] as &$post){
			$post->qtdLikes = $this->Likes_model->getNumberOfLikes($post->idPost);
			$post->comments = $this->Comments_model->getComments($post->idPost);
			$post->liked    = $this->Likes_model->liked($post->idPost, $this->session->userdata('idUser'));
		}

		$this->template->set('title', 'Compartilhagram | Poste suas fotos On The Line');
		$this->template->set('styles', $styles);
		$this->template->set('scripts', $scripts);


		$this->template->load('layout', 'feed', $variables);
	}

	public function add(){
		$this->load->model('Posts_model');
		$this->load->model('Likes_model');
		$this->load->model('Comments_model');

		$data = $this->input->post();
		$data['idUser'] = $this->session->userdata('idUser');
		$data['date'] = date('Y-m-d H:i:s');

		$idPost = $this->Posts_model->store($data);
			
		if($idPost > 0){
			$image = $this->imageUpload($idPost, 'posts');
			if($image !== false){
				$data['image'] = $image;
				$this->Posts_model->store($data, $idPost);

				$post = $this->Posts_model->getPost($idPost)->row();
				$post->qtdLikes = $this->Likes_model->getNumberOfLikes($post->idPost);
				$post->comments = $this->Comments_model->getComments($post->idPost);
				$post->liked    = $this->Likes_model->liked($post->idPost, $this->session->userdata('idUser'));

				$this->load->view('includes/post', $post);
			}else{
				$this->Posts_model->delete($idPost);
				echo json_encode(false);
			}
		}else
			echo json_encode(false);
	}

	public function like(){
		$this->load->model('Likes_model');
		$data = $this->input->get();

		$like = $this->Likes_model->like($data['idPost'], $this->session->userdata('idUser'));

		die(json_encode($like));
	}

	public function comment(){
		$this->load->model('Comments_model');
		$data = $this->input->post();
		$data['idUser'] = $this->session->userdata('idUser');
		$data['date'] = date('Y-m-d H:i:s');
		
		$idComment = $this->Comments_model->comment($data);

		if($idComment !== false)
			$this->load->view('includes/comment', $this->Comments_model->getComment($idComment));
		else
			die(json_encode(false));
	}

	private function imageUpload($id, $folder){
        $type = strchr($_FILES['image']['name'], '.');

		$config['upload_path']   = "./uploads/{$folder}/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['file_name']     = $id.$type;

        $this->load->library('upload', $config);

        if($this->upload->do_upload('image'))
        	return $config['file_name'];
        else
        	return false;
	}
}
