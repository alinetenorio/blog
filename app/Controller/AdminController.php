<?php

	namespace App\Controller;
	use app\Model\Postagem;
	
	class AdminController{


		public function index(){

			$loader = new \Twig\Loader\FilesystemLoader('app/View');
			$twig = new \Twig\Environment($loader);
			$template = $twig->load('admin.html');

			try{
				$objPostagens = Postagem::selecionarTodos();
			
				$parametros = array();
				$parametros['postagens'] = $objPostagens;
				$conteudo = $template->render($parametros);
				echo $conteudo;
			}catch(Exception $e){
				$conteudo = $template->render();
				echo $conteudo;
				echo $e->getMessage();
			}
			   
				
			

		}

		public function create(){
	
			$loader = new \Twig\Loader\FilesystemLoader('app/View');
			$twig = new \Twig\Environment($loader);
			$template = $twig->load('create.html');

 			$conteudo = $template->render();
			echo $conteudo;
		}

		public function insert(){
			try{
				Postagem::insert($_POST);

				echo '<script>alert("Postagem adicionada");</script>';
				echo '<script>location.href="http://localhost/projetos-aline/site_simples/admin"</script>';

			}catch(Exception $e){
				echo '<script>alert("'.$e->getMessage().'");</script>';
				echo '<script>location.href="http://localhost/projetos-aline/site_simples/admin/create"</script>';
			}
		}
		
		#renderiza a página html de alteração de postagens
		public function updateView($data){
			
			$loader = new \Twig\Loader\FilesystemLoader('app/View');
			$twig = new \Twig\Environment($loader);
			$template = $twig->load('update.html');
			
			$objPostagem = Postagem::retornarPostagemId($data['id']);
			
			$parametros = array();
			$parametros['titulo'] = $objPostagem->titulo;
			$parametros['conteudo'] = $objPostagem->conteudo;
			$parametros['id'] = $objPostagem->id;
			
			$conteudo = $template->render($parametros);
			echo $conteudo;
			
		}
		
		public function update($data){
			try{
				
				Postagem::update($data);
				
				echo '<script>alert("Postagem alterada");</script>';
				echo '<script>location.href="http://localhost/projetos-aline/site_simples/admin"</script>';
				
			}catch(Exception $e){
				echo '<script>alert("'.$e->getMessage().'");</script>';
				echo '<script>location.href="http://localhost/projetos-aline/site_simples/admin/update/$id</script>';
			}
		}
		
		public function remove($data){
			try{
				
				Postagem::remove($data['id']);
				
				echo '<script>alert("Postagem removida");</script>';
				echo '<script>location.href="http://localhost/projetos-aline/site_simples/admin"</script>';
				
			}catch(Exception $e){
				echo '<script>alert("'.$e->getMessage().'");</script>';
				echo '<script>location.href="http://localhost/projetos-aline/site_simples/admin</script>';
			}
			
		}
		
	}