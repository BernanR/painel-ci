<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Midias extends CI_Controller {

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
		set_tema('conteudo', load_modulo('midia','gerenciar'));
		load_template();
		
	}

	public function editar()
	{
		$this->form_validation->set_rules('nome','Nome','trim|required|ucfirst|');
		$this->form_validation->set_rules('descricao','Descrição','trim');
		
		if($this->form_validation->run(TRUE))
		{	
			$dados = elements(array('nome','descricao'), $this->input->post());			
			$this->midias->do_update($dados,array('id_midia'=>$this->input->post('id_midia')));							
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
		 		$query = $this->midias->get_by_id($idmidia);
		 		if ($query->num_rows()==1) {
		 			$query = $query->row();
		 			unlink('./medias/images/uploads/'.$query->arquivo);
		 			$thumbs= glob('./medias/images/uploads/thumbs/*_'.$query->arquivo);
		 			foreach ($thumbs as $arquivo) 
		 			{
		 				unlink($arquivo);
		 			}
		 			$this->midias->do_delete(array('id_midia'=>$query->id_midia),FALSE);	 			
		 		}else{
		 			set_msg('msgerror','Mídia não encontrada','error');
		 		}	
		 	}else{
		 		set_msg('msgerror','Escolha uma mídia para excluir','error');
		 	}
		}
		redirect('midias/gerenciar');		
	}

	public function get_imgs()
	{
		header('Contant-Type: aplication/x-json; charset=utf-8');
		$this->db->like('nome',$this->input->post('pesquisarimg'));
		if ($this->input->post('pesquisarimg')=='') $this->db->limit(10);
		$this->db->order_by('id_midia','DESC');
		$query =  $this->midias->get_all();
		$retorno = 'Nenhum resultado encontrado com base em sua pesquisa';
		if($query->num_rows()>0)
		{
			$retorno = '';
			$query = $query->result();
			foreach ($query as $data) 
			{
				$retorno .= '<a class="th" role="button" href="javascript:void(0)" onClick="alert(\'Hello World!\')">';
				$retorno .= '<img src="'.thumb($data->arquivo,250,130,FALSE).'" class="retornoimg" alt="'.$data->nome.'" title="Clique aqui para inserir"/>'; 
				$retorno .= '</a>';
			}
			echo $retorno;
		}
	}
}

/* End of file midia.php */
/* Location: ./application/controllers/midia.php */