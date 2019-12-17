<?php

	class PostagemController{


		public function index($id){
			
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
				$parametros['id_post'] = $id;
				   
				$conteudo = $template->render($parametros);
				echo $conteudo;

				
			}catch(Exception $e){
				echo $e->getMessage();
			}


		}

		public function insertComentario(){
			try{
				
				Comentario::insert($_POST);
				var_dump($_POST);
				
				echo '<script>alert("Comentário adicionado");</script>';
				echo '<script>location.href="http://localhost/projetos-aline/site_simples/?pagina=postagem&todo=index&id='.$_POST['id_postagem'].'"</script>';
				
				

			}catch(Exception $e){
				echo '<script>alert("'.$e->getMessage().'");</script>';
				echo '<script>location.href="http://localhost/projetos-aline/site_simples/?pagina=postagem&todo=index&id"=.$id</script>';
			}
		}
		
	}