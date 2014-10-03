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
			$senha   = md5($this->input->post('senha',TRUE));
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
				$query = $this->usuarios->get_by_login($usuario)->row();
				if (empty($query)) 
				{
					set_msg('errologin','Usuário inexistente','erro');
				}
				elseif($query->senha != $senha)
				{	
					set_msg('errologin','Senha Incorreta','erro');
				}
				elseif($query->ativo == 0)
				{
					set_msg('errologin','usuário inativo','erro');
				}
				else
				{
					set_msg('errologin','Erro desconhecido, contate o desenvolvedor','erro');
				}
				redirect('usuarios/login');
			}
		}

		set_tema('titulo','login');
		set_tema('conteudo',load_modulo('usuario','login'));
		set_tema('rodape','');
		load_template();
	}
	//NO FUTURO CORRIGIR ESSA FUNÇÃO, CREATE SESSION PODE DAR PROBLEMAS
	public function logoff()
	{
		$this->session->unset_userdata(array('user_id'=>'','user_nome'=>'','user_logado'=>''));
		$this->session->sess_destroy();
		$this->session->sess_create();
		set_msg('logoffok','Logoff efetuado com sucesso','sucess');
		redirect('usuarios/login');
	}

	public function nova_senha()
	{
		//carrega o módulo usuários e mostra a tela de login
		$this->form_validation->set_rules('email','EMAIL','trim|required|valid_email|strtolower');
		
		if($this->form_validation->run()==TRUE)
		{	
			$email = $this->input->post('email');
			$query = $this->usuarios->get_by_email($email);
			if ($query->num_rows()==1) 
			{
				$novasenha = substr(str_shuffle('qwertyuiopasdfghjklzxcvbnm0123456789'),0,6);
				$mensagem  = "<p>Você solicitou uma nova senha para acesso ao painel de administração do site, a partir de agora use a seguinte senha para acesso: <strong>".$novasenha."</strong></p><p>Troque esta senha para uma senha segura e de sua preferência o quanto antes.</p>";
				if ($this->sistema->libray_mail_send($email,'Nova senha de acesso',$mensagem,'Sistema BRcontent'))
				{
					$dados['senha'] = md5($novasenha);
					$this->usuarios->do_update($dados,array('email'=>$email),FALSE);
					
					set_msg('msgok','Uma nova senha foi enviada para seu email','sucess');
					redirect('usuarios/nova_senha');
				}
				else
				{
					set_msg('msgerror','Erro ao enviar nova senha, contate o administrador','error');
					redirect('usuarios/nova_senha');
				}
			}
			else
			{
				set_msg('msgerror','Esse email não esta cadastrado no sistema','error');
				redirect('usuarios/nova_senha');
			}
		}
		set_tema('titulo','Recuperar senha');
		set_tema('conteudo',load_modulo('usuario','nova_senha'));
		set_tema('rodape','');
		load_template();
	}
}



/* End of file Usuarios.php */
/* Location: ./application/controllers/usuarios.php */