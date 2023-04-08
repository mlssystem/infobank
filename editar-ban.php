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
    <meta name="description" content="Editar banco de dados">
    <meta name="keywords" content="Editar banco de dados">
    <link rel="stylesheet" href="css/style.css">
    <title>Editar Banco de Dado</title>
    <link rel="shortcut icon" href="img/favicon.ico" type="imagem do icone">
</head>
<body class="body-ajust body-cad">
    <h1 class="animacao-">InfoBankData!</h1>
    <h2 class="animacao-">Editar banco de dado</h2>
    <img src="img/database.png" alt="Banco de dados" width="180" height="110">
    
    <nav class="nav">
        <a href="index.php"><button class="btn-index">Home</button></a>
        <a><button class="btn-index active">Editar Banco</button></a>
        <a href="cadastro-ban.php"><button class="btn-index">Cadastrar Novo Banco</button></a>
        <a href="banco-dados.php"><button class="btn-index">Banco de Dados</button></a>
    </nav>

    <?php
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if(!empty($dados['enviarCadSis'])) {
            //echo "<pre>".print_r($dados, true)."</pre>";
            try {
                if (isset($_SESSION['msgb'])) {
                    echo $_SESSION['msgb'];
                    unset($_SESSION['msgb']);
                }                
                $query_up_banco = ("UPDATE bancos_dados SET nome_banco=:nome_banco, usuario=:usuario, senha=:senha, localhost=:localhost, modified = NOW() WHERE id=:id");
                $up_banco = $conn->prepare($query_up_banco);
                $up_banco->bindParam(':nome_banco', $dados['nome_banco'], PDO::PARAM_STR);
                $up_banco->bindParam(':usuario', $dados['usuario'], PDO::PARAM_STR);
                //$senha_cript = password_hash($dados['senha'], PASSWORD_DEFAULT);
                //$up_banco->bindParam(':senha', $senha_cript);
                $up_banco->bindParam(':senha', $dados['senha'], PDO::PARAM_STR);
                $up_banco->bindParam(':localhost', $dados['localhost'], PDO::PARAM_STR);
                $up_banco->bindParam(':id', $dados['id'], PDO::PARAM_INT);                
                if ($up_banco->execute()) {
                    $_SESSION['msgb'] = "<p style='color: yellow;'>Banco editado com sucesso!</p>";
                    header("Location: banco-dados.php");
                } else {
                    echo "<p style='color: yellow;'>Erro: Banco não foi editado!</p>";
                    //echo "Erro: Banco não foi editado. Erro gerando: " . $erro->getMessage() . " <br>";
                }
            } catch (PDOException $erro) {
                echo "<p style='color: yellow;'>Erro: Banco não foi editado!</p>";
                //echo "<p style='color: yellow;'>Erro: Banco não foi editado. Erro gerando: " . $erro->getMessage() . "</p>";
            }
        }
        //Receber o id pela URL utilizando o método GET
        $id = filter_input(INPUT_GET, "id_usuario", FILTER_SANITIZE_NUMBER_INT);
        try {
            //Pesquisar as informações do nome do banco no banco de dados
            $query_banco = "SELECT id, nome_banco, usuario, senha, localhost, created, modified FROM bancos_dados WHERE id=:id LIMIT 1";
            //Preparando a conexão
            $result_banco = $conn->prepare($query_banco);
            $result_banco->bindParam(':id', $id, PDO::PARAM_INT);
            $result_banco->execute();
            //Código para retornar uma linha do dado requerido por associação
            $row_banco = $result_banco->fetch(PDO::FETCH_ASSOC);
            //echo '<pre>' . print_r($row_banco, true) . '</pre>'; //var_dump($row_banco);  
        } catch (PDOException $erro) {
            $_SESSION['msgb'] = "<p style='color: #f00;'>Erro: Nome do banco não encontrado!</p>";
            header("Location: index.php");
            //echo "Erro: Nome do banco não encontrado. Erro gerando: " . $erro->getMessage() . " <br>";
        }
    ?>
<form class="form-cad" method="POST" action="">
        <!-- id -->
        <?php
            $id = "";
            if (isset($row_banco['id'])) {
                $id = $row_banco['id'];
            }
        ?>
        <input type="hidden" class="input-form-cad" type="number" name="id" id="lid" placeholder="Nome do banco de dados" value="<?php echo $id; ?>" required><br><br>
        <!-- fim id -->

        <!-- nome do banco -->
        <label for="lnome_banco">Nome do Banco:</label><br>
        <?php
            $nome_banco = "";
            if (isset($row_banco['nome_banco'])) {
                $nome_banco = $row_banco['nome_banco'];
            }
        ?>
        <input class="input-form-cad" type="text" name="nome_banco" id="lnome_banco" placeholder="Nome do banco de dados" value="<?php echo $nome_banco; ?>" required><br><br>
        <!-- fim nome do banco -->

        <!-- usuario do banco -->
        <label for="lusuario">Usuário do Banco:</label><br>
        <?php
            $usuario = "";
            if (isset($row_banco['usuario'])) {
                $usuario = $row_banco['usuario'];
            }
        ?>
        <input class="input-form-cad" type="text" name="usuario" id="lusuario" placeholder="Nome do usuário do banco de dados" value="<?php echo $usuario; ?>" required><br><br>
        <!-- fim usuario do banco -->

        <!-- senha -->
        <label for="lsenha">Senha:</label><br>
        <?php
            $senha = "";
            if (isset($row_banco['senha'])) {
                $senha = $row_banco['senha'];
            }
        ?>
        <input class="input-form-cad" type="password" name="senha" id="lsenha" placeholder="DEIXE EM BRANCO PARA MANTER A MESMA SENHA" value="<?php echo $senha; ?>"><br><br>
        <!-- fim senha -->

        <!-- localhost -->
        <label for="llocalhost">Localhost:</label><br>
        <?php
            $localhost = "";
            if (isset($row_banco['localhost'])) {
                $localhost = $row_banco['localhost'];
            }
        ?>
        <input class="input-form-cad" type="text" name="localhost" id="llocalhost" placeholder="Local do banco de dados" value="<?php echo $localhost; ?>" required><br>
        <!-- fim localhost -->
        
        <input class="btn btn-form" type="submit" value="Enviar" name="enviarCadSis">
           
    </form>
</body>
</html>    