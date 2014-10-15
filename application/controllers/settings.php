<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
		init_painel();
		user_logout();
		$this->load->model('settingsModel','settings');
	}

	public function index()
	{
		$this->gerenciar();
	}

	public function gerenciar()
	{	
		if($this->input->post('cadastrar'))
		{
			if (stats_user(TRUE)) 
			{			
				$settings = elements(array('nome_site','url_logomarca','email_adm'),$this->input->post());
				foreach($settings as $nome_config => $valor_config)
				{
					set_setting($nome_config, $valor_config);
				}
				set_msg('msgok','Configurações atualizadas com sucesso','');
				redirect('settings/gerenciar');
			}else{
				redirect('settings/gerenciar');
			}
		}
		set_tema('footerinc',load_js(array('data-table','table')),FALSE);
		set_tema('titulo','Configurações do sistema');
		set_tema('conteudo', load_modulo('settings','gerenciar'));
		load_template();		
	}
}

/* End of file settings.php */
/* Location: ./application/controllers/settings.php */