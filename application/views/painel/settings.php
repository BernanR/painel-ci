<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

switch ($tela) {
	
	case 'gerenciar':
		?>		
		<p class="breadcrumb"><?php echo breadcrumb(); ?></p>
		<div class="small-12 large-12 columns">		
		<?php				
		echo form_open('settings/gerenciar',array('class'=>'custom'));
		echo form_fieldset('Cofiguração do sistema');

		erros_validacao();
		get_msg('msgok');

		?>
		<div class="row">
		    <div class="large-5 columns">		      
		        <?php 
		        echo form_label('Nome do site');
				echo form_input(array('name'=>'nome_site'), set_value('nome_site',get_setting('nome_site')),'autofocus');
		        ?>
		    </div>
		</div>
		
		<div class="row">
		    <div class="large-5 columns">		      
		        <?php 
		        echo form_label('URL da logomarca');
				echo form_input(array('name'=>'url_logomarca'), set_value('url_logomarca',get_setting('url_logomarca')));
		        ?>
		    </div>
		</div>
		
		<div class="row">
		    <div class="large-4 columns">		      
		        <?php 
		        echo form_label('E-mail do administrador');
				echo form_input(array('name'=>'email_adm'), set_value('email_adm',get_setting('email_adm')));
		        ?>
		    </div>
		</div>		

		<?php	
		
		echo anchor('settings/gerenciar','Cancelar',array('class'=>'button radius alert espaco'));

		echo form_submit(array('name'=>'cadastrar', 'class'=>'button radius'),'Salvar Dados');
		
		echo form_fieldset_close();
		echo form_close();
		
		?></div><?php

	break;

	default:
		echo '<div class="alert-box alert"><p>A tela solicitada não existe</p></div>';
	break;
}