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
    <meta name="description" content="Cadastrar banco de dados">
    <meta name="keywords" content="Cadastrar banco de dados">
    <link rel="stylesheet" href="css/style.css">
    <title>Cadastrar Banco de Dado</title>
    <link rel="shortcut icon" href="img/favicon.ico" type="imagem do icone">
</head>
<body class="body-ajust body-cad">
    <h1 class="animacao-">InfoBankData!</h1>
    <h2 class="animacao-">Cadastrar banco de dado</h2>
    <p>Campos que  contém (<span class="campo-obrigatorio">*</span>) são obrigatórios.</p>
    
    <nav class="nav">
        <a href="index.php"><button class="btn-index">Home</button></a>
        <a><button class="btn-index active">Cadastrar Novo Banco</button></a>
        <a href="banco-dados.php"><button class="btn-index">Banco de Dados</button></a>
    </nav>        

    <?php
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($dados["enviarCadBanco"])) {
            //echo "<pre>".print_r($dados, true)."</pre>";
            try {
                if (isset($_SESSION['msgb'])) {
                    echo $_SESSION['msgb'];
                    unset($_SESSION['msgb']);
                }                
                $query_banco = ("INSERT INTO bancos_dados (nome_banco, usuario, senha, localhost, created, modified) VALUES (:nome_banco, :usuario, :senha, :localhost, NOW(), NOW())");        
                $cad_banco = $conn->prepare($query_banco);
                $cad_banco->bindParam(':nome_banco', $dados['nome_banco'], PDO::PARAM_STR);
                $cad_banco->bindParam(':usuario', $dados['usuario'], PDO::PARAM_STR);
                //$senha_cript = password_hash($dados['senha'], PASSWORD_DEFAULT);
                //$cad_banco->bindParam(':senha', $senha_cript);
                $cad_banco->bindParam(':senha', $dados['senha'], PDO::PARAM_STR);
                $cad_banco->bindParam(':localhost', $dados['localhost'], PDO::PARAM_STR);                
                if ($cad_banco->execute()) {
                    $_SESSION['msgb'] = "<p style='color: yellow;'>Banco cadastrado com sucesso!</p>";
                    unset($dados);
                    header("Location: banco-dados.php");
                } else {
                    echo "<p style='color: #f00;'>Erro: Banco não foi cadastrado!</p>";
                }
                //Criando variável global para salvar mensagem usuário salvo com sucesso
                $_SESSION['msgb'] = "<p style='color:yellow'>Banco cadastrado com sucesso</p>";
                header("Location:banco-dados.php");
            } catch (PDOException $erro) {
                echo "<p style='color: yellow;'>Erro gerado: " . $erro->getMessage() . " </p>";
                //echo "<p style='color: #f00;'>Erro: Banco não foi cadastrado!</p>";
            }
        } else {                
            $_SESSION['msgb'] = "<p style='color: yellow;'>Erro: Banco não foi cadastrado. </p>";
            //header("Location: banco-dados.php");
        }
    ?>
    <form class="form-cad" method="POST" action="">
        <!-- nome do banco-->
        <label for="nome_banco">Nome do Banco<span class="campo-obrigatorio">*</span></label><br>
        <?php
            $nome_banco = "";
            if (isset($dados['nome_banco'])) {
                $nome_banco = $dados['nome_banco'];
            }
        ?>
        <input class="input-form-cad" type="text" name="nome_banco" id="nome_banco" placeholder="Nome do banco de dados" value="<?php echo $nome_banco; ?>" required><br><br>
        <!-- fim nome do banco-->        
        
        <!-- usuario do banco -->
        <label for="usuario">Usuário do Banco:<span class="campo-obrigatorio">*</span></label><br>
        <?php
            $usuario = "";
            if (isset($dados['usuario'])) {
                $usuario = $dados['usuario'];
            }
        ?>
        <input class="input-form-cad" type="text" name="usuario" id="usuario" placeholder="Nome do usuário do banco de dados" value="<?php echo $usuario; ?>" required><br><br>
        <!-- fim usuario do banco -->
        
        <!-- senha -->
        <label for="senha">Senha:<span class="campo-obrigatorio">*</span></label><br>
        <?php
            $senha = "";
            if (isset($dados['senha'])) {
                $senha = $dados['senha'];
            }
        ?>
        <input class="input-form-cad" type="text" name="senha" id="senha" placeholder="Senha do banco de dados" value="<?php echo $senha; ?>" required><br><br> 
        <!-- fim senha -->
        
        <!-- localhost -->
        <label for="localhost">Localhost:<span class="campo-obrigatorio">*</span></label><br>
        <?php
            $localhost = "";
            if (isset($dados['localhost'])) {
                $localhost = $dados['localhost'];
            }
        ?>
        <input class="input-form-cad" type="text" name="localhost" id="localhost" placeholder="Local do banco de dados" value="<?php echo $localhost; ?>" required>
        <!-- fim localhost -->

        <input class="btn btn-form" type="submit" value="Enviar" name="enviarCadBanco">           
    </form>
</body>
</html>    