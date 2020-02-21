<?php

	namespace App\Controller;

	#Se comunica com o model para recuperar conteúdo do banco de dados;
	#Define em qual página esse conteúdo será exibido;
	#Renderiza a página e dá um output no template renderizado(apenas a parte
	#dinâmica da página home.
	#Esse output é capturado pelo index.php
	class EstruturaController{

		public function __construct($router){
			$this->router = $router;
		}

		public function index($saida, $ator){
			
			if($ator == 'admin'){
				$template = file_get_contents('app/Template/estrutura_admin.html');

				$template = str_replace('{{link_sair}}', $this->router->route('admin.logout'), $template);
			}else{
				$template = file_get_contents('app/Template/estrutura_visitante.html');
			}

			$template = str_replace('{{URL_BASE}}', URL_BASE, $template);


			$template = str_replace('{{area_dinamica}}', $saida, $template);

			$template = str_replace('{{link_home}}', $this->router->route('home.index'), $template);

			$template = str_replace('{{link_php}}', $this->router->route('busca.index', ['tag'=>'php']), $template);

			$template = str_replace('{{link_laravel}}', $this->router->route('busca.index', ['tag'=>'laravel']), $template);

			//$template = str_replace('{{link_portfolio}}', $this->router->route('portfolio.index'), $template);

			//$template = str_replace('{{link_contato}}', $this->router->route('contato.index'), $template);

			$template = str_replace('{{link_sobre}}', $this->router->route('sobre.index'), $template);

			$template = str_replace('{{link_admin}}', $this->router->route('admin.index'), $template);

			$template = str_replace('{{link_jan}}', $this->router->route('busca.data', ['tag'=>'jan']), $template);

			$template = str_replace('{{link_feb}}', $this->router->route('busca.data', ['tag'=>'feb']), $template);

			return $template;

		

		}

		public function admin($saida){
			
		}
		
	}