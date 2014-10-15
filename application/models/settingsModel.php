<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class settingsModel extends CI_Model
{
	public function do_insert($dados=NULL, $redir=TRUE)
	{
		if ($dados != NULL) 
		{
			$this->db->insert('settings',$dados);
			if ($this->db->affected_rows()>0)
			{	
				auditoria('Inclusão de Configuração','Nova Configuração campo:'.$condicao.' cadastrada no sistema');
				set_msg('msgok','Configuração no campo:'.$condicao.' ocorreu com sucesso','sucess');
			}else{
				set_msg('msgok','Ocorreu um erro ao tentar inserir registro','error');
			}
			if($redir) redirect(current_url());
		}
	}

	public function do_update($dados=NULL, $condicao=NULL, $redir=TRUE)
	{
		if ($dados != NULL && is_array($condicao))
		{
			$this->db->update('settings',$dados,$condicao);
			if ($this->db->affected_rows()>0)
			{	
				auditoria('Alteração de mídia', 'A configuração para o campo: "'.$condicao['nome_config'].'" foi alterada');
				set_msg('msgok','Alteração efetuada com sucesso','sucess');
			}else{
				set_msg('msgok','Ocorreu um erro ao tentar alterar registro','error');
			}			
			if($redir) redirect(current_url());
		}
	}

	public function do_delete($condicao=NULL,$redir=TRUE)
	{
		
		if ($condicao != NULL && is_array($condicao)) 
		{
			$this->db->delete('settings',$condicao);
			if ($this->db->affected_rows()>0)
			{
				auditoria('Exclusão de configuracao', 'A configuracao do campo"'.$condicao['nome_config'].'" foi excluída');
				set_msg('msgok','Registro excluído com sucesso','sucess');
			}else{
				set_msg('msgok','Erro ao excluir registro','error');
			}
			if ($redir) redirect(current_url());
		}
		else
		{
			return FALSE;
		}
	}
		
	public function get_all()
	{			
		return $this->db->get('settings');
	}

	public function get_by_nome($id=NULL)
	{
		if ($id != NULL) 
		{
			$this->db->where('nome_config',$id);
			$this->db->limit(1);
			return $this->db->get('settings');
		}
		else
		{
			return FALSE;
		}
	}
	
}

/*
* End of file settingsModel.php
* Location: /application/models/settingsModel.php
*/