<?php

if (session_status() != PHP_SESSION_ACTIVE):
    session_start();
endif;

#Faz os imports; chama o método start() do Core; salva os outputs
#	gerados em um buffer; substitui a area dinamica do template do site
#	pelo conteudo do buffer; imprime o template modificado
#index.php should be as bare-boned as you can make it because it will 
#	be re-sent every time a new page is loaded


#No index.php serão feitos todos os imports dos arquivos php

##VER AUTOLOAD DOC OMPOOSER
require_once 'app/Controller/HomeController.php';
require_once 'app/Controller/ErroController.php';
require_once 'app/Controller/PostagemController.php';
require_once 'app/Controller/SobreController.php';
require_once 'app/Controller/BuscaController.php';
require_once 'app/Controller/AdminController.php';
require_once 'app/Model/Postagem.php';
require_once 'app/Model/Comentario.php';
require_once 'app/Model/Login.php';
require_once 'lib/Database/Conexao.php';
require_once 'app/Config.php';

#Composer(dependency manager) handles autoloading automatically,  the following line of code
# 	will allow you to load all your referenced packages:
require_once 'vendor/autoload.php';

use CoffeeCode\Router\Router;
#use app\Controller\HomeController;

#Lê o arquivo passado e o retorna como string
if( isset($_SESSION['usuario'])){
	$template = file_get_contents('app/Template/estrutura_admin.html');
}else{
	$template = file_get_contents('app/Template/estrutura_visitante.html');
}

#ob_start: Ativa o output buffering. Salva tudo que normalmente seria printado na tela
#	->Start remembering everything that would normally be outputted, 
#	but don't quite do anything with it yet
#ob_get_contents(): Retorna tudo que foi salvo no buffer

#ob_end_clean(): para de salvar e descarta tudo que há no buffer
ob_start();
	//var_dump($_SESSION['usuario']);

	$router = new Router (URL_BASE);

	#Controladores
	$router->namespace("App\Controller");

	#Home
	$router->group(null); 
	$router->get("/", "HomeController:index", "home.index");
	$router->get("/home", "HomeController:index", "home.index");
	
	#Sobre
	$router->group(null); 
	$router->get("/sobre", "SobreController:index", "sobre.index");

	#Busca
	$router->group("busca");
	$router->get("/{tag}","BuscaController:index", "busca.index");
	$router->get("/data/{tag}","BuscaController:porData", "busca.data");

	#Postagem
	$router->group("postagem");
	$router->get("/{id}", "PostagemController:index", "post.index");
	$router->post("/{id}/addComentario", "PostagemController:insertComentario");
	
	#Admin
	$router->group("admin");
	$router->get("/", "AdminController:index", "admin.index");
	$router->get("/loginView", "AdminController:loginView", "admin.loginView");
	$router->post("/login", "AdminController:login");
	$router->get("/logout", "AdminController:logout");
	$router->get("/create", "AdminController:create", "admin.create");
	$router->post("/insert", "AdminController:insert");
	$router->get("/updateView/{id}", "AdminController:updateView", "admin.updateView");
	$router->post("/update/{id}", "AdminController:update");
	$router->get("/remove/{id}", "AdminController:remove");
	
	#Erro
	$router->group("ooops");
	$router->get("/{errcode}", "ErroController:index", "erro.index");
	
	$router->dispatch();
	
	if($router->error()){
		$router->redirect("/ooops/{$router->error()}");
	}

	$saida = ob_get_contents();
ob_end_clean();

#procura a string {{area_dinamica}} no estrutura.html, e o substitui pela saída
#gerada pelo buffer.
$template_pronto = str_replace('{{area_dinamica}}', $saida, $template);

echo $template_pronto;

