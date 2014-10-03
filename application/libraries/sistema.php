<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BR_Sistema{

	protected $CI;
	public $tema = array();

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->helper('funcoes');
	}

	public function send_mail($para, $assunto,$mensagem,$formato='html')
	{
		$this->CI->load->library('email');
		$config['mailtype'] = $formato;
		$this->CI->email->initialize($config);
		$this->CI->email->from('adm@site.com','Administração do site');
		$this->CI->email->to($para);
		$this->CI->email->subject($assunto);
		$this->CI->email->message($mensagem);
		if ($this->CI->email->send()) 
		{
			return TRUE;
		}
		else
		{
			return $this->CI->email->print_debugger();
		}
	}

	public function libray_mail_send($para, $assunto, $corpo, $from){

        $this->CI->load->library('phpmailer');
  
        $this->CI->phpmailer->IsSMTP();
        $this->CI->phpmailer->Host = "smtp.climatizarte.com.br";
        $this->CI->phpmailer->SMTPAuth = true;
        $this->CI->phpmailer->Username = 'auth@climatizarte.com.br';
        $this->CI->phpmailer->Password = 'auth@climatizarte';
        $this->CI->phpmailer->Port = 587;
        $this->CI->phpmailer->AddAddress($para);
        $this->CI->phpmailer->IsHTML();
        $this->CI->phpmailer->From = "auth@climatizarte.com.br";
        $this->CI->phpmailer->FromName = $from;
        $this->CI->phpmailer->Subject  = "Comunicado".' - '.$assunto;
        $this->CI->phpmailer->Body = utf8_decode($corpo);

        if(!$this->CI->phpmailer->Send()){
          return false;
        }else{
          return true;
        }        
    }
}

/* End of file BR_Sistema */
/* Location: ./application/library/sistema.php */