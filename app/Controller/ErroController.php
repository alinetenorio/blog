<?php

	namespace App\Controller;
	class ErroController{

		public function __construct($router){
			$this->router = $router;
		}

		public function index($data){

			echo 'página de erro<br><br>';
			echo "Erro " . $data['errcode'];
			
		}

	}