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
<body class="body-ajust body-cad">

    <h1 class="animacao-">InfoBankData!</h1>
    <h2 class="animacao-">Editar dados do Sistema</h2> 
    
    <nav class="nav">
        <a href="index.php"><button class="btn-index">Home</button></a>
        <a><button class="btn-index active">Editar Sistema</button></a>
        <a href="cadastro-sis.php"><button class="btn-index">Cadastrar Novo Sistema</button></a>
        <a href="sistemas.php"><button class="btn-index">Sistemas</button></a>
    </nav>

    <?php
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if(!empty($dados['enviarCadSis'])) {
            //echo "<pre>".print_r($dados, true)."</pre>";
            try {
                if (isset($_SESSION['msgs'])) {
                    echo $_SESSION['msgs'];
                    unset($_SESSION['msgs']);
                }
                $query_up_sistema = "UPDATE sistemas SET nome=:nome, linguagem_id=:linguagem_id, descricao_id=:descricao_id, banco_dado_id=:banco_dado_id, modified = NOW() WHERE id=:id";
                $up_sistema = $conn->prepare($query_up_sistema);
                $up_sistema->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
                $up_sistema->bindParam(':linguagem_id', $dados['linguagem_id'], PDO::PARAM_STR);
                $up_sistema->bindParam(':descricao_id', $dados['descricao_id'], PDO::PARAM_STR);
                $up_sistema->bindParam(':banco_dado_id', $dados['banco_dado_id'], PDO::PARAM_INT);
                $up_sistema->bindParam(':id', $dados['id'], PDO::PARAM_INT);                
                if ($up_sistema->execute()) {
                    $_SESSION['msgs'] = "<p style='color: yellow;'>Sistema editado com sucesso!</p>";
                    header("Location: sistemas.php");
                } else {
                    echo "<p style='color: yellow;'>Erro: Sistema não foi editado!</p>";
                    //echo "Erro: Sistema não foi editado. Erro gerando: " . $erro->getMessage() . " <br>";
                }
            } catch (PDOException $erro) {
                echo "<p style='color: yellow;'>Erro: Sistema não foi editado!</p>";
                //echo "<p style='color: yellow;'>Erro: Sistema não foi editado. Erro gerando: " . $erro->getMessage() . " </p>";
            }
        }
        //Receber o id pela URL utilizando o método GET
        $id = filter_input(INPUT_GET, "id_usuario", FILTER_SANITIZE_NUMBER_INT);
        try {
            //Pesquisar as informações do nome do Sistema no banco de dados
            $query_sistema = "SELECT id, nome, linguagem_id, descricao_id, banco_dado_id, created, modified FROM sistemas WHERE id=:id LIMIT 1";
            //Preparando a conexão
            $result_sistema = $conn->prepare($query_sistema);
            $result_sistema->bindParam(':id', $id, PDO::PARAM_INT);
            $result_sistema->execute();
            //Código para retornar uma linha do dado requerido por associação
            $row_sistema = $result_sistema->fetch(PDO::FETCH_ASSOC);
            //echo '<pre>' . print_r($row_sistema, true) . '</pre>'; //var_dump($row_sistema);            

        } catch (PDOException $erro) {
            $_SESSION['msgs'] = "<p style='color: #f00;'>Erro: Nome do Sistema não encontrado!</p>";
            header("Location: index.php");
            //echo "Erro: Nome do Sistema não encontrado. Erro gerando: " . $erro->getMessage() . " <br>";
        }
    ?>    
<form class="form-cad" method="POST" action="">
        <!-- id -->
        <?php
            $id = "";
            if (isset($row_sistema['id'])) {
                $id = $row_sistema['id'];
            }
        ?>
        <input class="input-form-cad" type="hidden" name="id" id="lid" placeholder="Nome do Sistema de dados" value="<?php echo $id; ?>" required><br>
        <!-- fim id -->

        <!-- nome -->
        <label for="lnome">Nome do Sistema:</label><br>
        <?php
            $nome = "";
            if (isset($row_sistema['nome'])) {
                $nome = $row_sistema['nome'];
            }
        ?>
        <input class="input-form-cad" type="text" name="nome" id="lnome" placeholder="Nome do Sistema de dados" value="<?php echo $nome; ?>" required><br>
        <!-- fim nome -->
        
        <!-- display linguagem descricao -->
        <div class="cont-form">
            <!-- query linguagem -->
            <?php
            $query_linguagem = "SELECT id, name FROM linguagem ORDER BY name ASC";
            $result_linguagem = $conn->prepare($query_linguagem);
            $result_linguagem->execute();
            ?>
            <!-- select linguagem -->
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
            <!-- fim select linguagem -->

            <!-- query descricao -->
            <?php
            $query_descricao = "SELECT id, name FROM descricao ORDER BY name ASC";
            $result_descricao = $conn->prepare($query_descricao);
            $result_descricao->execute();
            ?>
            <!-- select descricao -->
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
            <!-- fim select descricao -->  
        </div>
        <!-- fim display linguagem descricao -->

        <!-- query danco de dados -->
        <?php
        $query_bancos_dados = "SELECT id, nome_banco FROM bancos_dados ORDER BY nome_banco ASC";
        $result_bancos_dados = $conn->prepare($query_bancos_dados);
        $result_bancos_dados->execute();
        ?>
        <!-- select danco de dados -->
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
        <!-- fim select danco de dados -->
        <input class="btn btn-form" type="submit" value="Enviar" name="enviarCadSis">
    </form>
</body>
</html>
