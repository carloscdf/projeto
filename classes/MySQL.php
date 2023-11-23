<?php 
    class MySQL{
        const MYSQL_HOST = "localhost";
        const MYSQL_USER = "root";
        const MYSQL_PASSWORD = "";
        const MYSQL_DB_NAME = "banco_reelfriends";
        private $PDO;

        function __construct()
        {
            try {
                $this->PDO = new PDO('mysql:host=' . MySQL::MYSQL_HOST . ';dbname=' . MySQL::MYSQL_DB_NAME, MySQL::MYSQL_USER, MySQL::MYSQL_PASSWORD);
                $this->PDO->exec("set names utf8");
            } catch (PDOException $e) {
                echo 'Erro ao conectar com o MySQL:' . $e->getMessage();
            }
        }

        function pesquisaEmailUsuario($email){
            $search = $email;
            $sql = "SELECT * FROM usuario WHERE email_usuario LIKE :s";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows[0];
        }

        function pesquisaNomeUsuario($username){
            $search = $username;   
            $sql = "SELECT * FROM usuario WHERE nome_usuario LIKE :s";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        }

        function cadastraUsuario($username, $email, $senha){
            $sql = "INSERT into usuario(nome_usuario, email_usuario, senha_usuario) VALUES(:nome, :email, :senha)";

            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':nome', $username);   //vincula
            $stmt->bindParam(':email', $email);     //vincula
            $stmt->bindParam(':senha', $senha);     //vincula

            $result = $stmt->execute();     //executa

            if(!$result){
                var_dump($stmt->errorInfo());
                    exit;
                }
            else{
                echo $stmt->rowCount()." linhas inseridas";
                session_start();
                $_SESSION["usuario"] = $email; //salva na session o email do usuário criado
                header("Location: feed.php");
            }
        }

        function pesquisaProducoes(){
            $sql = "SELECT * FROM producao";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        }

        function pesquisaIdProducao($id){
            $search = $id;
            $sql = "SELECT * FROM producao WHERE idproducao LIKE :s";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows[0];
        }

        function verificaProducao($titulo, $diretor){
            $sql = "SELECT * FROM producao p WHERE p.diretor_iddiretor = $diretor ";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if($rows != null){

                $cont = 0;

                foreach($rows as $producao){
                    if($producao["titulo_producao"] == $titulo){
                        $cont++;
                    }
                }

                if($cont == 0){
                    return true;
                } else {
                    return false;
                }

            } else {
                return true;
            }
        }

        function cadastraProducao($titulo, $sinopse, $dtlancamento, $genero, $categoria, $diretor){
            $sql = "INSERT into producao(titulo_producao, sinopse_producao, dt_lancamento_producao, genero_idgenero, categoria_idcategoria, diretor_iddiretor) VALUES(:titulo, :sinopse, :dtlancamento, :genero, :categoria, :diretor)";

            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':titulo', $titulo);   //vincula
            $stmt->bindParam(':sinopse', $sinopse);     //vincula
            $stmt->bindParam(':dtlancamento', $dtlancamento);     //vincula
            $stmt->bindParam(':genero', $genero);     //vincula
            $stmt->bindParam(':categoria', $categoria);     //vincula
            $stmt->bindParam(':diretor', $diretor);     //vincula

            $result = $stmt->execute();     //executa

            if(!$result){
                var_dump($stmt->errorInfo());
                    exit;
                }
            else{
                echo $stmt->rowCount()." linhas inseridas";
                session_start();
                header("Location: feed.php");
            }
        }

        function pesquisaDiretores(){
            $sql = "SELECT * FROM diretor";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        }

        function pesquisaIdDiretor($id){
            $search = $id;   
            $sql = "SELECT * FROM diretor WHERE iddiretor LIKE :s";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows[0]["nome_diretor"];
        }

        function pesquisaCategorias(){
            $sql = "SELECT * FROM categoria";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        }

        function pesquisaIdCategoria($id){
            $search = $id;
            $sql = "SELECT * FROM categoria WHERE idcategoria LIKE :s";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows[0]["descricao_categoria"];
        }

        function pesquisaGeneros(){
            $sql = "SELECT * FROM genero";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        }

        function pesquisaIdGenero($id){
            $search = $id;
            $sql = "SELECT * FROM genero WHERE idgenero LIKE :s";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows[0]["descricao_genero"];
        }

        function cadastraAvaliacao($userEmail, $idProducao, $nota){
            $idusuario = $this->pesquisaEmailUsuario($userEmail)["idusuario"];

            $sql = "INSERT into usuario_avalia_producao(usuario_idusuario, producao_idproducao, nota) VALUES(:usuario, :producao, :nota)";

            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':usuario', $idusuario);   //vincula
            $stmt->bindParam(':producao', $idProducao);     //vincula
            $stmt->bindParam(':nota', $nota);     //vincula

            $result = $stmt->execute();     //executa

            if(!$result){
                var_dump($stmt->errorInfo());
                    exit;
                }
            else{
                echo "Avaliação registrada com sucesso";
            }
        }

        function verificaAvaliacao($userEmail, $idProducao){
            $idusuario = $this->pesquisaEmailUsuario($userEmail)["idusuario"];

            $search = $idusuario;
            $sql = "SELECT * FROM usuario_avalia_producao WHERE usuario_idusuario LIKE :s";
            $stmt = $this->PDO->prepare($sql);    //prepara
            $stmt->bindParam(':s', $search);    //vincula
            $result = $stmt->execute();    //executa
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if($rows == null){
                return true;
            } else {
                return false;
            }
        }
    }
?>