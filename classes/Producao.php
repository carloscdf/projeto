<?php 
    class Producao{
        private $titulo;
        private $sinopse;
        private $dtlancamento;
        private $genero;
        private $categoria;
        private $diretor;
        private $capa;

        function __construct($titulo, $sinopse, $dtlancamento, $genero, $categoria, $diretor)
        {
            $sql = new MySQL;
            
            $this->titulo = $titulo;
            $this->sinopse = $sinopse;
            $this->dtlancamento = $dtlancamento;

            $this->genero = $sql->pesquisaIdGenero($genero);
            $this->categoria = $sql->pesquisaIdCategoria($categoria);
            $this->diretor = $sql->pesquisaIdDiretor($diretor);

            $this->capa = "../img/producao/capa/$titulo-$diretor.png";
        }

        function getTitulo(){
            return $this->titulo;
        }

        function getSinopse(){
            return $this->sinopse;
        }

        function getDtLancamento(){
            return $this->dtlancamento;
        }

        function getGenero(){
            return $this->genero;
        }

        function getCategoria(){
            return $this->categoria;
        }

        function getDiretor(){
            return $this->diretor;
        }

        function getCapa(){
            return $this->capa;
        }

        function getNotaMedia(){
            $somaNotas = 0;
            $contador = 0;
            $sql = new MySQL;
            $id = $sql->pesquisaTituloDiretorProducao($this->titulo, $this->diretor)["idproducao"];
            $rows = $sql->pesquisaAvaliacoes($id);

            if($rows == null){
                return 0;
            }
            else{
                foreach($rows as $avaliacoes){
                    $somaNotas += $avaliacoes["nota"];
                    $contador++;
                }

                $notaMedia = $somaNotas/$contador;

                return $notaMedia;
            }
        }
    }
?>