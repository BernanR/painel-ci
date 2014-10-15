<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

switch ($tela) {	
	case 'cadastrar':
		?>		
		<p class="breadcrumb"><?php echo breadcrumb(); ?></p>
		<div class="small-12 large-12 columns">		
		<?php				
		echo form_open('paginas/cadastrar',array('class'=>'custom'));
		echo form_fieldset('Cadastrar nova página');
		
		erros_validacao();
		get_msg('msgok');
		get_msg('msgerror');

		?>
		<div class="row">
		    <div class="large-5 columns">		      
		        <?php 
		        echo form_label('Título');
				echo form_input(array('name'=>'titulo'), set_value('titulo'),'autofocus');
		        ?>
		    </div>
		</div>

		<div class="row">
		    <div class="large-5 columns">		      
		        <?php 
		        echo form_label('Slug');
				echo form_input(array('name'=>'slug'), set_value('slug'));
		        ?>
		    </div>
		</div>

		<div class="row">
		    <div class="large-12 columns">		      
		        <?php 
		        echo form_label('Coteudo');
				echo form_textarea(array('name'=>'conteudo', 'id'=>'html-editor',), set_value('conteudo'));
		        ?>
		    </div>
		</div>
		<?php	
		init_editorhtml();
		echo anchor('paginas/gerenciar','Cancelar',array('class'=>'button radius alert espaco'));

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
						<th>Título</th>
						<th>Link</th>
						<th>Resumo</th>						
						<th class="tex-center">Ações</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$query =  $this->paginas->get_all()->result();
					foreach ($query as $data) 
					{
						echo "<tr>";
						printf('<td class="">%s</td>',$data->titulo);
						printf('<td class="">%s</td>',$data->slug);
						printf('<td>%s</td>',resumo($data->conteudo,10));
						printf('<td class="">%s</td>',
						anchor("paginas/editar/".$data->id_pagina,' ',array('class'=>'table-actions table-edit','title'=>'Editar')).
						anchor("paginas/excluir/".$data->id_pagina,' ',array('class'=>'table-actions table-delet deletareg','title'=>'Excluir')));
					}
					?>
				</tbody>				
			</table>
		</div>
	<?php
	break;

	case 'editar':
		$idpagina = $this->uri->segment(3);
		if ($idpagina == NULL) 
		{
			set_msg('msgerror','Requisição incompleta','error');
			redirect('paginas/gerenciar');
		}
		?>
		<p class="breadcrumb"><?php echo breadcrumb(); ?></p>
		<div class="large-12 columns">
			<?php 
				if (stats_user())
				{
					$query =  $this->paginas->get_by_id($idpagina)->row();

					echo form_open(current_url(),array('class'=>'custom'));
					echo form_fieldset('Alterar usuarios');

					erros_validacao();
					get_msg('msgok');
					?>

					<div class="row">
					    <div class="large-5 columns">		      
					        <?php 
					        echo form_label('Título');
							echo form_input(array('name'=>'titulo'), set_value('titulo',$query->titulo),'autofocus');
					        ?>
					    </div>
					</div>

					<div class="row">
					    <div class="large-5 columns">		      
					        <?php 
					        echo form_label('Slug');
							echo form_input(array('name'=>'slug'), set_value('slug',$query->slug));
					        ?>
					    </div>
					</div>
					<a href="#" class="button tiny" data-reveal-id="myModal">Inserir imagens</a>
					<?php echo anchor('midia/cadastrar','Upload de imagens','class="button tiny secondary radius"','target="_blank"'); ?>
					<div class="row">
					    <div class="large-12 columns">		      
					        <?php 
					        echo form_label('Coteudo');
							echo form_textarea(array('name'=>'conteudo', 'id'=>'html-editor',), set_value('conteudo',to_html($query->conteudo)));
					        ?>
					    </div>
					</div>

				
					<?php
					//incluir modal de incluir imagem
					incluir_arquivo('modalimg');

					echo form_hidden('id_pagina',$idpagina);					
					
					echo anchor('paginas/gerenciar','Cancelar',array('class'=>'button radius alert espaco'));

					echo form_submit(array('name'=>'editar', 'class'=>'button radius'),'Salvar Dados');					
					?>					
										
					<?php
					echo form_fieldset_close();
					echo form_close();
					
					//adciona o editor html
					init_editorhtml();


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