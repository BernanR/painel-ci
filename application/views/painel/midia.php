<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

switch ($tela) {	
	case 'cadastrar':
		?>		
		<p class="breadcrumb"><?php echo breadcrumb(); ?></p>
		<div class="small-12 large-12 columns">		
		<?php				
		echo form_open_multipart('midias/cadastrar',array('class'=>'custom'));
		echo form_fieldset('Upload de mídia');

		erros_validacao();
		get_msg('msgok');
		get_msg('msgerror');

		?>
		<div class="row">
		    <div class="large-5 columns">		      
		        <?php 
		        echo form_label('Nome para exibição');
				echo form_input(array('name'=>'nome'), set_value('nome'),'autofocus');
		        ?>
		    </div>
		</div>
		
		<div class="row">
		    <div class="large-5 columns">		      
		        <?php 
		        echo form_label('Descrição');
				echo form_input(array('name'=>'descricao'), set_value('descricao'));
		        ?>
		    </div>
		</div>
		
		<div class="row">
		    <div class="large-12 columns">		      
		        <?php 
		        echo form_label('Arquivo');
				echo form_upload(array('name'=>'arquivo'), set_value('arquivo'));
		        ?>
		    </div>
		</div>
		<?php	
		
		echo anchor('midias/gerenciar','Cancelar',array('class'=>'button radius alert espaco'));

		echo form_submit(array('name'=>'cadastrar', 'class'=>'button radius'),'Salvar Dados');
		
		echo form_fieldset_close();
		echo form_close();		
		?>
		</div>
		<?php
	break;
	case 'gerenciar':?>
		<script type="text/javascript">
			$(function(){
				$('.deletareg').click(function(){
					if(confirm("deseja realmente excluir esse registro?\nEsta operação não poderá ser desfeita!"))return true;else return false;
				});
				$('.link').on('click', function(){
					$(this).select();
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
						<th>Miniatura</th>
						<th>Nome</th>
						<th>Link</th>						
						<th class="tex-center">Ações</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$query =  $this->midias->get_all()->result();
					foreach ($query as $data) 
					{
						echo "<tr>";
						printf('<td class="">%s</td>',thumb($data->arquivo));
						printf('<td class="">%s</td>',$data->nome);
						printf('<td><input class="link" type="text" value="%s"/></td>',base_url("medias/images/uploads/".$data->arquivo));
						printf('<td class="">%s</td>',
						anchor("medias/images/uploads/".$data->arquivo,' ',array('class'=>'table-actions table-view','title'=>'Visualizar','target'=>'_blank')).
						anchor("midias/editar/".$data->id_midia,' ',array('class'=>'table-actions table-edit','title'=>'Editar')).
						anchor("midias/excluir/".$data->id_midia,' ',array('class'=>'table-actions table-delet deletareg','title'=>'Excluir')));
					}
					?>
				</tbody>				
			</table>
		</div>
	<?php
	break;

	case 'editar':
		$idmidia = $this->uri->segment(3);
		if ($idmidia == NULL) 
		{
			set_msg('msgerror','Requisição incompleta','error');
			redirect('midias/gerenciar');
		}
		?>
		<p class="breadcrumb"><?php echo breadcrumb(); ?></p>
		<div class="large-12 columns">
			<?php 
				if (stats_user())
				{
					$query =  $this->midias->get_by_id($idmidia)->row();

					echo form_open(current_url(),array('class'=>'custom'));
					echo form_fieldset('Alterar usuarios');

					erros_validacao();
					get_msg('msgok');
					?>
					<div class="large-8 columns">
						<div class="row">
						    <div class="large-8 columns">		      
						        <?php 
						        echo form_label('Nome para exibição');
								echo form_input(array('name'=>'nome'), set_value('nome',$query->nome),'autofocus');
						        ?>
						    </div>
						</div>
						
						<div class="row">
						    <div class="large-12 columns">		      
						        <?php 
						        echo form_label('Descrição');
								echo form_input(array('name'=>'descricao'), set_value('descricao',$query->descricao));
						        ?>
						    </div>
						</div>
					
						<?php
						echo form_hidden('id_midia',$idmidia);					
						
						echo anchor('midias/gerenciar','Cancelar',array('class'=>'button radius alert espaco'));

						echo form_submit(array('name'=>'editar', 'class'=>'button radius'),'Salvar Dados');					
						?>
					</div>
					<div class="large-4 columns">
						<p class="right"><?php echo thumb($query->arquivo, 380,180) ?></p>						
					</div>
					
					<?php
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