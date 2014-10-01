<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('sistema');
	}

	public function index()
	{
		$this->load->view('usuarios');
	}	

	public function login()
	{	//carrega o módulo usuários e mostra a tela de login
		$tema['titulo'] = 'Login';
		$tema['conteudo'] = load_modulo('usuario','login');
		$this->load->view('painel',$tema);
	}
}

/* End of file Usuarios.php */
/* Location: ./application/controllers/usuarios.php */