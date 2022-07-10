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
    <title>Pesquisar Banco de Dados</title>
    <link rel="shortcut icon" href="img/favicon.ico" type="imagem do icone">
</head>
<body>

    <h1 class="animacao-1">InfoBankData!</h1>
    <h2 class="animacao-">Pesquisar Bancos de Dados</h2>
    
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
            <tr>
                <th class='list-head-content'>ID</th>
                <th class='list-head-content'>NOME do BANCO</th>
                <th class='list-head-content table-sm-none'>USUÁRIO</th>
                <th class='list-head-content table-sm-none'>SENHA</th>
                <th class='list-head-content table-md-none'>LOCALHOST</th>
                <th class='list-head-content table-md-none'>AÇÕES</th>
            </tr>
        </thead>

        <?php 
            if (!empty($dados['PesqUsuario'])) {
                /* 
                * USANDO O SIMBOLO DE % ANTES E DEPOIS REALIZA A PESQUISAR MESMO QUE TENHA CONTEÚDO
                * ANTES OU DEPOIS DA PALAVRA PESQUISADA
                */ 
                $nome_banco = "%" . $dados['texto_pesquisar'] . "%";

                $query_sistema = "SELECT id, nome_banco, usuario, senha, localhost FROM bancos_dados WHERE nome_banco LIKE :nome_banco ORDER BY id DESC";

                $result_sistema = $conn->prepare($query_sistema);
                $result_sistema->bindParam(':nome_banco', $nome_banco, PDO::PARAM_STR);
                $result_sistema->execute();

                while($row_sistema = $result_sistema->fetch(PDO::FETCH_ASSOC)){
                    extract($row_sistema);
                    echo "<tbody class='corpo-tabela-cad'>";
                        echo "<tr>";
                            echo "<td name='id_usuario' style='text-align: center'>$id</td>";
                            echo "<td>$nome_banco</td>";
                            echo "<td class='table-sm-none'>$usuario</td>";
                            echo "<td class='table-sm-none'>$senha </td>";
                            echo "<td class='table-md-none'>$localhost</td>";
                            echo "<td class='btn-acoes'>";
                            echo "<a href='cadastro-ban.php?id_usuario=$id'><button class='btn-editar'><img src='img/icones/adicionar-usuáriov.png' title='Cadastrar novo Sistema' alt='Cadastrar novo Sistema'></button></a>";
                            echo "<a href='editar-ban.php?id_usuario=$id'><button class='btn-editar'><img src='img/icones/editar-fille.png' title='Editar novo Sistema' alt='Editar novo Sistema'></button></a>";
                            echo "<a href='apagar-ban.php?id_usuario=$id'><button class='btn-editar'><img src='img/icones/excluir-fille.png' title='Excluir Sistema' alt='Cadastrar novo Sistema'></button></a>";
                            echo "</td>";
                        echo "</tr>";
                    echo "</tbody>";
                }
            }
        ?>
    </table>

</body>

</html>   