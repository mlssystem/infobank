<?php
    session_start();
    include_once "conexao.php";

    $id_usuario = filter_input(INPUT_GET, "id_usuario", FILTER_SANITIZE_NUMBER_INT);

    if ($id_usuario) {
        try {
            $query_sistema = "DELETE FROM sistemas WHERE id=:id LIMIT 1";
            $apagar_sistema = $conn->prepare($query_sistema);
            $apagar_sistema->bindParam(':id', $id_usuario, PDO::PARAM_INT);
            if ($apagar_sistema->execute()) {
                $_SESSION['msgs'] = "<p style='color: yellow;'>Sistema apagado com sucesso!</p>";
                header("Location: sistemas.php");
            } else {
                $_SESSION['msgs'] = "<p style='color: yellow;'>Erro: Sistema não foi apagado!</p>";
                header("Location: sistemas.php");
                //$_SESSION['msgs'] = "<p style='color: yellow;'>Erro: Sistema não foi apagado. Erro gerado: " . $erro->getMessage() . " </p>";
            }
        } catch (PDOException $erro) {
            $_SESSION['msgs'] = "<p style='color: yellow;'>Erro: Sistema não foi apagado!</p>";
            header("Location: sistemas.php");
        }
    } else {
        $_SESSION['msgs'] = "<p style='color: yellow;'>Erro: Sistema não encontrado!</p>";
        header("Location: sistemas.php");
    }
?>    
