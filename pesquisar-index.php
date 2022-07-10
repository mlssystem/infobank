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
    <title>Pesquisar Geral</title>
    <link rel="shortcut icon" href="img/favicon.ico" type="imagem do icone">
</head>
<body>

    <h1 class="animacao-1">InfoBankData!</h1>
    <h2 class="animacao-">Pesquisar Geral</h2>
    
    <nav class="nav">
        <a href="index.php"><button class="btn-index">Home</button></a>
        <a href="banco-dados.php"><button class="btn-index">Banco de Dados</button></a>
        <a href="sistemas.php"><button class="btn-index">Sistemas</button></a>
    </nav>

    <form method="POST" action="">

        <?php
            // BUSCAR DADOS DO BANCO
            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            // SESSION
            if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }

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
            <tr class="conteudo-titulo-tabela">
                <th>ID</th>
                <th>NOME</th>
                <th>ID BANCO</th>
                <th>NOME do BANCO</th>
                <th>USUARIO do BANCO</th>
                <th>DESCRIÇÂO</th>
                <th>LINGUAGEM</th>
                <th>CRIAÇÃO</th>
                <th>MODIFICAÇÃO</th>
            </tr>
        </thead>

        <?php
            if (!empty($dados['PesqUsuario'])) {
                /* 
                * USANDO O SIMBOLO DE % ANTES E DEPOIS REALIZA A PESQUISAR MESMO QUE TENHA CONTEÚDO
                * ANTES OU DEPOIS DA PALAVRA PESQUISADA
                */ 
                $nome_sis = "%" . $dados['texto_pesquisar'] . "%";

                $query_sistemas = "SELECT sis.id  As id_sis, sis.nome AS nome_sis, sis.linguagem AS linguagem_sis, sis.descricao AS descricao_sis, sis.banco_dado_id AS banco_dado_id_sis, sis.created AS created_sis, sis.modified AS modified_sis, ban.id AS id_ban, ban.nome_banco AS nome_banco_ban, ban.usuario AS usuario_ban FROM sistemas AS sis INNER JOIN bancos_dados AS ban ON ban.id=sis.banco_dado_id WHERE sis.nome LIKE :nome_sis ORDER BY id_sis ASC ";

                $result_sistemas = $conn->prepare($query_sistemas);
                $result_sistemas->bindParam(':nome_sis', $nome_sis, PDO::PARAM_STR);
                $result_sistemas->execute();

                while($row_sistema = $result_sistemas->fetch(PDO::FETCH_ASSOC)){
                    extract($row_sistema);
                    echo "<tbody class='corpo-tabela-cad'>";
                        echo "<tr>";
                            echo "<td>$id_sis</td>";
                            echo "<td>$nome_sis</td>";
                            echo "<td>$banco_dado_id_sis</td>";
                            echo "<td>$nome_banco_ban</td>";
                            echo "<td>$usuario_ban</td>";
                            echo "<td>$descricao_sis</td>";
                            echo "<td>$linguagem_sis</td>";
                            echo "<td>" . date('d/m/Y H:i:s', strtotime($created_sis)) . " </td>";
                            echo "<td>" . date('d/m/Y H:i:s', strtotime($modified_sis)) . "</td>";
                        echo "</tr>";
                    echo "</tbody>";
                }
            }
        ?>
    </table>

</body>

</html>   