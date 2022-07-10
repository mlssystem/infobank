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
                $_SESSION['msg'] = "<p style='color: yellow;'>Banco apagado com sucesso!</p>";
                header("Location: banco-dados.php");
            } else {
                //$_SESSION['msg'] = "<p style='color: yellow;'>Erro: Banco não foi apagado!</p>";
                //$_SESSION['msg'] = "<p style='color: yellow;'>Erro: Try bloco. Erro gerado: " . $erro->getMessage() . " </p>";
                header("Location: esquisar.php");
            }
        } catch (PDOException $erro) {
            $_SESSION['msg'] = "<p style='color: yellow;'>Erro: Banco não foi apagado!</p>";
            //$_SESSION['msg'] = "<p style='color: yellow;'>Erro: Catch.<br> Erro gerado: " . $erro->getMessage() . " </p>";
            header("Location: banco-dados.php");
        }
    } else {
        $_SESSION['msg'] = "<p style='color: yellow;'>Erro: If id_user!</p>";
        header("Location: esquisar.php");
    }
?>    
