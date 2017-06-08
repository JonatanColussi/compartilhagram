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

		$variables['user']  =  $this->Users_model->getById($this->session->userdata('idUser'))->row();
		$variables['posts'] =  $this->Posts_model->getAllPosts()->result();

		$this->template->set('title', 'Compartilhagram | Poste suas fotos On The Line');
		$this->template->set('styles', $styles);
		$this->template->set('scripts', $scripts);


		$this->template->load('layout', 'feed', $variables);
	}

	public function add(){
		$this->load->model('Posts_model');

		$data = $this->input->post();
		$data['idUser'] = $this->session->userdata('idUser');
		$data['date'] = date('Y-m-d H:i:s');

		$idPost = $this->Posts_model->store($data);
			
		if($idPost > 0){
			$image = $this->imageUpload($idPost, 'posts');
			$data['image'] = $image;

			$this->Posts_model->store($data, $idPost);

			die(
				json_encode(
					array(
						'success'  => true,
						'message'  => 'Usuário cadastrado com sucesso',
						'redirect' => 'feed',
						'selector' => '.message-add'
					)
				)
			);

		}else{
			die(
				json_encode(
					array(
						'success'  => false,
						'message'  => 'Ocorreu um erro. Por favor, tente novamente mais tarde.',
						'selector' => '.message-add'
					)
				)
			);
		}
	}

	private function imageUpload($id, $folder){
        $type = strchr($_FILES['image']['name'], '.');

		$config['upload_path']   = "./uploads/{$folder}/";
        $config['allowed_types'] = 'gif|jpg|png';
        $config['file_name']     = $id.$type;

        $this->load->library('upload', $config);

        if($this->upload->do_upload('image'))
        	return $config['file_name'];
        else
        	echo $this->upload->display_errors();
	}
}
