<?php

	namespace App\Model;
	use lib\Database\Conexao;
	use \Exception;
	
	class Postagem{
		#Estabelece uma conexão com o banco de dados e recupera suas informações

		public static function  selecionarTodos(){
			$conexao = Conexao::getConexao();
			

			$sql = "SELECT * FROM postagem ORDER BY id DESC";
			$sql = $conexao->prepare($sql);
			$sql->execute();

			$resultado = array();

			while($row = $sql->fetchObject(Postagem::class)){
				$resultado[] = $row;
			}

			if(!$resultado){
				throw new Exception("Não foi encontrada nenhuma postagem");
				
			}
			
			return $resultado;
		}

		public static function retornarPostagemId($id){
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

		public static function buscarPorTag($tag){
			$conexao = Conexao::getConexao();

			$sql = "SELECT * FROM postagem WHERE tag= :tag";
			$sql = $conexao->prepare($sql);
			$sql->bindValue(':tag', $tag);
			$sql->execute();

			$resultado = array();

			while($row = $sql->fetchObject(Postagem::class)){
				$resultado[] = $row;
			}

			if(!$resultado){
				throw new Exception("Não foi encontrado nenhum registro");
			}

			return $resultado;
		}

		public static function buscarPorData($month_int){
			$conexao = Conexao::getConexao();

			$sql = "SELECT * FROM postagem WHERE MONTH(data)= :month";
			$sql = $conexao->prepare($sql);
			$sql->bindValue(':month', $month_int);
			$sql->execute();

			$resultado = array();

			while($row = $sql->fetchObject(Postagem::class)){
				$resultado[] = $row;
			}

			if(!$resultado){
				throw new Exception("Não foi encontrado nenhum registro");
			}

			return $resultado;
		}

		public static function insert($params){

			if(empty($params['titulo']) || empty($params['conteudo'])){
				throw new Exception("Campos vazios");
				return false;
			}

			$conexao = Conexao::getConexao();

			$sql = "INSERT INTO postagem (titulo, conteudo, tag, data) VALUES (:tit, :cont, :tag, CURDATE())";
			$sql = $conexao->prepare($sql);
			$sql->bindValue(':tit', $params['titulo']);
			$sql->bindValue(':cont', $params['conteudo']);
			$sql->bindValue(':tag', $params['tag']);
			$resultado = $sql->execute();

			if($resultado == false){
				throw new Exception("Falha ao adicionar");
			}

			return true;
		}
		
		public static function update($params){
			
			if(empty($params['titulo']) || empty($params['conteudo'])){
				throw new Exception("Campos vazios");
				return false;
			}
			
			$conexao = Conexao::getConexao();
			
			$sql = "UPDATE postagem SET titulo = :tit, conteudo = :cont, tag=:tag, data = CURDATE() 
					WHERE id = :id";
					
			$sql = $conexao->prepare($sql);
			
			$sql->bindValue(':tit', $params['titulo']);
			$sql->bindValue(':cont', $params['conteudo']);
			$sql->bindValue(':tag', $params['tag']);
			$sql->bindValue(':id', $params['id']);
			
			$resultado = $sql->execute();

			if($resultado == false){
				throw new Exception("Falha ao alterar");
			}

			return true;
		}
		
		public static function remove($id){
			
			
			$conexao = Conexao::getConexao();
			
			$sql = "DELETE FROM postagem WHERE id = :id";
					
			$sql = $conexao->prepare($sql);
			
			$sql->bindValue(':id', $id);
			
			$resultado = $sql->execute();

			if($resultado == false){
				throw new Exception("Falha ao deletar");
			}

			return true;
		}

	}