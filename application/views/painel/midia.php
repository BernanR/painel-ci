<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

switch ($tela) {	
	case 'cadastrar':
		?>		
		<p class="breadcrumb"><?php echo breadcrumb(); ?></p>
		<div class="small-12 large-12 columns">		
		<?php				
		echo form_open_multipart('midia/cadastrar',array('class'=>'custom'));
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
				echo form_input(array('name'=>'decricao'), set_value('decricao'));
		        ?>
		    </div>
		</div>
		
		<div class="row">
		    <div class="large-12 columns">		      
		        <?php 
		        echo form_label('Arquivo');
		        echo "<input type='file' name='arquivo'/>";
				//echo form_upload(array('name'=>'arquivo'), set_value('arquivo'));
		        ?>
		    </div>
		</div>
		<?php	
		
		echo anchor('midia/gerenciar','Cancelar',array('class'=>'button radius alert espaco'));

		echo form_submit(array('name'=>'cadastrar', 'class'=>'button radius'),'Salvar Dados');
		
		echo form_fieldset_close();
		echo form_close();		
		?>
		</div>
		<?php
	break;
	case 'gerenciar':?>

		<p class="breadcrumb"><?php echo breadcrumb(); ?></p>
		<div class="large-12 columns">		
			<?php 
			get_msg('msgok');
			get_msg('msgerror'); 
			$modo = $this->uri->segment(3);
			if ($modo == 'all') {
				$limit = 0;
			}else
			{
				$limit = 5;
				echo '<p>Mostrando os útimos 50 registros, para ver todo histórico' .anchor('auditoria/gerenciar/all','Clique aqui').'</p>';
			}
			?>	
			<table class="large-12 data-table">
				<thead>
					<tr>
						<th>Usuário</th>
						<th>Data e hora</th>
						<th>Operação</th>
						<th>Observação</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$query =  $this->auditoria->get_all($limit)->result();
					foreach ($query as $data) 
					{
						echo "<tr>";
						printf('<td class="">%s</td>',$data->usuario);
						printf('<td class="">%s</td>',date('d/m/Y H:i:s', strtotime($data->data_hora)));
						printf('<td class="">%s</td>','<span class="has-tip tip-top" title="'.$data->query.'">'.$data->operacao.'</span>');
						printf('<td class="">%s</td>',$data->observacao);
					}
					?>
				</tbody>				
			</table>
		</div>
	<?php
	break;	

	default:
		echo '<div class="alert-box alert"><p>A tela solicitada não existe</p></div>';
	break;
}