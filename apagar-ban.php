<?php
    session_start();
    include_once "conexao.php";

    $id_usuario = filter_input(INPUT_GET, "id_usuario", FILTER_SANITIZE_NUMBER_INT);

    if ($id_usuario) {
        try {
            $query_banco = "DELETE FROM bancos_dados WHERE id=:id LIMIT 1";
            $apagar_banco = $conn->prepare($query_banco);
            $apagar_banco->bindParam(':id', $id_usuario, PDO::PARAM_INT);
            if ($apagar_banco->execute()) {
            $_SESSION['msgb'] = "<p style='color: yellow;'>banco-dados apagada com sucesso!</p>";
            header("Location: banco-dados.php");
        } else {
            $_SESSION['msgb'] = "<p style='color: #f00;'>Erro: banco-dados não apagada com sucesso!</p>";
            header("Location: banco-dados.php");
            //$_SESSION['msgs'] = "<p style='color: yellow;'>Erro: banco-dados não foi apagado. Erro gerado: " . $erro->getMessage() . " </p>";
            }
        } catch (PDOException $erro) {
        $_SESSION['msgb'] = "<p style='color: #ff0; font-size: 18px; background-color: #000; border-radius:7px; padding:5px;'><img class='img-ajuda' src='img/icones/informacao.png' title='Ajuda' alt='Ajuda'>Erro: O banco de dados não pode ser apagado se estiver vinculada a um sistema!</p>";
            header("Location: banco-dados.php");
        }
    } else {
        $_SESSION['msgb'] = "<p style='color: yellow;'>Erro: Banco de dados não encontrado!</p>";
        header("Location: banco-dados.php");
    }
?>    
