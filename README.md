## General info

Painel de administração de conteúdo - CodeIgniter - Foundation.
Esse projeto foi desenvolvido com base em um curso que eu fiz. Esse modelo foi usado em varios outros projetos que eu desenvolvi ao longo de minha carreira,
também foi melhorado ao longo do tempo.

## Technologies
Project is created with:
* CodeIgniter 
* Foundation

Aqui esta um exemplo de algumas funções criadas que pode te ajudar no desenvolvimento de um novo projeto.

Através da função set_tema(), você pode adicionar qualquer coisa na view.
Essa função recebe 3 parâmetros, são eles: o id que é do tipo string e deve ser referenciada na view, por exemplo "conteudo" e onde você deve referênciar na view da seguinte forma: {conteudo}.
Em segundo temos o código htm, texto ou uma chamada js, css por exemplo.
E em terceiro temos um parâmetro do bollean onde será informado se esse dados será empilhado ou não, caso informe false, será ignorado todos chamdas refernciada anteriormente para o id.
Um exemplo simples de como referenciar essa função no controle:
```
public function inicio()
{
	set_tema('titulo','HOME');
	set_tema('conteudo','<h1>Olá Mundo</h1>',FALSE);
	load_template();
		
}
```
  Note que na primeira linha é adicionado um titulo para a página. E a função load_template(); ficará responsável por carregar as alterações feitas anteriomente.
  E na view ficaria da seguinte forma:

```
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    	<title><?php if(isset($titulo)): ?> {titulo} | <?php endif; ?> {titulo_padrao}</title>
</head>
<body>
	<div class="row painel-adm">		
		{conteudo}
	</div>
</body>
</html>
```
Dai você poderá referenciar varios outros ids para sua view, tendo em vista que é necessário adicionar os ids no html como por exemplo: {{headerinc}} que poerá receber todas as chamadas css, assim como {{footerinc}} para os js.

caso tenha alguma dúvida, esse é meu e-mail: alves.bernan@gmail.com
