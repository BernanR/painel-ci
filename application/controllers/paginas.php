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
		$this->form_validation->set_rules('descricao','Descrição','trim');
		
		if($this->form_validation->run(TRUE))
		{	
			$upload = $this->paginas->do_upload('arquivo');
			if (is_array($upload) && $upload['file_name'] != '') 
			{
				$dados = elements(array('nome','descricao'), $this->input->post());
				$dados['arquivo'] = $upload['file_name'];
				$this->paginas->do_insert($dados);
			}else{
				set_msg('msgerror',$upload,'error');
				redirect(current_url());
			}					
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
		$this->form_validation->set_rules('nome','Nome','trim|required|ucfirst|');
		$this->form_validation->set_rules('descricao','Descrição','trim');
		
		if($this->form_validation->run(TRUE))
		{	
			$dados = elements(array('nome','descricao'), $this->input->post());			
			$this->paginas->do_update($dados,array('id_midia'=>$this->input->post('id_midia')));							
		}

		set_tema('titulo','Editar mídia');
		set_tema('conteudo', load_modulo('midia','editar'));
		load_template();		
	}

	public function excluir()
	{
		
		if (stats_user(TRUE)) 
		{
		 	$idmidia = $this->uri->segment(3);
		 	if ($idmidia != NULL) 
		 	{
		 		$query = $this->paginas->get_by_id($idmidia);
		 		if ($query->num_rows()==1) {
		 			$query = $query->row();
		 			unlink('./medias/images/uploads/'.$query->arquivo);
		 			$thumbs= glob('./medias/images/uploads/thumbs/*_'.$query->arquivo);
		 			foreach ($thumbs as $arquivo) 
		 			{
		 				unlink($arquivo);
		 			}
		 			$this->paginas->do_delete(array('id_midia'=>$query->id_midia),FALSE);	 			
		 		}else{
		 			set_msg('msgerror','Mídia não encontrada','error');
		 		}	
		 	}else{
		 		set_msg('msgerror','Escolha uma mídia para excluir','error');
		 	}
		}
		redirect('paginas/gerenciar');		
	}
}

/* End of file paginas.php */
/* Location: ./application/controllers/paginas.php */