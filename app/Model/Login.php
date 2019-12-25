<?php

	namespace App\Model;
	use lib\Database\Conexao;
	use \Exception;
	
	class Login{
		#Estabelece uma conexão com o banco de dados e recupera suas informações

		public static function  recuperar($data){
			if(empty($data['usuario']) || empty($data['senha'])){
				throw new Exception("Campos vazios");
				return false;
			}

			$conexao = Conexao::getConexao();
		

			$sql = "SELECT * FROM admin WHERE usuario=:usr AND senha =:sen";

			$sql = $conexao->prepare($sql);

			$sql->bindValue(':usr', $data['usuario']);
			$sql->bindValue(':sen', $data['senha']);

			$sql->execute();

			while($row = $sql->fetchObject(Login::class)){
				$resultado[] = $row;
			}

			if(!$resultado){
				throw new Exception("Usuário inválido");
			}
			
			return $resultado;
		}

		public static function logout($id){
			$conexao = Conexao::getConexao();

			$sql = "SELECT * FROM postagem WHERE id= :id";
			$sql = $conexao->prepare($sql);
			$sql->bindValue(':id', $id);
			$sql->execute();

			$resultado = $sql->fetchObject(Postagem::class);

			if(!$resultado){
				throw new Exception("Não foi encontrado esse registro");
			}

			return $resultado;
		}

	

	}