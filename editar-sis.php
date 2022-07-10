<?php
    session_start();
    include_once "conexao.php";
    ob_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Editar sistema de dados">
    <meta name="keywords" content="Editar sistema de dados">
    <link rel="stylesheet" href="css/style.css">
    <title>Editar Sistema</title>
    <link rel="shortcut icon" href="img/favicon.ico" type="imagem do icone">
</head>
<body class="body-cad">

    <h1 class="animacao-1">InfoBankData!</h1>
    <h2 class="animacao-">Editar dados do Sistema</h2> 
    
    <nav class="nav">
        <a href="index.php"><button class="btn-index">Home</button></a>
        <a href="cadastro-ban.php"><button class="btn-index active">Editar Sistema</button></a>
        <a href="cadastro-sis.php"><button class="btn-index">Cadastrar Novo Sistema</button></a>
        <a href="sistemas.php"><button class="btn-index">Sistemas</button></a>
        <a href="banco-dados.php"><button class="btn-index">Banco de Dados</button></a>
        <a href="cadastro-ban.php"><button class="btn-index">Cadastrar Novo Banco</button></a>
    </nav>

    <?php
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if(!empty($dados['enviarCadSis'])) {
            //echo "<pre>".print_r($dados, true)."</pre>";

            try {

                if (isset($SESSION['msg'])) {
                    echo $SESSION['msg'];
                    unset($SESSION['msg']);
                }

                $query_up_sistema = "UPDATE sistemas SET nome=:nome, linguagem=:linguagem, descricao=:descricao, banco_dado_id=:banco_dado_id,  created=:created,  modified=:modified WHERE id=:id";

                $up_sistema = $conn->prepare($query_up_sistema);
                $up_sistema->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
                $up_sistema->bindParam(':linguagem', $dados['linguagem'], PDO::PARAM_STR);
                $up_sistema->bindParam(':descricao', $dados['descricao'], PDO::PARAM_STR);
                $up_sistema->bindParam(':banco_dado_id', $dados['banco_dado_id'], PDO::PARAM_INT);
                $up_sistema->bindParam(':created', $dados['created'], PDO::PARAM_STR);
                $up_sistema->bindParam(':modified', $dados['modified'], PDO::PARAM_STR);
                $up_sistema->bindParam(':id', $dados['id'], PDO::PARAM_INT);
                
                if ($up_sistema->execute()) {
                    $_SESSION['msg'] = "<p style='color: yellow;'>Sistema editado com sucesso!</p>";
                    header("Location: sistemas.php");
                } else {
                    //echo "<p style='color: yellow;'>Erro: Sistema não foi editado!</p>";
                    //echo "Erro: Sistema não foi editado. Erro gerando: " . $erro->getMessage() . " <br>";
                }
            } catch (PDOException $erro) {
                //echo "<p style='color: yellow;'>Erro: Sistema não foi editado!</p>";
                echo "<p style='color: yellow;'>Erro: Sistema não foi editado. Erro gerando: " . $erro->getMessage() . " </p>";
            }
        }

        //Receber o id pela URL utilizando o método GET
        $id = filter_input(INPUT_GET, "id_usuario", FILTER_SANITIZE_NUMBER_INT);

        try {
            //Pesquisar as informações do nome do Sistema no banco de dados
            $query_sistema = "SELECT id, nome, linguagem, descricao, banco_dado_id, created, modified FROM sistemas WHERE id=:id LIMIT 1";
            //Preparando a conexão
            $result_sistema = $conn->prepare($query_sistema);
            $result_sistema->bindParam(':id', $id, PDO::PARAM_INT);
            $result_sistema->execute();
            //Código para retornar uma linha do dado requerido por associação
            $row_sistema = $result_sistema->fetch(PDO::FETCH_ASSOC);
            //echo '<pre>' . print_r($row_sistema, true) . '</pre>'; //var_dump($row_sistema);            

        } catch (PDOException $erro) {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Nome do Sistema não encontrado!</p>";
            header("Location: index.php");
            //echo "Erro: Nome do Sistema não encontrado. Erro gerando: " . $erro->getMessage() . " <br>";
        }
    ?>
    
<form class="form-cad" method="POST" action="">
        <label for="lid">ID do Sistema:</label><br>
        <?php
            $id = "";
            if (isset($row_sistema['id'])) {
                $id = $row_sistema['id'];
            }
        ?>
        <input class="input-form-cad" type="text" name="id" id="lid" placeholder="Nome do Sistema de dados" value="<?php echo $id; ?>" required><br><br>


        <label for="lnome">Nome do Sistema:</label><br>
        <?php
            $nome = "";
            if (isset($row_sistema['nome'])) {
                $nome = $row_sistema['nome'];
            }
        ?>
        <input class="input-form-cad" type="text" name="nome" id="lnome" placeholder="Nome do Sistema de dados" value="<?php echo $nome; ?>" required><br><br>
        
        
        <label for="llinguagem">Linguagem usada:</label><br>
        <?php
            $linguagem = "";
            if (isset($row_sistema['linguagem'])) {
                $linguagem = $row_sistema['linguagem'];
            }
        ?>
        <input class="input-form-cad" type="text" name="linguagem" id="llinguagem" placeholder="Nome do usuário do sistema de dados" value="<?php echo $linguagem; ?>" required><br><br>
        
        
        <label for="ldescricao">Descricao:</label><br>
        <?php
            $descricao = "";
            if (isset($row_sistema['descricao'])) {
                $descricao = $row_sistema['descricao'];
            }
        ?>
        <input class="input-form-cad" type="text" name="descricao" id="ldescricao" placeholder="descricao do sistema de dados" value="<?php echo $descricao; ?>" required><br><br> 
        

        <label for="lbanco_dado_id">ID do banco de dado:</label><br>
        <?php
            $banco_dado_id = "";
            if (isset($row_sistema['banco_dado_id'])) {
                $banco_dado_id = $row_sistema['banco_dado_id'];
            }
        ?>
        <input class="input-form-cad" type="text" name="banco_dado_id" id="lbanco_dado_id" placeholder="Pertence a qual banco de dados" value="<?php echo $banco_dado_id; ?>" required><br><br>
        
        
        <label for="lcreated">Criacao:</label><br>
        <?php
            $created = "";
            if (isset($row_sistema['created'])) {
                $created = $row_sistema['created'];
            }
        ?>
        <input class="input-form-cad" type="text" name="created" id="lcreated" placeholder="Data da criação dos dados sistema de dados" value="<?php echo $created; ?>" required><br><br>
        
        
        <label for="lmodified">Modificação:</label><br>
        <?php
            $modified = "";
            if (isset($row_sistema['modified'])) {
                $modified = $row_sistema['modified'];
            }
        ?>
        <input class="input-form-cad" type="text" name="modified" id="lmodified" placeholder="Data da Modificação dos dados do sistema" value="<?php echo $modified; ?>" required>

        <input class="btn btn-form" type="submit" value="Enviar" name="enviarCadSis">
           
    </form>
</body>
</html>    