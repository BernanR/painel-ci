<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Painel extends CI_Controller {


	public function index()
	{
		$this->inicio();
	}

	public function inicio()
	{
		redirect('usuarios/login');
	}
}

/* End of file painel.php */
/* Location: ./application/controllers/welcome.php */