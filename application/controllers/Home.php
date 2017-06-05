<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function index(){
		$styles[]  = base_url('assets/css/src/home.css');
		$scripts[] = base_url('assets/js/src/home.js');

		$this->template->set('title', 'Compartilhagram | Poste suas fotos On The Line');
		$this->template->set('styles', $styles);
		$this->template->set('scripts', $scripts);


		$this->template->load('layout', 'home');
	}
}
