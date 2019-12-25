<?php

	namespace App\Controller;
	use App\Model\Postagem;
	use App\Model\Login;
	
	class AdminController{

		public function __construct($router){
			$this->router = $router;
		}


		public function index($data){
			var_dump($data);

			$loader = new \Twig\Loader\FilesystemLoader('app/View');
			$twig = new \Twig\Environment($loader);
			$template = $twig->load('admin.html');

			try{
				$objPostagens = Postagem::selecionarTodos();
			
				$parametros = array();
				$parametros['postagens'] = $objPostagens;
				$conteudo = $template->render($parametros);
				echo $conteudo;
			}catch(\Exception $e){
				$conteudo = $template->render();
				echo $conteudo;
				echo $e->getMessage();
			}
			   
				
			

		}

		public function loginView(){

			$loader = new \Twig\Loader\FilesystemLoader('app/View');
			$twig = new \Twig\Environment($loader);
			$template = $twig->load('login.html');

			try{
				$parametros = array();
				$conteudo = $template->render($parametros);
				echo $conteudo;
			}catch(Exception $e){
				$conteudo = $template->render();
				echo $conteudo;
				echo $e->getMessage();
			}

		}


		public function login($data){
	
			try{
				$resultado = Login::recuperar($data);
				
				if(sizeof($resultado) == 1){
					#Mudar aleatoriamente o id da sessão
					session_regenerate_id();
					$_SESSION['usuario'] = $data['usuario'];
					$_SESSION['id_usuario'] = $resultado[0]->id;
					$this->router->redirect("admin.index");
				}

			}catch(\Exception $e){
				$this->router->redirect("admin.loginView");	
			}
				
		}

		public function logout(){
			
			$_SESSION = array();
	
			$this->router->redirect("home.index");
		}


		public function create(){
	
			$loader = new \Twig\Loader\FilesystemLoader('app/View');
			$twig = new \Twig\Environment($loader);
			$template = $twig->load('create.html');

			try{
 				$conteudo = $template->render();
				echo $conteudo;
			}catch(Exception $e){
				$conteudo = $template->render();
				echo $conteudo;
				echo $e->getMessage();
			}
		}

		public function insert(){
			try{
				Postagem::insert($_POST);

				$this->router->redirect("admin.index");

			}catch(\Exception $e){
				$this->router->redirect("admin.create");
			}
		}
		
		#renderiza a página html de alteração de postagens
		public function updateView($data){
			
			$loader = new \Twig\Loader\FilesystemLoader('app/View');
			$twig = new \Twig\Environment($loader);
			$template = $twig->load('update.html');
			
			try{
				$objPostagem = Postagem::retornarPostagemId($data['id']);
				
				$parametros = array();
				$parametros['titulo'] = $objPostagem->titulo;
				$parametros['conteudo'] = $objPostagem->conteudo;
				$parametros['id'] = $objPostagem->id;
				
				$conteudo = $template->render($parametros);
				echo $conteudo;
			}catch(\Exception $e){
				$conteudo = $template->render();
				echo $conteudo;
				echo $e->getMessage();
			}
			
		}
		
		public function update($data){
			try{
				
				Postagem::update($data);
				
				$this->router->redirect("admin.index");
				
			}catch(\Exception $e){
				
				$this->router->redirect("admin.updateView", ["id" => $data['id'] ]);
			}
		}
		
		public function remove($data){
			try{
				
				Postagem::remove($data['id']);
				
				$this->router->redirect("admin.index");
				
			}catch(\Exception $e){
				
				$this->router->redirect("admin.index");
			}
			
		}
		
	}