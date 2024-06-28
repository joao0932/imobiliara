<?php
 
require_once 'Banco.php';
require_once 'Conexao.php';
 
class Usuario extends Banco{
 
    private $id;
    private $login;
    private $senha;
    private $permissao;
 
    public function getId(){
        return $this->id;
    }
 
    public function setId($id){
        $this->id = $id;
    }
 
    public function getLogin(){
        return $this->login;
    }
 
    public function setLogin($login){
        $this->login = $login;
    }
 
    public function getSenha(){
        return $this->senha;
    }
 
    public function setSenha($senha){
        $this->senha = $senha;
    }
 
    public function getPermissao(){
        return $this->permissao;
    }
 
    public function setPermissao($permissao){
        $this->permissao = $permissao;
    }

    public function save(){

        $result = false;

        //cria um objeto do tipo conexao
        $conexao = new Conexao();
        //cria query de inserção passando os atributos que serão armazenados
        $query = "insert into usuario (id, login, senha, permissao) values (null,:login,:senha,:permissao)";
        //cria a conexão com o banco de dados
        if($conn = $conexao->getConection()){
            if($this->id > 0){
                //cria query de update passando os atributos que serão atualizados
                $query = "UPDATE usuario SET login = :login, senha = :senha, permissao = :permissao WHERE id = :id";           
                //Prepara a query para execução
                $stmt = $conn->prepare($query);
                //executa a query
                if($stmt->execute(array(':id' => $this->id, ':login' => $this->login, ':senha' => $this->senha, ':permissao' => $this->permissao))){
                    $result = $stmt->rowCount();
                }
            }
            else{
                //cria query de inserção passando os atributos que serão armazenados
                $query = "insert into usuario (id, login, senha, permissao) values (null,:login,:senha,:permissao)";
                //Prepara a query para execução
                $stmt = $conn->prepare($query);
                if($stmt->execute(array(':login' => $this->login, ':senha' => $this->senha, ':permissao' => $this->permissao))){
                    $result = $stmt->rowCount();
                }
            }
        }
        return $result;
    }

    public function remove($id){
        
        $result = false;
        //Cria um objeto do tipo conexão
        $conexao = new Conexao();
        //Cria a conexao com o banco de dados
        $conn = $conexao->getConection();
        //Cria query de remoção
        $query = "DELETE FROM usuario where id = :id";
        //Prepara a query para execução
        $stmt = $conn->prepare($query);
        //Executa a query
        if ($stmt->execute(array(':id'=> $id))) {
            $result = true;
        }
        return $result;
    }

    public function find($id){

        //Cria um objeto do tipo conexão
        $conexao = new Conexao();
        //Cria a conexao com o banco de dados
        $conn = $conexao->getConection();
        //Cria query de seleção
        $query = "SELECT * FROM usuario where id = :id";
        //Prepara a query para execução
        $stmt = $conn->prepare($query);
        //executa a query
        if ($stmt->execute(array(':id'=> $id))) {
            //verifica se houve algum registro encontrado
            if ($stmt->rowCount() > 0) {
                //o resultado da busca será retornado como um objeto de classe
                $result = $stmt->fetchObject(Usuario::class);
            }else{
                $result = false;
            }
        }
        return $result;
    }

    public function listAll(){
        //cria um objeto do tipo conexao
        $conexao = new Conexao();
        //cria a conexao com o banco de dados
        $conn = $conexao->getConection();
        //cria query de seleção
        $query = "SELECT * FROM usuario";
        //prepara a query para a execução
        $stmt = $conn->prepare($query);
        //Cria um array para receber o resultado da seleção
        $result = array();
        //executa a query
        if($stmt->execute()){
            //O resultado da busca será retornado como o um objeo de classe
            while($rs = $stmt->fetchObject(Usuario::class)){
                //armazena esse objeto em uma posição do vetor
                $result[] = $rs;
            }
        } else {
            $result = false;
        }
 
        return $result;
    }

    public function count(){

    }


}
?>