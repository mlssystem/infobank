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
    <meta name="description" content="informações dos sistemas e dos banco dados">
    <meta name="keywords" content="sistemas e dos banco dados">
    <link rel="stylesheet" href="css/style.css">
    <title>InfoBank</title>
    <link rel="shortcut icon" href="img/favicon.ico" type="imagem do icone">
</head>
<body>
    <h1 class="animacao-">InfoBankData!</h1>
    <h2 style="text-align: center;" class="animacao-1">Sistemas e Bancos de Dados</h2>
    <img src="img/sis-ban.png" alt="Sistemas e Banco de dados" width="200" height="100">
    
    <nav class="nav">
        <a><button class="btn-index active">Home</button></a>
        <a href="banco-dados.php"><button class="btn-index">Banco de Dados</button></a>
        <a href="sistemas.php"><button class="btn-index">Sistemas</button></a>
        <a href="cadastro-ban.php"><button class="btn-index">Cadastrar Banco</button></a>
        <a href="cadastro-sis.php"><button class="btn-index">Cadastrar Sistema</button></a>
    </nav>

    <div class="pesquisar">
        <a href="pesquisar-index.php"><img src="img/icones/pesquisar.png" title="Pesquisar" alt="Pesquisar">Pesquisar</a>
    </div>

    <table class="tabela">
        <thead class="titulo-tabela">
            <tr class="conteudo-titulo-tabela">
                <th>ID</th>
                <th>NOME</th>
                <th>NOME do BANCO</th>
                <th>DESCRIÇÂO</th>
                <th>LINGUAGEM</th>
                <th>MODIFICAÇÃO</th>
            </tr>
        </thead>

        <?php
            try {  
                /** Receber os dados do formulário */
                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

                $query_sistemas = "SELECT sis.id  As id_sis, sis.nome AS nome_sis, sis.linguagem_id AS linguagem_id_sis, sis.descricao_id AS descricao_id_sis, sis.banco_dado_id AS banco_dado_id_sis,
                                    sis.modified AS modified_sis,
                                    ban.nome_banco AS nome_banco_ban,
                                    #ban.usuario AS usuario_ban,
                                    lgm.name AS name_lgm,
                                    dcc.name AS name_dcc
                                    FROM sistemas AS sis                                    
                                    INNER JOIN bancos_dados AS ban ON ban.id=sis.banco_dado_id
                                    INNER JOIN linguagem AS lgm ON lgm.id=sis.linguagem_id
                                    INNER JOIN descricao AS dcc ON dcc.id=sis.descricao_id
                                    ORDER BY sis.nome ASC ";
                $result_sistemas = $conn->prepare($query_sistemas);
                $result_sistemas->execute();
            } catch (PDOException $erro) {
                echo "<p style='color: yellow;'>Erro gerado: " . $erro->getMessage() . " </p>";
            }

            while($row_sistema = $result_sistemas->fetch(PDO::FETCH_ASSOC)){
                #echo "<pre>".print_r($row_sistema, true)."</pre>";
                extract($row_sistema);
                echo "<tbody class='corpo-tabela-cad'>";
                    echo "<tr>";
                        echo "<td>$id_sis</td>";
                        echo "<td>$nome_sis</td>";
                        echo "<td>$nome_banco_ban</td>";
                        echo "<td>$name_dcc</td>";
                        echo "<td>$name_lgm</td>";
                        echo "<td>" . date('d/m/Y', strtotime($modified_sis)) . "</td>";
                    echo "</tr>";
                echo "</tbody>";
            }
        ?>    
    </table>

</body>
</html>