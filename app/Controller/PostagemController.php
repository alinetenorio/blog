<?php
	namespace App\Controller;
	use app\Model\Postagem;
	use app\Model\Comentario;
	#use app\View\postagem;
	

	class PostagemController{


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
				$parametros['comentarios'] = $comentarios;
				$parametros['id_post'] = $data['id'];
				
				$conteudo = $template->render($parametros);
				echo $conteudo;

				
			}catch(Exception $e){
				echo $e->getMessage();
			}


		}

		public function insertComentario(){
			
			try{
				
				Comentario::insert($_POST);
				
				echo '<script>alert("Comentário adicionado");</script>';
				echo '<script>location.href="http://localhost/projetos-aline/site_simples/postagem/'.$_POST['id_postagem'].'"</script>';
				
				

			}catch(Exception $e){
				echo '<script>alert("'.$e->getMessage().'");</script>';
				echo '<script>location.href="http://localhost/projetos-aline/site_simples/?pagina=postagem&todo=index&id"=.$id</script>';
			}
		}
		
	}