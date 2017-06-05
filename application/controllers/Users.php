<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller{
	public function add(){
		$this->load->model('Users_model');
		$this->load->library('form_validation');


		$data = $this->input->post();
		$this->form_validation->set_rules('username', 'Nome de usuário', 'is_unique[users.username]', array('is_unique' => 'O %s já está sendo utilizado'));

		if($this->form_validation->run()){

			$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

			unset($data['passwordConfirm']);

			$idUser = $this->Users_model->store($data);
			
			if($idUser > 0){
				$this->session->set_userdata('idUser', $idUser);

				$image = $this->imageUpload($idUser, 'users');
				$data['image'] = $image;
				$this->Users_model->store($data, $idUser);

				$variables['mensagem'] = "Dados gravados com sucesso!";
				$this->template->set('title', 'Compartilhagram | Feed de fotos');

				$this->template->load('layout', 'feed', $variables);
			}else{
				$variables['mensagem'] = "Ocorreu um erro. Por favor, tente novamente.";
				$this->template->load('layout', 'home', $variables);
			}
		}else{
			$styles[] = base_url('assets/css/src/home.css');
			$scripts[] = base_url('assets/js/src/home.js');

			$this->template->set('title', 'Compartilhagram | Poste suas fotos On The Line');
			$this->template->set('styles', $styles);
			$this->template->set('scripts', $scripts);


			$this->template->load('layout', 'home');
		}
	}

	public function login(){
		$this->load->model('Users_model');
		$variables['error'] = '';
		$data = $this->input->post();

		if(isset($data['username']) && isset($data['password'])){
			$dataUser = $this->Users_model->login($data['username']);
			if($dataUser->num_rows() > 0){
				if(password_verify($data['password', $dataUser->row()->password) === false)
					$variables['error'] = 'Usuário e/ou senha inválidos';
				else
					$this->session->set_userdata('idUser', $dataUser->row()->idUser);
			}else
				$variables['error'] = 'Usuário e/ou senha inválidos';
		}else
			$variables['error'] = 'Usuário e/ou senha inválidos';

		if($variables['error'] == ''){
			$this->template->set('title', 'Compartilhagram | Feed de fotos');

			$this->template->load('layout', 'feed');
		}else{
			$styles[] = base_url('assets/css/src/home.css');
			$scripts[] = base_url('assets/js/src/home.js');

			$this->template->set('title', 'Compartilhagram | Poste suas fotos On The Line');
			$this->template->set('styles', $styles);
			$this->template->set('scripts', $scripts);


			$this->template->load('layout', 'home', $variables);
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
