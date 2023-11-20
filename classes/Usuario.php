<?php 
    class Usuario{
        private $username;
        private $email;
        private $perfil;

        function __construct($email)
        {
            include("../classes/MySQL.php");
            $sql = new MySQL;

            $rows = $sql->pesquisaEmailUsuario($email);

            $this->username = $rows["nome_usuario"];
            
            $this->email = $rows["email_usuario"];

            $this->perfil = "../img/usuario/perfil/".$rows["nome_usuario"]."-".$rows["idusuario"].".png";
        }

        function getNome(){
            return $this->username;
        }

        function getEmail(){
            return $this->email;
        }

        function getPerfil(){
            $fotos = glob($this->perfil);
            if($fotos == null){
                echo "<img class = 'foto-perfil' src='../img/usuario/perfil/0.png' alt='".$this->username."'>";
            }
            else{
                echo "<img class = 'foto-perfil' src='".$this->perfil."' alt='".$this->username."'>";
            }
        }


    }
?>