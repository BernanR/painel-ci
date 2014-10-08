<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class auditoriaModel extends CI_Model
{
	public function do_insert($dados=NULL, $redir=TRUE)
	{
		if ($dados != NULL) 
		{
			$this->db->insert('auditoria',$dados);
			if ($this->db->affected_rows()>0)
			{
				set_msg('msgok','Cadastro efetuado com sucesso','sucess');
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
			$this->db->update('auditoria',$dados,$condicao);
			if ($this->db->affected_rows()>0)
			{
				set_msg('msgok','Alteração efetuada com sucesso','sucess');
			}else{
				set_msg('msgok','Ocorreu um erro ao tentar alterar registro','error');
			}			
			if($redir) redirect(current_url());
		}
	}
	
	public function get_all($limit=0)
	{	
		if ($limit > 0) $this->db->limit($limit);		
		return $this->db->get('auditoria');
	}

	public function get_by_id($id=NULL)
	{
		
		if ($id != NULL) 
		{
			$this->db->where('id_auditoria',$id);
			$this->db->limit(1);
			return $this->db->get('auditoria');
		}
		else
		{
			return FALSE;
		}
	}
	
}

/*
* End of file auditoriaModel.php
* Location: /application/models/auditoriaModel.php
*/