<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class usuarioModel extends CI_Model
{
	public function do_login($usuario=NULL, $senha=NULL)
	{
		if($usuario && $senha)
		{
			$this->db->where('login',$usuario);
			$this->db->where('senha',md5($senha));
			$this->db->where('ativo',1);
			$query = $this->db->get('usuarios');
			if ($query->num_rows == 1) 
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
	}
	
	public function get_by_login($login=NULL)
	{
		if ($login != NULL) 
		{
			$this->db->where('login',$login);
			$this->db->limit(1);
			return $this->db->get('usuarios');
		}
		else
		{
			return FALSE;
		}
	}
}

/*
* End of file usuarioModel.php
* Location: /application/models/usuarioModel.php
*/