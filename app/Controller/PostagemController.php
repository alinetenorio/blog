<?php

	class PostagemController{


		public function index($params){
			
			$id = $params['id'];
			
			try{
				
				$postagem = Postagem::retornarPostagemId($id);
				$comentarios = Comentario::selecionarTodos($id);

				

				$loader = new \Twig\Loader\FilesystemLoader('app/View');
				$twig = new \Twig\Environment($loader);
				$template = $twig->load('postagem.html');

				$parametros = array();
				$parametros['titulo'] = $postagem->titulo;
				$parametros['conteudo'] = $postagem->conteudo;
				$parametros['comentarios'] = $comentarios;
				   
				$conteudo = $template->render($parametros);
				echo $conteudo;

				
			}catch(Exception $e){
				echo $e->getMessage();
			}


		}

	}