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
    <meta name="description" content="Informações de banco de dados">
    <meta name="keywords" content="informacao banco dados">
    <link rel="stylesheet" href="css/style.css">
    <title>Banco de Dados</title>
    <link rel="shortcut icon" href="img/favicon.ico" type="imagem do icone">
</head>
<body>
    <h1 class="animacao-">InfoBankData!</h1>
    <h2 class="animacao-">Bancos de Dados</h2>
    
    <nav class="nav">
        <a href="index.php"><button class="btn-index">Home</button></a>
        <a><button class="btn-index active">Banco de dados</button></a>
        <a href="sistemas.php"><button class="btn-index">Sistemas</button></a>
    </nav>

    <div class="pesquisar">
        <a href="pesquisar-ban.php"><img src="img/icones/pesquisar.png" title="Pesquisar" alt="Pesquisar">Pesquisar</a>
    </div>

    <table class="tabela">
        <thead class="titulo-tabela">
            <tr class="conteudo-titulo-tabela">
                <th>ID</th>
                <th>NOME do BANCO</th>
                <th>USUARIO do BANCO</th>
                <th>LOCALHOST</th>
                <th>AÇÔES</th>
            </tr>
        </thead>

        <?php
            try {
                //Receber os dados do formulário          
                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                // Mostrar mensagesns
                if (isset($_SESSION['msgb'])) {
                    echo $_SESSION['msgb'];
                    unset($_SESSION['msgb']);
                }
                $query_bancos = ("SELECT id, nome_banco, usuario, localhost, created, modified FROM bancos_dados ORDER BY id DESC");
                $result_bancos = $conn->prepare($query_bancos);
                $result_bancos->execute();
            } catch (PDOException $erro) {
                echo "<p style='color: yellow;'>Erro gerado: </p>";
                //echo "<p style='color: yellow;'>Erro gerado: " . $erro->getMessage() . " </p>";
              }
            while($row_banco = $result_bancos->fetch(PDO::FETCH_ASSOC)){
                //echo "<pre>".print_r($row_banco, true)."</pre>";
                extract($row_banco);
                echo "<tbody class='corpo-tabela-cad'>";
                    echo "<tr>";
                        echo "<td name='id_usuario'>$id</td>";
                        echo "<td>$nome_banco</td>";
                        echo "<td>$usuario</td>";
                        echo "<td>$localhost</td>";
                        echo "<td class='btn-acoes'>";
                        echo "<a href='cadastro-ban.php'><button class='btn-editar'><img src='img/icones/adicionar-usuáriov.png' title='Cadastrar novo Sistema' alt='Cadastrar novo Sistema'></button></a>";
                        echo "<a href='editar-ban.php?id_usuario=$id'><button class='btn-editar'><img src='img/icones/editar-fille.png' title='Editar novo Sistema' alt='Editar novo Sistema'></button></a>";
                        echo "<a href='apagar-ban.php?id_usuario=$id' . onclick='return confirm(\"Tem certeza que deseja excluir este registro?\")'><button class='btn-editar'><img src='img/icones/excluir-fille.png' title='Excluir Sistema' alt='Cadastrar novo Sistema'></button></a>";
                        echo "</td>";
                    echo "</tr>";
                echo "</tbody>";
            }
        ?>    
    </table>
</body>
</html>