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
		}else{
			die(
				json_encode(
					array(
						'success'  => false,
						'message'  => 'O nome de usuário já está sendo utilizado!',
						'selector' => '.message-add'
					)
				)
			);
		}
	}

	public function login(){
		$this->load->model('Users_model');
		$error = false;
		$data = $this->input->post();

		if(isset($data['username']) && isset($data['password'])){
			$dataUser = $this->Users_model->login($data['username']);
			if($dataUser->num_rows() > 0){
				if(password_verify($data['password'], $dataUser->row()->password) === false)
					$error = true;
				else
					$this->session->set_userdata('idUser', $dataUser->row()->idUser);
			}else
				$error = true;
		}else
			$error = true;

		if(!$error)
			die(
				json_encode(
					array(
						'success'  => true,
						'message'  => 'Bem vindo ao Compartilhagram',
						'redirect' => 'feed',
						'selector' => '.message-login'
					)
				)
			);
		else
			die(
				json_encode(
					array(
						'success'  => false,
						'message'  => 'Usuário e/ou senha inválidos',
						'selector' => '.message-login'
					)
				)
			);
	}

	public function logout(){
		$this->session->set_userdata('idUser', null);
		redirect('home');
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
