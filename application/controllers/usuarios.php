<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
		init_painel();
	}

	public function index()
	{
		$this->load->view('usuarios');
	}	

	public function login()
	{	//carrega o módulo usuários e mostra a tela de login
		//$tema['titulo'] = 'Login';
		set_tema('titulo','login');
		set_tema('conteudo',load_modulo('usuario','login'));
		load_template();
	}
}

/* End of file Usuarios.php */
/* Location: ./application/controllers/usuarios.php */