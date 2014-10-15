<script type="text/javascript">
	$(function(){
		/*$('.addimg').click(function(e){
			alert('oie');
			e.preventDefault();
			$('#modalimg').show(500);
		});*/
		$('.buscarimg').click(function(){
			
			var destino = "<?php echo base_url('midias/get_imgs') ?>";
			var dados   = $(".buscartxt").serialize();

			$.ajax({    //chama ajax				
				type: 'POST', //método post
	            url: destino, //url do arquivo que ele vai rodar
	            
	            data:{ 
	                data:dados                
	            },

	            success: function(data)
	            {                
	                        
	                $("#retorno").html(data);                   
	            }
	        });
		});
	});

	
</script>

<div id="myModal" class="reveal-modal xlarge" data-reveal>
	<div class="row collapse">
		<br/>
		<div class="large-8 columns">
			<?php echo form_input(array('name'=>'pesquisarimg','class'=>'buscartxt')); ?>
		</div>
		<div class="large-2 columns">
			<?php echo form_button('','Buscar','class="buscarimg button postfix"'); ?>			
		</div>		
		<div class="large-2 columns">
			<?php echo form_button('','Limpar','class="limparimg button postfix alert radius"'); ?>
		</div>
	</div>
	<div id="retorno">&nbsp;</div>
	<a class="close-reveal-modal">&#215;</a>
</div>
