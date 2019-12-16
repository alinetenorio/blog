<?php

	class AdminController{


		public function index(){

			$loader = new \Twig\Loader\FilesystemLoader('app/View');
			$twig = new \Twig\Environment($loader);
			$template = $twig->load('admin.html');

			$objPostagens = Postagem::selecionarTodos();

			$parametros = array();
			$parametros['postagens'] = $objPostagens;
			   
			$conteudo = $template->render($parametros);
			echo $conteudo;

		}

		public function create(){
	
			$loader = new \Twig\Loader\FilesystemLoader('app/View');
			$twig = new \Twig\Environment($loader);
			$template = $twig->load('create.html');

			$parametros = array();
			  
 			$conteudo = $template->render($parametros);
			echo $conteudo;
		}

		public function insert(){
			try{
				Postagem::insert($_POST);

				echo '<script>alert("Postagem adicionada");</script>';
				echo '<script>location.href="http://localhost/projetos-aline/site_simples/?pagina=admin&todo=index"</script>';

			}catch(Exception $e){
				echo '<script>alert("'.$e->getMessage().'");</script>';
				echo '<script>location.href="http://localhost/projetos-aline/site_simples/?pagina=admin&todo=create"</script>';
			}
		}
		
		#renderiza a página html de alteração de postagens
		public function updateView($params){
			$loader = new \Twig\Loader\FilesystemLoader('app/View');
			$twig = new Twig\Environment($loader);
			$template = $twig->load('update.html');
			
			$objPostagem = Postagem::retornarPostagemId($params['id']);
			
			$parametros = array();
			$parametros['titulo'] = $objPostagem->titulo;
			$parametros['conteudo'] = $objPostagem->conteudo;
			$parametros['id'] = $objPostagem->id;
			
			$conteudo = $template->render($parametros);
			echo $conteudo;
			
		}
		
		public function update($params){
			try{
				
				$_POST['id'] = $params['id'];
				var_dump($_POST);
				
				
				Postagem::update($_POST);
				
				echo '<script>alert("Postagem alterada");</script>';
				echo '<script>location.href="http://localhost/projetos-aline/site_simples/?pagina=admin&todo=index"</script>';
				
			}catch(Exception $e){
				echo '<script>alert("'.$e->getMessage().'");</script>';
				echo '<script>location.href="http://localhost/projetos-aline/site_simples/?pagina=admin&todo=update&id="=.$id</script>';
			}
		}
	}