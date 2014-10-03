<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php if(isset($titulo)): ?> {titulo} | <?php endif; ?> {titulo_padrao}</title>
    {headerinc}  
</head>
<body>
	<?php if(user_logout(FALSE)){ ?>
		<div class="row header">
			<div class="large-8 columns">
				<a href="<?php echo base_url('painel') ?>"><h1>Painel ADM</h1></a>				
			</div>
			<div class="large-4 columns">
				<p class="text-right">Logado como <strong><?php echo $this->session->userdata('user_nome'); ?></strong></p>
				<p class="text-right">
					<?php echo anchor('usuarios/alterar_senha/'.$this->session->userdata('user_id'),'Alterar senha','class="button radius tiny"'); ?>
					<?php echo anchor('usuarios/logoff/','Sair','class="button radius tiny alert"'); ?>
				</p>
			</div>
			<div class="row">
				<div class="large-12 columns menu-site">
					<nav class="top-bar" data-topbar role="navigation">						
						<section class="top-bar-section">
							<ul class="left">
								<li class="active"><?php echo anchor('painel','Inicio'); ?></li>					
								<li class="has-dropdown">	
									<?php //echo anchor('usuarios/gerenciar','Usuários'); ?>	
									<a href="#">Usuários</a>				
									<ul class="dropdown">									
										<li><?php echo anchor('usuarios/cadastrar','Cadastrar'); ?></li>
										<li><?php echo anchor('usuarios/gerenciar','Gerenciar'); ?></li>								
									</ul>
								</li>						
							</ul>
							<!-- Left Nav Section -->
						</section>
					</nav>					
				</div>
				
			</div>		
		</div>
	<?php } ?>
	<div class="row painel-adm">
		{conteudo}
	</div>
	<div class="row rodape">
		<div class="large-12 columns text-center">
			{rodape}
		</div>
	</div>
</body>
</html>