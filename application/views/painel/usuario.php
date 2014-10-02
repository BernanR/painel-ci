<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

switch ($tela) {
	case 'login':
		echo '<div class="small-5 small-centered large-5 columns large-centered">';
		echo form_open('usuarios/login',array('class'=>'custom login-form'));
		echo form_fieldset('Identifique-se');
		erros_validacao();	
		echo form_label('Usuário');
		echo form_input(array('name'=>'usuario'), set_value('usuario'),'autofocus');
		echo form_label('Senha');
		echo form_password(array('name'=>'senha'), set_value('senha'));
		echo form_submit(array('name'=>'logar', 'class'=>'button radius right'),'Login');
		echo "<p>".anchor('usuarios/nova_senha','Esqueci  minha senha').'<p>';
		echo form_fieldset_close();
		echo "</div>";
	break;
	
	default:
		echo '<div class="alert-box alert"><p>A tela solicitada não existe</p></div>';
	break;
}