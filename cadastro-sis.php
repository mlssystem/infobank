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
    <meta name="description" content="Cadastro de sistema">
    <meta name="keywords" content="Cadastro de sistema">
    <link rel="stylesheet" href="css/style.css">
    <title>Cadastrar Novo Sistema</title>
    <link rel="shortcut icon" href="img/favicon.ico" type="imagem do icone">
</head>
<body class="body-cad">

    <h1 class="animacao-1">InfoBankData!</h1>
    <h2 class="animacao-1">Cadastro de Sistema</h2>
    <p>Campos que  contém (<span class="campo-obrigatorio">*</span>) são obrigatórios.</p>
    
    <nav class="nav">
        <a href="index.php"><button class="btn-index">Home</button></a>
        <a href="cadastro-sis.php"><button class="btn-index active">Cadastrar Novo Sistema</button></a>
        <a href="sistemas.php"><button class="btn-index">Sistemas</button></a>
        <a href="banco-dados.php"><button class="btn-index">Banco de Dados</button></a>
        <a href="cadastro-ban.php"><button class="btn-index">Cadastrar Novo Banco</button></a>
    </nav>

    <?php
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($dados["enviarCadSis"])) {
            //echo "<pre>".print_r($dados, true)."</pre>";

            try {    

                if (isset($SESSION['msg'])) {
                    echo $SESSION['msg'];
                    unset($SESSION['msg']);
                }

                $query_sistema = "INSERT INTO sistemas (nome, linguagem, descricao, banco_dado_id, created, modified) VALUES (:nome, :linguagem, :descricao, :banco_dado_id, NOW(), NOW())";
        
                $cad_sistema = $conn->prepare($query_sistema);
                $cad_sistema->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
                $cad_sistema->bindParam(':linguagem', $dados['linguagem'], PDO::PARAM_STR);
                $cad_sistema->bindParam(':descricao', $dados['descricao'], PDO::PARAM_STR);
                $cad_sistema->bindParam(':banco_dado_id', $dados['banco_dado_id'], PDO::PARAM_INT);
                $cad_sistema->execute();
                if ($cad_sistema->rowCount()) {
                    $_SESSION['msg'] = "<p style='color: yellow;'>Sistema cadastrado com sucesso!</p>";
                    unset($dados);
                    header("Location: index.php");
                } else {
                    echo "<p style='color: #f00;'>Erro: Sistema não foi cadastrado!</p>";
                }

            } catch (PDOException $erro) {
                echo "<p style='color: yellow;'>Erro: Sistema não foi cadastrado!</p>";                
                $_SESSION['msg'] = "<p style='color: yellow;'>Erro: Sistema não foi cadastrado. Erro gerado: " . $erro->getMessage() . "</p>";
                //header("Location:index.php");
            }
        } else {                
            $_SESSION['msg'] = "<p style='color: yellow;'>Erro: Sistema não foi cadastrado. </p>";
            //header("Location:index.php");
        }
    ?>

    <form class="form-cad" method="POST" action="">
        <label for="lnome">Nome:<span class="campo-obrigatorio">*</span></label><br>
        <?php
            $nome = "";
            if (isset($dados['nome'])) {
                $nome = $dados['nome'];
            }
        ?>
        <input class="input-form-cad" type="text" name="nome" id="lnome" placeholder="Digite o nome do sistema" value="<?php echo $nome; ?>" required><br><br>


        <label for="llinguagem">Linguagem:<span class="campo-obrigatorio">*</span></label><br>
        <?php
            $linguagem = "";
            if (isset($dados['linguagem'])) {
                $linguagem = $dados['linguagem'];
            }
        ?>
        <input class="input-form-cad" type="text" name="linguagem" id="linguagem" placeholder="Digite a linguagem usada para desenvolvimento" value="<?php echo $linguagem; ?>" required><br><br>


        <label for="ldescricao">Descrição:<span class="campo-obrigatorio">*</span></label><br>
        <?php
            $descricao = "";
            if (isset($dados['descricao'])) {
                $descricao = $dados['descricao'];
            }
        ?>
        <input class="input-form-cad" type="text" name="descricao" id="ldescricao" placeholder="Campo para informações adicionais" value="<?php echo $descricao; ?>" required><br><br>


        <label for="lbanco_dado_id">Id do banco:<span class="campo-obrigatorio">*</span></label><br>
        <?php
            $banco_dado_id = "";
            if (isset($dados['banco_dado_id'])) {
                $banco_dado_id = $dados['banco_dado_id'];
            }
        ?>
        <input class="input-form-cad" type="text" name="banco_dado_id" id="lbanco_dado_id" placeholder="Identificação do banco de dados" value="<?php echo $banco_dado_id; ?>" required>
       
        <input class="btn btn-form" type="submit" value="Enviar" name="enviarCadSis">

    </form>
</body>
</html>    