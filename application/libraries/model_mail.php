<?php 

	class Model_mail extends CI_Model {

    function __construct(){
        parent::__construct();

    }

    public function sendMail($para, $assunto, $corpo, $from){

        $this->load->library('phpmailer');
  
        $this->phpmailer->IsSMTP();
        $this->phpmailer->Host = "smtp.climatizarte.com.br";
        $this->phpmailer->SMTPAuth = true;
        $this->phpmailer->Username = 'auth@climatizarte.com.br';
        $this->phpmailer->Password = 'auth@climatizarte';
        $this->phpmailer->Port = 587;
        $this->phpmailer->AddAddress($para);
        $this->phpmailer->IsHTML();
        $this->phpmailer->From = "auth@climatizarte.com.br";
        $this->phpmailer->FromName = $from;
        $this->phpmailer->Subject  = "Comunicado".' - '.$assunto;
        $this->phpmailer->Body = utf8_decode($corpo);

        if(!$this->phpmailer->Send()){
          return false;
        }else{
          return true;
        }        
    }
  }