<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// carrega um módulo do sistema devolvendo a tela solicitada

function load_modulo($modulo=NULL, $tela=NULL, $diretorio='painel')
{
	$CI =& get_instance();

	if( $modulo!=NULL )
	{
		return $CI->load->view("$diretorio/$modulo",array('tela'=>$tela),TRUE);
	
	}else{

		return FALSE;
	}
}

//seta valores ao array $tema da classe sistema
function set_tema($prop,$valor,$replace=TRUE)
{
	$CI =& get_instance();
	$CI->load->library('sistema');

	if($replace)
	{
		$CI->sistema->tema[$prop] = $valor;
	}else{
		if(!isset($CI->sistema->tema[$prop])) $CI->sistema->tema[$prop] = '';
		$CI->sistema->tema[$prop] .= $valor;
	}
}

function get_tema()
{
	$CI =& get_instance();
	$CI->load->library('sistema');
	return $CI->sistema->tema;
}

//inicializar o painel adm carregando os recursos necessários
function init_painel()
{
	$CI =& get_instance();
	$CI->load->library(array('sistema','session','form_validation','parser'));
	$CI->load->helper(array('form','url','array','text'));
	
	//carregamento do models
	$CI->load->model('usuarioModel','usuarios');

	set_tema('titulo_padrao','Painel ADM');
	set_tema('rodape','<p>&copy; 2014 | Todos os direitos reservados para BR');
	set_tema('template','painel');
	set_tema('headerinc',load_css(array('foundation/foundation.min','style')),FALSE);
	set_tema('headerinc',load_js(array('jquery')),FALSE);
	set_tema('footerinc',load_js(array('foundation.min')),FALSE);
	
}

//carrega um templates passando o array $tema como parâmetro

function load_template()
{
	$CI =& get_instance();
	$CI->load->library('sistema');
	$CI->parser->parse($CI->sistema->tema['template'], get_tema());
}

//carrega um ou varios arquivos css em uma pasta
function load_css($arquivo=NULL,$pasta='medias/css',$medias='all')
{
	if($arquivo != NULL)
	{
		$CI =& get_instance();
		$CI->load->helper('url');
		$retorno = '';

		if( is_array($arquivo))
		{
			foreach ($arquivo as $css) 
			{
				$retorno .= '<link rel="stylesheet" type="text/css" href="'.base_url("$pasta/$css.css").'" media="'.$medias.'">';
			}

		}else{

			$retorno .= '<link rel="stylesheet" type="text/css" href="'.base_url("$pasta/$css.css").'" media="'.$medias.'">';
		
		}
		return $retorno;
	}
}

// função carrega um ou varios arquivos js, de uma pasta ou remoto

function load_js($arquivo=NULL, $pasta='medias/js', $remoto=FALSE)
{
	if ( $arquivo != NULL) 
	{
		$CI =& get_instance();
		$CI->load->helper('url');

		$retorno = '';

		if(is_array($arquivo))
		{
			foreach ($arquivo as $js) {
				if($remoto)
				{
					$retorno .= '<script type="text/javascript" src="'.$js.'.js"></script>';	
				}else{
					$retorno .= '<script type="text/javascript" src="'.base_url($pasta."/".$js).'.js"></script>';
				}
			}
		}else{
			if($remoto)
			{
				$retorno .= '<script type="text/javascript" src="'.$arquivo.'.js"></script>';	
			}else{
				$retorno .= '<script type="text/javascript" src="'.base_url($pasta."/".$arquivo).'.js"></script>';
			}
		}
	}
	return $retorno;
}

//mostra erros de validadção em form

function erros_validacao()
{
	if(validation_errors()) echo '<div class="alert-box alert radius">'.validation_errors('<p>','</p>').'</div>';
}

//verifica se o usuário esta logado no sistema
//NO FUTURO CORRIGIR ESSA FUNÇÃO, CREATE SESSION PODE DAR PROBLEMAS
function user_logout($redir=TRUE)
{
	$CI =& get_instance();
	$CI->load->library('session');
	$user_status = $CI->session->userdata('user_logado');

	if (!isset($user_status) || $user_status != TRUE) 
	{
		$CI->session->sess_destroy();
		$CI->session->sess_create();
		if ($redir) 
		{
			$CI->session->set_userdata(array('redir_para'=>current_url()));
			set_msg('errologin','Acesso restrito, faça login antes de prosseguir','error');
			redirect('usuarios/login');
		}
		else
		{
			return FALSE;
		}
	}
	else
	{
		return TRUE;
	}
}

//define uma mensagem para ser exibida na próxima tela carregada

function set_msg($id='msgerro', $msg=NULL, $tipo='error')
{
	$CI =& get_instance();
	switch ($tipo) {
		case 'error':
			$CI->session->set_flashdata($id,'<div class="large-12 alert-box alert radius"><p>'.$msg.'</p></div>');
		break;
		case 'sucess':
			$CI->session->set_flashdata($id,'<div class="large-12 alert-box sucess radius"><p>'.$msg.'</p></div>');
		break;
		
		default:
			$CI->session->set_flashdata($id,'<div class="alert-box radius"><p>'.$msg.'</p></div>');
		break;
	}
}

//verifica se existe uma mensgem para ser exibida na tela atual
function get_msg($id, $printar=TRUE)
{	
	$CI =& get_instance();		
	if ($CI->session->flashdata($id))
	{

		if ($printar) {
			echo $CI->session->flashdata($id);
			return TRUE;
		}
		else
		{
			return $CI->session->flashdata($id);
		}
	}
	//return FALSE;
}

//verifica se usuario logado é administrador
function stats_user($set_msg=FALSE)
{
	$CI = & get_instance();
	$user_admin = $CI->session->userdata('user_admin');
	if (!isset($user_admin) || $user_admin != TRUE)
	{
		if($set_msg) set_msg('msgerror','você não tem permissão para executar essa operação','error');
		return FALSE;
	}else{
		return TRUE;
	}
}

//gera um breadcrumb com base no controller atual
function breadcrumb()
{
	$CI = & get_instance();
	$CI->load->helper('url');
	$classe = ucfirst($CI->router->class);
	if($classe == 'Painel')
	{
		$classe = anchor($CI->router->class,'Início');

	}else{

		$classe = anchor($CI->router->class,$classe);

	}
	$metodo = ucwords(str_replace('_',' ',$CI->router->method));
	if ($metodo && $metodo != 'Index')
	{
		$metodo = " &raquo; ".anchor($CI->router->class."/".$CI->router->method,$metodo);

	}else{
		$metodo = '';
	}
	return 'Sua localização: '.anchor('painel','Início').' &raquo; '.$classe.$metodo;
}

//seta um registro na tabela auditoria
function auditoria($operacao,$observacao,$query=TRUE)
{
	$CI =& get_instance();
	$CI->load->library('session');
	$CI->load->model('auditoriaModel','auditoria');
	if (user_logout(FALSE)) 
	{
		$user_id  = $CI->session->userdata('user_id');
		$user_login = $CI->usuarios->get_by_id($user_id)->row()->login; 
	}
	else
	{
		$user_login = 'Desconhecido';
	}
	if ($query) {
		$last_query = $CI->db->last_query();
	}
	else
	{
		$last_query = '';
	}
	$dados = array(
		'usuario' => $user_login,
		'operacao' => $operacao,
		'query'   => $last_query,
		'observacao' => $observacao
	);
	$CI->auditoria->do_insert($dados,FALSE);
}