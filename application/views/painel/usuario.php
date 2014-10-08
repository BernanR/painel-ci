<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

switch ($tela) {
	case 'login':
		echo '<div class="small-5 small-centered large-5 columns large-centered">';
		echo form_open('usuarios/login',array('class'=>'custom login-form'));
		echo form_fieldset('Identifique-se');
		erros_validacao();
		get_msg('logoffok');
		get_msg('errologin');		
		echo form_label('Usuário');
		echo form_input(array('name'=>'usuario'), set_value('usuario'),'autofocus');
		echo form_label('Senha');
		echo form_password(array('name'=>'senha'), set_value('senha'));
		echo form_hidden('redirect',$this->session->userdata('redir_para'));
		echo form_submit(array('name'=>'logar', 'class'=>'button radius right'),'Login');
		echo "<p>".anchor('usuarios/nova_senha','Esqueci  minha senha').'<p>';
		echo form_fieldset_close();
		echo form_close();
		echo "</div>";
	break;

	case 'nova_senha':
		echo '<div class="small-5 small-centered large-5 columns large-centered">';
		echo form_open('usuarios/nova_senha',array('class'=>'custom login-form'));
		echo form_fieldset('Recuperação de Senha');
		erros_validacao();
		get_msg('msgok');
		get_msg('msgerror');		
		echo form_label('seu email');
		echo form_input(array('name'=>'email'), set_value('email'),'autofocus');		
		echo form_submit(array('name'=>'novasenha', 'class'=>'button radius right'),'Enviar nova senha');
		echo "<p>".anchor('usuarios/login','Fazer login').'<p>';
		echo form_fieldset_close();
		echo form_close();
		echo "</div>";
	break;

	case 'cadastrar':
		?>		
		<p class="breadcrumb"><?php echo breadcrumb(); ?></p>
		<div class="small-12 large-12 columns">		
		<?php				
		echo form_open('usuarios/cadastrar',array('class'=>'custom'));
		echo form_fieldset('Cadastrar novo usuário');

		erros_validacao();
		get_msg('msgok');

		?>
		<div class="row">
		    <div class="large-5 columns">		      
		        <?php 
		        echo form_label('Nome completo');
				echo form_input(array('name'=>'nome'), set_value('nome'),'autofocus');
		        ?>
		    </div>
		</div>
		
		<div class="row">
		    <div class="large-5 columns">		      
		        <?php 
		        echo form_label('Email');
				echo form_input(array('name'=>'email'), set_value('email'));
		        ?>
		    </div>
		</div>
		
		<div class="row">
		    <div class="large-4 columns">		      
		        <?php 
		        echo form_label('Login');
				echo form_input(array('name'=>'login'), set_value('login'));
		        ?>
		    </div>
		</div>
		
		<div class="row">
		    <div class="large-3 columns">		      
		        <?php 
		        echo form_label('Senha');
				echo form_password(array('name'=>'senha'), set_value('senha'));
		        ?>
		    </div>
		</div>
		
		<div class="row">
		    <div class="large-3 columns">		      
		        <?php 
		        echo form_label('Repita a senha');
				echo form_password(array('name'=>'senha2'), set_value('senha2'));
		        ?>
		    </div>
		</div>
		
		<div class="row">
		    <div class="large-12 columns">		      
		        <?php 
		       	echo form_checkbox(array('name'=>'adm'),'1').' Criar conta de administrador<br><br>';
		        ?>
		    </div>
		</div>

		<?php	
		
		echo anchor('usuarios/gerenciar','Cancelar',array('class'=>'button radius alert espaco'));

		echo form_submit(array('name'=>'cadastrar', 'class'=>'button radius'),'Salvar Dados');
		
		echo form_fieldset_close();
		echo form_close();
		
		?></div><?php

	break;

	case 'gerenciar':?>

		<script type="text/javascript">
			$(function(){
				$('.deletareg').click(function(){
					if(confirm("deseja realmente excluir esse registro?\nEsta operação não poderá ser desfeita!"))return true;else return false;
				});
			})
		</script>
		<p class="breadcrumb"><?php echo breadcrumb(); ?></p>
		<div class="large-12 columns">
		
			<?php 
			get_msg('msgok');
			get_msg('msgerror'); 
			?>
			<table class="large-12 data-table">
				<thead>
					<tr>
						<th>Nome</th>
						<th>Login</th>
						<th>Email</th>
						<th>Ativo / Admin</th>
						<th>Ações</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$query =  $this->usuarios->get_all()->result();
					foreach ($query as $data) 
					{
						echo "<tr>";
						printf('<td class="">%s</td>',$data->nome);
						printf('<td class="">%s</td>',$data->login);
						printf('<td class="">%s</td>',$data->email);
						printf('<td class="">%s / %s</td>',($data->ativo==0)?'Não':'Sim',($data->adm==0)?'Não':'Sim');
						printf('<td class="large-centered">%s</td>',
						anchor("usuarios/editar/".$data->id_usuario,' ',array('class'=>'table-actions table-edit','title'=>'Editar')).
						anchor("usuarios/alterar_senha/".$data->id_usuario,' ',array('class'=>'table-actions table-pass','title'=>'Alterar Senha')).
						anchor("usuarios/excluir/".$data->id_usuario,' ',array('class'=>'table-actions table-delet deletareg','title'=>'Excluir')));						
						echo "</tr>";
					}
					?>
				</tbody>
				
			</table>
		</div>

	<?php
	break;
	case 'alterar_senha':
		$iduser = $this->uri->segment(3);
		if ($iduser == NULL) 
		{
			set_msg('msgerror','Requisição incompleta','error');
			redirect('usuarios/gerenciar');
		}
		?>
		<p class="breadcrumb"><?php echo breadcrumb(); ?></p>
		<div class="large-12 columns">
			<?php 
				if (stats_user(TRUE) || $iduser == $this->session->userdata('user_id'))
				{
					$query =  $this->usuarios->get_by_id($iduser)->row();

					echo form_open(current_url(),array('class'=>'custom'));
					echo form_fieldset('Alterar senha');

					erros_validacao();
					get_msg('msgok');
					?>
					<div class="row">
					    <div class="large-5 columns">		      
					        <?php 
					        echo form_label('Nome completo');
							echo form_input(array('name'=>'nome', 'disabled'=>'disabled'), set_value('nome',$query->nome));
					        ?>
					    </div>
					</div>
					
					<div class="row">
					    <div class="large-5 columns">		      
					        <?php 
					        echo form_label('Email');
							echo form_input(array('name'=>'email','disabled'=>'disabled'), set_value('email',$query->email));
					        ?>
					    </div>
					</div>
					
					<div class="row">
					    <div class="large-4 columns">		      
					        <?php 
					        echo form_label('Login');
							echo form_input(array('name'=>'login','disabled'=>'disabled'), set_value('login',$query->login));
					        ?>
					    </div>
					</div>
					
					<div class="row">
					    <div class="large-3 columns">		      
					        <?php 
					        echo form_label('Senha');
							echo form_password(array('name'=>'senha'), set_value('senha'),'autofocus');
					        ?>
					    </div>
					</div>
					
					<div class="row">
					    <div class="large-3 columns">		      
					        <?php 
					        echo form_label('Repita a senha');
							echo form_password(array('name'=>'senha2'), set_value('senha2'));
					        ?>
					    </div>
					</div>	
					
					<?php
					echo form_hidden('id_usuario',$iduser);					
					
					echo anchor('usuarios/gerenciar','Cancelar',array('class'=>'button radius alert espaco'));

					echo form_submit(array('name'=>'cadastrar', 'class'=>'button radius'),'Salvar Dados');
					
					echo form_fieldset_close();
					echo form_close();

				}else{
					//set_msg('msgerror','Você não tem permissão para alterar esse usuário','error');
					redirect('usuarios/gerenciar');
				}
			 ?>
		</div>
		<?php
	break;

	case 'editar':
		$iduser = $this->uri->segment(3);
		if ($iduser == NULL) 
		{
			set_msg('msgerror','Requisição incompleta','error');
			redirect('usuarios/gerenciar');
		}
		?>
		<p class="breadcrumb"><?php echo breadcrumb(); ?></p>
		<div class="large-12 columns">
			<?php 
				if (stats_user(TRUE) || $iduser == $this->session->userdata('user_id'))
				{
					$query =  $this->usuarios->get_by_id($iduser)->row();

					echo form_open(current_url(),array('class'=>'custom'));
					echo form_fieldset('Alterar usuarios');

					erros_validacao();
					get_msg('msgok');
					?>
					<div class="row">
					    <div class="large-5 columns">		      
					        <?php 
					        echo form_label('Nome completo');
							echo form_input(array('name'=>'nome', ), set_value('nome',$query->nome),'autofocus');
					        ?>
					    </div>
					</div>
					
					<div class="row">
					    <div class="large-5 columns">		      
					        <?php 
					        echo form_label('Email');
							echo form_input(array('name'=>'email','disabled'=>'disabled'), set_value('email',$query->email));
					        ?>
					    </div>
					</div>
					
					<div class="row">
					    <div class="large-4 columns">		      
					        <?php 
					        echo form_label('Login');
							echo form_input(array('name'=>'login','disabled'=>'disabled'), set_value('login',$query->login));
					        ?>
					    </div>
					</div>

					<div class="row">
					    <div class="large-12 columns">		      
					        <?php 
					       	echo form_checkbox(array('name'=>'ativo'),'1',($query->ativo==1)? TRUE:FALSE).' Permitir o acesso deste usuário ao sistema<br><br>';
					        ?>
					    </div>
					</div>

					<div class="row">
					    <div class="large-12 columns">		      
					        <?php 
					       	echo form_checkbox(array('name'=>'adm'),'1',($query->adm==1)?TRUE:FALSE).' Tornar essa conta de administrador<br><br>';
					        ?>
					    </div>
					</div>
					
					<?php
					echo form_hidden('id_usuario',$iduser);					
					
					echo anchor('usuarios/gerenciar','Cancelar',array('class'=>'button radius alert espaco'));

					echo form_submit(array('name'=>'cadastrar', 'class'=>'button radius'),'Salvar Dados');
					
					echo form_fieldset_close();
					echo form_close();

				}else{
					//set_msg('msgerror','Você não tem permissão para alterar esse usuário','error');
					redirect('usuarios/gerenciar');
				}
			 ?>
		</div>
		<?php
	break;

	default:
		echo '<div class="alert-box alert"><p>A tela solicitada não existe</p></div>';
	break;
}