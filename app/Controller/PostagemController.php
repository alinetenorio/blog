<?php
	namespace App\Controller;
	use app\Model\Postagem;
	use app\Model\Comentario;
	#use app\View\postagem;
	

	class PostagemController{

		public function __construct($router){
			$this->router = $router;
		}


		public function index($data){
			
			try{
	
				
				$postagem = Postagem::retornarPostagemId($data['id']);
				$comentarios = Comentario::selecionarTodos($data['id']);

				

				$loader = new \Twig\Loader\FilesystemLoader('app/View');
				$twig = new \Twig\Environment($loader);
				$template = $twig->load('postagem.html');

				$parametros = array();
				$parametros['titulo'] = $postagem->titulo;
				$parametros['conteudo'] = $postagem->conteudo;
				$parametros['data'] = $postagem->data;
				$parametros['tag'] = $postagem->tag;
				$parametros['comentarios'] = $comentarios;
				$parametros['id_post'] = $data['id'];
				
				$conteudo = $template->render($parametros);
				echo $conteudo;

				
			}catch(Exception $e){
				echo $e->getMessage();
			}


		}

		public function insertComentario($data){
			
			try{
				
				Comentario::insert($data);
				
				
				$this->router->redirect("post.index", ["id" => $data['id_postagem']]);
				
				

			}catch(Exception $e){
				$this->router->redirect("post.index", ["id" => $data['id_postagem']]);
				
			}
		}
		
	}