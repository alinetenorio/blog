<?php
	namespace lib\Database;
	use \PDO;

	abstract class Conexao{
		#Estabelece uma conexão com um banco de dados, utilizando a classe PDO do PHP

		private static $conexao;

		public static function getConexao(){

			#se ainda não foi estabelecida uma conexão com o BD, criar uma
			#essa verificação é feita para que não haja mais de uma conexão
			#em aberto com o banco de dados
			if(self::$conexao == null){
				self::$conexao = new PDO('mysql: host=localhost;port=3306; dbname=site_simples', 'root', '');
			}
			
			return self::$conexao;
		}
	}