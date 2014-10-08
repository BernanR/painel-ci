<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

switch ($tela) {	
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