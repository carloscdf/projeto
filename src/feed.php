<?php 
    session_start();
    include("../classes/Usuario.php");
    include("../classes/Producao.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Os filmes e séries mais recomendados para você</title>

    <link rel="stylesheet" href="../style/feed.css">
</head>
<body>
    <?php 
        if(isset($_SESSION["usuario"])){
    ?>
    <nav>
        <h2>ReelFriends</h2>

        <div class="pesquisa-container">
            <input type="text" name="pesquisa" id="pesquisa">
        </div>

        <div class="perfil">
            <?php
                $usuario = new Usuario($_SESSION["usuario"]);
                echo "<span>".$usuario->getNome()."</span>";
                $usuario->getPerfil();
            ?>

        </div>
    </nav>
    <main>
        <menu>
            <ul>
                <li><a href="">Filmes</a></li>
                <li><a href="">Séries</a></li>
            </ul>
        </menu>

        <section>
            <?php 
                $sql = new MySQL;

                $rows = $sql->pesquisaProducoes();

                if($rows == null){
                    echo "<h1>Ops...    :(</h1>";
                    echo "<p>Parece que não há nenhuma produção cadastrada na plataforma. Clique no botão + para adicionar algum você mesmo</p>";
                }

                else{
                    foreach($rows as $item){
                        $producao = new Producao($item["titulo_producao"], $item["sinopse_producao"], $item["genero_idgenero"], $item["categoria_idcategoria"], $item["diretor_iddiretor"]);

                        ?>
                        <a class="producao" href="producao.php?prod=<?php echo $item["idproducao"]?>">
                            <img class="imgprod" src="<?php echo $producao->getCapa()?>" alt="<?php echo $producao->getTitulo()?>">

                            <div class="info">
                                <h2><?php echo $producao->getTitulo()?></h2>
                                <p><?php echo $producao->getCategoria()." de ".$producao->getDiretor()?></p>
                                <p><?php echo $producao->getSinopse()?></p>
                            </div>
                        </a>
            <?php   }
                }
            ?>
            <a href="cadastro_producoes.php">+</a>

        </section>
    </main>
    <?php 
        } else{
            header("Location: index.php");
        }
    ?>
</body>
</html>