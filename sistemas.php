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
    <meta name="description" content="Informações do sistema">
    <meta name="keywords" content="informacao do sistema">
    <link rel="stylesheet" href="css/style.css">
    <title>Sistemas</title>
    <link rel="shortcut icon" href="img/sistemas/favicon.ico" type="imagem do icone">
</head>
<body>
    <h1 class="animacao-">InfoBankData!</h1>
    <h2 class="animacao-">Sistemas Desenvolvidos</h2>
    <img src="img/sistemas.png" alt="sistemas" width="200" height="100">
    
    <nav class="nav">
        <a href="index.php"><button class="btn-index">Home</button></a>
        <a><button class="btn-index active">Sistemas</button></a>
        <a href="banco-dados.php"><button class="btn-index">Banco de Dados</button></a>
    </nav>

    <div class="pesquisar">
        <a href="pesquisar-sis.php"><img src="img/icones/pesquisar.png" title="Pesquisar" alt="Pesquisar">Pesquisar</a>
    </div>
    
    <table class="tabela">
        <thead class="list-head">
            <tr class="conteudo-titulo-tabela">
                <th class='list-head-content'>ID</th>
                <th class='list-head-content'>NOME do SISTEMA</th>
                <th class='list-head-content'>BANCO DADOS</th>
                <th class='list-head-content'>DESCRIÇÃO</th>
                <th class='list-head-content'>LINGUAGEM</th>
                <th class='list-head-content'>AÇÔES</th>
            </tr>
        </thead>
        <?php
            try {
                // BUSCAR DADOS DO BANCO
                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                // SESSION
                if(isset($_SESSION['msgs'])){
                    echo $_SESSION['msgs'];
                    unset($_SESSION['msgs']);
                }
                $query_sistemas = ("SELECT sis.id As id_sis, sis.nome, sis.banco_dado_id, sis.linguagem_id, sis.descricao_id, sis.created, sis.modified,
                        bds.id As id_bds, bds.nome_banco AS nome_banco_bds,
                        lgm.name AS name_lgm,
                        dcc.name AS name_dcc
                        FROM sistemas AS sis
                        INNER JOIN bancos_dados AS bds ON bds.id=sis.banco_dado_id                                    
                        INNER JOIN linguagem AS lgm ON lgm.id=sis.linguagem_id                                    
                        INNER JOIN descricao AS dcc ON dcc.id=sis.descricao_id
                        ORDER BY id_sis DESC");
                $result_sistemas = $conn->prepare($query_sistemas);
                $result_sistemas->execute();
            } catch (PDOException $erro) {
                echo "<p style='color: yellow;'>Erro gerado: </p>";
                //echo "<p style='color: yellow;'>Erro gerado: " . $erro->getMessage() . " </p>";
              }
            while($row_sistema = $result_sistemas->fetch(PDO::FETCH_ASSOC)){
                //echo "<pre>".print_r($row_sistema, true)."</pre>";
                extract($row_sistema);
                echo "<tbody class='list-body'>";
                    echo "<tr>";
                        echo "<td name='id_usuario'>$id_sis</td>";
                        echo "<td>$nome</td>";
                        echo "<td>$nome_banco_bds</td>";
                        echo "<td>$name_dcc</td>";
                        echo "<td>$name_lgm</td>";
                        echo "<td class='btn-acoes'>";
                            echo "<a href='cadastro-sis.php'><button class='btn-editar'><img src='img/icones/adicionar-usuáriov.png' title='Cadastrar novo Sistema' alt='Cadastrar novo Sistema'></button></a>";
                            echo "<a href='editar-sis.php?id_usuario=$id_sis'><button class='btn-editar'><img src='img/icones/editar-fille.png' title='Editar novo Sistema' alt='Editar novo Sistema'></button></a>";
                            echo "<a href='apagar-sis.php?id_usuario=$id_sis' . onclick='return confirm(\"Tem certeza que deseja excluir este registro?\")'><button class='btn-editar'><img src='img/icones/excluir-fille.png' title='Excluir Sistema' alt='Cadastrar novo Sistema'></button></a>";
                        echo "</td>";
                    echo "</tr>";
                echo "</tbody>";
            }
        ?>    
    </table>
</body>
</html>