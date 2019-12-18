<?php

	namespace App\Controller;
	use app\Model\Postagem;

	#Se comunica com o model para recuperar conteúdo do banco de dados;
	#Define em qual página esse conteúdo será exibido;
	#Renderiza a página e dá um output no template renderizado(apenas a parte
	#dinâmica da página home.
	#Esse output é capturado pelo index.php
	class HomeController{


		public function index(){
			
			
			#twig: template engine para php. 
			#{{...}}: output; {%...%}: executar comandos
			#template engine: biblioteca que combina templates e modelos de dados,
			#são definidas partes estáticas e dinâmicas do app
			
			#os templates do folder View sao carregados para um environment criado
			$loader = new \Twig\Loader\FilesystemLoader('app/View');
			$twig = new \Twig\Environment($loader);
			
			$template = $twig->load('home.html');
				
			try{
				$colecaoPostagem = Postagem::selecionarTodos();

				$parametros = array();
				$parametros['postagens'] = $colecaoPostagem;
				   
				#render: renderiza o template com os $parametros
				$conteudo = $template->render($parametros);
				echo $conteudo;

				
			}catch(Exception $e){
				#render: renderiza o template e mostra mensagem de erro
				$conteudo = $template->render();
				echo $conteudo;
				echo $e->getMessage();
			}


		}
		
		public function error($data){
			echo "Erro " . $data['errcode'];
		}
	}