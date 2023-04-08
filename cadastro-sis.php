<?php
    session_start();
    include_once "conexao.php";
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
<body class="body-ajust body-cad">

    <h1 class="animacao-">InfoBankData!</h1>
    <h2 class="animacao-">Cadastro de Sistema</h2>
    <img src="img/sistemas.png" alt="sistemas" width="200" height="100">
    <p>Campos que  contém (<span class="campo-obrigatorio">*</span>) são obrigatórios.</p>
    
    <nav class="nav">
        <a href="index.php"><button class="btn-index">Home</button></a>
        <a><button class="btn-index active">Cadastrar Novo Sistema</button></a>
        <a href="sistemas.php"><button class="btn-index">Sistemas</button></a>
        <a href="banco-dados.php"><button class="btn-index">Banco de Dados</button></a>
        <a href="cadastro-ban.php"><button class="btn-index">Cadastrar Novo Banco</button></a>
    </nav>

    <?php
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($dados["enviarCadSis"])) {
            //echo "<pre>".print_r($dados, true)."</pre>";
            try {
                if (isset($_SESSION['msgs'])) {
                    echo $_SESSION['msgs'];
                    unset($_SESSION['msgs']);
                }
                $query_sistema = ("INSERT INTO sistemas (nome, linguagem_id, descricao_id, banco_dado_id, created, modified) VALUES (:nome, :linguagem_id, :descricao_id, :banco_dado_id, NOW(), NOW())");        
                $cad_sistema = $conn->prepare($query_sistema);
                $cad_sistema->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
                $cad_sistema->bindParam(':linguagem_id', $dados['linguagem_id'], PDO::PARAM_STR);
                $cad_sistema->bindParam(':descricao_id', $dados['descricao_id'], PDO::PARAM_STR);
                $cad_sistema->bindParam(':banco_dado_id', $dados['banco_dado_id'], PDO::PARAM_INT);
                $cad_sistema->execute();
                if ($cad_sistema->rowCount()) {
                    $_SESSION['msgs'] = "<p style='color: yellow;'>Sistema cadastrado com sucesso!</p>";
                    unset($dados);
                    header("Location: sistemas.php");
                } else {
                    $_SESSION['msgs'] = "<p style='color: #f00;'>Erro: Sistema não foi cadastrado!</p>";
                    header("Location: cadastro-sis.php");
                }
            } catch (PDOException $erro) {
                echo "<p style='color: yellow;'>Erro: Sistema não foi cadastrado.</p><br>";
                //echo "<p style='color: yellow;'>Erro: Sistema não foi cadastrado. Erro gerado: " . $erro->getMessage() . "</p>";
                header("Location:cadastro-sis.php");
            }
        } else {                
            $_SESSION['msgs'] = "<p style='color: yellow;'>Erro: Sistema não foi cadastrado. </p>";
            //header("Location:cadastro-sis.php");
        }
    ?>

    <!-- formulario cadastrar -->
    <form class="form-cad" method="POST" action="">
        <!-- nome -->
        <label for="nome">Nome:<span class="campo-obrigatorio">*</span></label><br>
        <?php
            $nome = "";
            if (isset($dados['nome'])) {
                $nome = $dados['nome'];
            }
        ?>
        <input class="input-form-cad" type="text" name="nome" id="nome" placeholder="Digite o nome do sistema" value="<?php echo $nome; ?>" required><br><br>
        <!-- fim nome -->

        <!-- display linguagem e descricao -->
        <div class="cont-form">

            <!-- linguagem -->
            <?php
            $query_linguagem = "SELECT id, name FROM linguagem ORDER BY name ASC";
            $result_linguagem = $conn->prepare($query_linguagem);
            $result_linguagem->execute();
            ?>
            <div class="select-lgm">
                <label class="cont-lb-form">Linguagem Usada: </label><br>
                <select class="align-cont-form" name="linguagem_id">
                    <option value="">Selecione</option>
                    <?php
                    while($row_linguagem = $result_linguagem->fetch(PDO::FETCH_ASSOC)){
                        extract($row_linguagem);

                        $select_linguagem = "";
                        if(isset($dados['linguagem_id']) and ($dados['linguagem_id'] == $id)){
                            $select_linguagem = "selected";
                        } elseif(((!isset($dados['linguagem_id'])) and (isset($row_sistema['linguagem_id']))) and ($row_sistema['linguagem_id'] == $id)){
                            $select_linguagem = "selected";
                        }
                        echo "<option value='$id' $select_linguagem>$name</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- fim linguagem -->

            <!-- descricao -->
            <?php
            $query_descricao = "SELECT id, name FROM descricao ORDER BY name ASC";
            $result_descricao = $conn->prepare($query_descricao);
            $result_descricao->execute();
            ?>
            <div class="select-dcc">
                <label class="cont-lb-form">Descrição da Aplicação: </label><br>
                <select class="align-cont-form" name="descricao_id">
                    <option value="">Selecione</option>
                    <?php
                    while($row_descricao = $result_descricao->fetch(PDO::FETCH_ASSOC)){
                        extract($row_descricao);

                        $select_descricao = "";
                        if(isset($dados['descricao_id']) and ($dados['descricao_id'] == $id)){
                            $select_descricao = "selected";
                        } elseif(((!isset($dados['descricao_id'])) and (isset($row_sistema['descricao_id']))) and ($row_sistema['descricao_id'] == $id)){
                            $select_descricao = "selected";
                        }

                        echo "<option value='$id' $select_descricao>$name</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- fim descricao -->   
        </div>
        <!-- fim display linguagem e descricao -->

        <!-- banco_dados -->
        <?php
        $query_bancos_dados = "SELECT id, nome_banco FROM bancos_dados ORDER BY nome_banco ASC";
        $result_bancos_dados = $conn->prepare($query_bancos_dados);
        $result_bancos_dados->execute();
        ?>
        <div>
            <label class="cont-lb-form">Banco de dados: </label><br>
            <select class="input-form-cad" name="banco_dado_id">
                <option value="">Selecione</option>
                <?php
                while($row_bancos_dados = $result_bancos_dados->fetch(PDO::FETCH_ASSOC)){
                    extract($row_bancos_dados);

                    $select_bancos_dados = "";
                    if(isset($dados['banco_dado_id']) and ($dados['banco_dado_id'] == $id)){
                        $select_bancos_dados = "selected";
                    } elseif(((!isset($dados['banco_dado_id'])) and (isset($row_sistema['banco_dado_id']))) and ($row_sistema['banco_dado_id'] == $id)){
                        $select_bancos_dados = "selected";
                    }

                    echo "<option value='$id' $select_bancos_dados>$nome_banco</option>";
                }
                ?>
            </select>
        </div>
        <!-- fim banco_dados -->

        <input class="btn btn-form" type="submit" value="Enviar" name="enviarCadSis">
        <span class="space-complete"></span>
    </form>
    <!-- fim formulario cadastrar -->
</body>
</html>
