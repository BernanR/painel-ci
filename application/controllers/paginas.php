<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paginas extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
		init_painel();
		user_logout();
		$this->load->model('paginaModel','paginas');
	}

	public function index()
	{
		$this->gerenciar();
	}

	public function cadastrar()
	{	
		$this->form_validation->set_rules('titulo','Titulo','trim|required|ucfirst|');
		$this->form_validation->set_rules('slug','SLUG','trim');
		$this->form_validation->set_rules('conteudo','Conteúdo','trim|required|htmlentities');
		
		if($this->form_validation->run(TRUE))
		{				
			$dados = elements(array('titulo','slug','conteudo'), $this->input->post());
			($dados['slug'] != '')? $dados['slug']=$dados['slug'] : $dados['slug']=slug($dados['titulo']);
			$this->paginas->do_insert($dados);								
		}
		set_tema('titulo','Nova página');
		set_tema('conteudo', load_modulo('paginas','cadastrar'));
		load_template();
		
	}

	public function gerenciar()
	{
		set_tema('footerinc',load_js(array('data-table','table')),FALSE);
		set_tema('titulo','Registros de Midia');
		set_tema('conteudo', load_modulo('paginas','gerenciar'));
		load_template();
		
	}

	public function editar()
	{
		$this->form_validation->set_rules('titulo','Titulo','trim|required|ucfirst|');
		$this->form_validation->set_rules('slug','SLUG','trim');
		$this->form_validation->set_rules('conteudo','Conteúdo','trim|required|htmlentities');
		
		if($this->form_validation->run(TRUE))
		{				
			$dados = elements(array('titulo','slug','conteudo'), $this->input->post());
			($dados['slug'] != '')? $dados['slug']=$dados['slug'] : $dados['slug']=slug($dados['titulo']);
			$this->paginas->do_update($dados,array('id_pagina'=>$this->input->post('id_pagina')));								
		}
		
		set_tema('titulo','Editar mídia');
		set_tema('conteudo', load_modulo('paginas','editar'));
		load_template();		
	}

	public function excluir()
	{
		
		if (stats_user(TRUE)) 
		{
		 	$idpagina = $this->uri->segment(3);
		 	if ($idpagina != NULL) 
		 	{
		 		$query = $this->paginas->get_by_id($idpagina);
		 		if ($query->num_rows()==1) {
		 			$query = $query->row();
		 			$this->paginas->do_delete(array('id_pagina'=>$query->id_pagina),FALSE);	 			
		 		}else{
		 			set_msg('msgerror','Página não encontrada','error');
		 		}	
		 	}else{
		 		set_msg('msgerror','Escolha uma página para excluir','error');
		 	}
		}
		redirect('paginas/gerenciar');		
	}
}

/* End of file paginas.php */
/* Location: ./application/controllers/paginas.php */