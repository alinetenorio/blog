<?php

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
require_once 'app/Controller/AdminController.php';
require_once 'app/Model/Postagem.php';
require_once 'app/Model/Comentario.php';
require_once 'lib/Database/Conexao.php';
require_once 'app/Config.php';

#Composer(dependency manager) handles autoloading automatically,  the following line of code
# 	will allow you to load all your referenced packages:
require_once 'vendor/autoload.php';

use CoffeeCode\Router\Router;
#use app\Controller\HomeController;

#Lê o arquivo passado e o retorna como string
$template = file_get_contents('app/Template/estrutura.html');

#ob_start: Ativa o output buffering. Salva tudo que normalmente seria printado na tela
#	->Start remembering everything that would normally be outputted, 
#	but don't quite do anything with it yet
#ob_get_contents(): Retorna tudo que foi salvo no buffer
#ob_end_clean(): para de salvar e descarta tudo que há no buffer
ob_start();

	$router = new Router (URL_BASE);

	#Controladores
	$router->namespace("App\Controller");

	#Home
	$router->group(null); 
	$router->get("/", "HomeController:index");
	$router->get("/home", "HomeController:index");
	
	#Sobre
	$router->group(null); 
	$router->get("/sobre", "SobreController:index");

	#Postagem
	$router->group("postagem");
	$router->get("/{id}", "PostagemController:index");
	$router->post("/{id}/addComentario", "PostagemController:insertComentario");
	
	#Admin
	$router->group("admin");
	$router->get("/", "AdminController:index");
	$router->get("/create", "AdminController:create");
	$router->post("/insert", "AdminController:insert");
	$router->get("/updateView/{id}", "AdminController:updateView");
	$router->post("/update/{id}", "AdminController:update");
	$router->get("/remove/{id}", "AdminController:remove");
	
	#Erro
	$router->group("ooops");
	$router->get("/{errcode}", "ErroController:index");
	
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

