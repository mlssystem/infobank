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
    <meta name="description" content="informações dos sistemas e dos banco dados">
    <meta name="keywords" content="sistemas e dos banco dados">
    <link rel="stylesheet" href="css/style.css">
    <title>Pesquisar Sistemas</title>
    <link rel="shortcut icon" href="img/favicon.ico" type="imagem do icone">
</head>
<body class="body-ajust">
    <!--<h1 class="animacao-1">InfoBankData!</h1>-->
    <h1 class="animacao-">Pesquisar Sistemas</h1>
    <img src="img/sistemas.png" alt="sistemas" width="200" height="100">
    
    <nav class="nav">
        <a href="index.php"><button class="btn-index">Home</button></a>
        <a href="banco-dados.php"><button class="btn-index">Banco de Dados</button></a>
        <a href="sistemas.php"><button class="btn-index">Sistemas</button></a>
        <a href="cadastro-ban.php"><button class="btn-index">Cadastrar Novo Banco</button></a>
        <a href="cadastro-sis.php"><button class="btn-index">Cadastrar Novo Sistema</button></a>
    </nav>

    <form method="POST" action="">
        <?php
            // BUSCAR DADOS DO BANCO
            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            // SE NÃO TIVER PESQUISADO NADA MOSTRA CAMPOS VAZIOS
            $texto_pesquisar = "";
            // SE TIVER PESQUISADO DEIXAR CAMPO PREENCHIDO
            if (isset($dados['texto_pesquisar'])){
                $texto_pesquisar = $dados['texto_pesquisar'];
            }
        ?>
        <label>Pesquisar</label>
        <!-- INCLUIR $texto_pesquisar EM VALUE PARA DEIXAR CAMPO PREENCHIDO SE JA TIVER SIDO PESQUISADO -->
        <input type="text" name="texto_pesquisar" value="<?php echo $texto_pesquisar; ?>" placeholder="Pesquisar pelo termo?">
        <input type="submit" value="Pesquisar" name="PesqUsuario"><br><br>
    </form>

    <table class='tabela'>
        <thead class='list-head'>
            <tr>
                <th class='list-head-content'>ID</th>
                <th class='list-head-content'>NOME</th>
                <th class='list-head-content table-md-none'>ID DO BANCO</th>
                <th class='list-head-content table-sm-none'>DESCRIÇÃO</th>
                <th class='list-head-content table-sm-none'>LINGUAGEM</th>
                <th class='list-head-content table-sm-none'>MODIFICAÇÂO</th>
                <th class='list-head-content table-md-none'>AÇÕES</th>
            </tr>
        </thead>
        <?php
            if (!empty($dados['PesqUsuario'])) {
                /* 
                * USANDO O SIMBOLO DE % ANTES E DEPOIS REALIZA A PESQUISAR MESMO QUE TENHA CONTEÚDO
                * ANTES OU DEPOIS DA PALAVRA PESQUISADA
                */ 
                $nome = "%" . $dados['texto_pesquisar'] . "%";
                $query_sistema = "SELECT sis.id AS id_sis, sis.nome, sis.linguagem_id, sis.descricao_id, sis.banco_dado_id, sis.modified,
                                    lgm.name AS name_lgm,
                                    dcc.name AS name_dcc
                                    FROM sistemas AS sis 
                                    INNER JOIN descricao AS dcc ON dcc.id=sis.descricao_id
                                    INNER JOIN linguagem AS lgm ON lgm.id=sis.linguagem_id
                                    WHERE nome LIKE :nome ORDER BY id_sis DESC";
                $result_sistema = $conn->prepare($query_sistema);
                $result_sistema->bindParam(':nome', $nome, PDO::PARAM_STR);
                $result_sistema->execute();
                while($row_sistema = $result_sistema->fetch(PDO::FETCH_ASSOC)){
                    extract($row_sistema);
                    echo "<tbody class='corpo-tabela-cad'>";
                        echo "<tr>";
                            echo "<td name='id_usuario' style='text-align: center'>$id_sis</td>";
                            echo "<td>$nome</td>";
                            echo "<td class='table-md-none'>$banco_dado_id</td>";
                            echo "<td class='table-sm-none'>$name_dcc </td>";
                            echo "<td class='table-sm-none'>$name_lgm</td>";
                            echo "<td>" . date('d/m/Y', strtotime($modified)) . "</td>";
                            echo "<td class='btn-acoes'>";
                            echo "<a href='cadastro-sis.php'><button class='btn-editar'><img src='img/icones/adicionar-usuáriov.png' title='Cadastrar novo Sistema' alt='Cadastrar novo Sistema'></button></a>";
                            echo "<a href='editar-sis.php?id_usuario=$id_sis'><button class='btn-editar'><img src='img/icones/editar-fille.png' title='Editar novo Sistema' alt='Editar novo Sistema'></button></a>";
                            echo "<a href='apagar-sis.php?id_usuario=$id_sis' . onclick='return confirm(\"Tem certeza que deseja excluir este registro?\")'><button class='btn-editar'><img src='img/icones/excluir-fille.png' title='Excluir Sistema' alt='Cadastrar novo Sistema'></button></a>";
                            echo "</td>";
                        echo "</tr>";
                    echo "</tbody>";
                }
            }
        ?>
    </table>
</body>
</html>
