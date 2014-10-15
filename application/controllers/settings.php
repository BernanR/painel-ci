<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
		init_painel();
		user_logout();
		$this->load->model('midiaModel','midias');
	}

	public function index()
	{
		$this->gerenciar();
	}

	public function cadastrar()
	{	
		$this->form_validation->set_rules('nome','Nome','trim|required|ucfirst|');
		$this->form_validation->set_rules('descricao','Descrição','trim');
		
		if($this->form_validation->run(TRUE))
		{	
			$upload = $this->midias->do_upload('arquivo');
			if (is_array($upload) && $upload['file_name'] != '') 
			{
				$dados = elements(array('nome','descricao'), $this->input->post());
				$dados['arquivo'] = $upload['file_name'];
				$this->midias->do_insert($dados);
			}else{
				set_msg('msgerror',$upload,'error');
				redirect(current_url());
			}					
		}
		set_tema('titulo','Upload de imagens');
		set_tema('conteudo', load_modulo('midia','cadastrar'));
		load_template();
		
	}

	public function gerenciar()
	{
		set_tema('footerinc',load_js(array('data-table','table')),FALSE);
		set_tema('titulo','Registros de Midia');
		set_tema('conteudo', load_modulo('auditoria','gerenciar'));
		load_template();
		
	}
}

/* End of file settings.php */
/* Location: ./application/controllers/settings.php */