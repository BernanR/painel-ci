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
		$this->form_validation->set_rules('usuario','USUÁRIO','trim|required|min_length[4]|strtolower');
		$this->form_validation->set_rules('senha','SENHA','trim|required|min_length[4]|strtolower');
		
		if($this->form_validation->run()==TRUE)
		{
			$usuario = $this->input->post('usuario',TRUE);
			$senha   = $this->input->post('senha',TRUE);
			if($this->usuarios->do_login($usuario,$senha) == TRUE)
			{
				$query = $this->usuarios->get_by_login($usuario)->row();
				$dados = array(
						 'user_id' => $query->id_usuario ,
						 'user_nome' => $query->nome,
						 'user_admin' => $query->adm,
						 'user_logado' =>TRUE,
				);
				$this->session->set_userdata($dados);
				redirect('painel');
			}
			else
			{
				echo "login falhou";
			}
		}

		set_tema('titulo','login');
		set_tema('conteudo',load_modulo('usuario','login'));
		set_tema('rodape','');
		load_template();
	}
}

/* End of file Usuarios.php */
/* Location: ./application/controllers/usuarios.php */