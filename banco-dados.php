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
    <meta name="description" content="Informações de banco de dados">
    <meta name="keywords" content="informacao banco dados">
    <link rel="stylesheet" href="css/style.css">
    <title>Banco de Dados</title>
    <link rel="shortcut icon" href="img/favicon.ico" type="imagem do icone">
</head>
<body>

    <h1 class="animacao-1">InfoBankData!</h1>
    <h2 class="animacao-1">Bancos de Dados</h2>

    <!-- <div class="div-ajuda">
        <p>Passe o mouse<span onmouseover="getElementById('ajuda').style.display='block'" onmouseout="getElementById('ajuda').style.display='none'"><img class="img-ajuda" src="img/icones/ajudaa.png" title="Ajuda" alt="Ajuda"></span></p>

        <div id="ajuda">Não está conseguindo deletar informações de um banco? Delete primeiro o sistema procurando pelo ID do banco e depois volte para deletar o banco.</div>
    </div> -->

    <div class="div-ajuda">
        <p><img class="img-ajuda" src="img/icones/ajudaa.png" title="Ajuda" alt="Ajuda">Não está conseguindo deletar informações de um banco?</p>
        <p>É porque ele está vinculado a um sistema! Caso não consiga deletar.</p>
        <p>Delete primeiro o sistema procurando pelo ID do banco e depois volte para deletar o banco.</p>
    </div>
    
    <nav class="nav">
        <a href="index.php"><button class="btn-index">Home</button></a>
        <a href="banco-dados.php"><button class="btn-index active">Banco de Dados</button></a>
        <!-- <a href="cadastro-ban.php"><button class="btn-index">Cadastrar Novo Banco</button></a> -->
        <a href="sistemas.php"><button class="btn-index">Sistemas</button></a>
        <!-- <a href="cadastro-sis.php"><button class="btn-index">Cadastrar Novo Sistema</button></a> -->
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
                <th>SENHA</th>
                <th>LOCALHOST</th>
                <th>AÇÔES</th>
            </tr>
        </thead>

        <?php
            //Receber os dados do formulário          
            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            //echo "<pre>" . print_r($dados, true) . " </pre>";
            if (isset($SESSION['msg'])) {
                echo $SESSION['msg'];
                unset($SESSION['msg']);
            }

            $query_bancos = "SELECT id, nome_banco, usuario, senha, localhost FROM bancos_dados ORDER BY id DESC";
            $result_bancos = $conn->prepare($query_bancos);
            $result_bancos->execute();

            while($row_banco = $result_bancos->fetch(PDO::FETCH_ASSOC)){
                //echo "<pre>".print_r($row_banco, true)."</pre>";
                extract($row_banco);

                echo "<tbody class='corpo-tabela-cad'>";
                    echo "<tr>";
                        echo "<td name='id_usuario'>$id</td>";
                        echo "<td>$nome_banco</td>";
                        echo "<td>$usuario</td>";
                        echo "<td>$senha</td>";
                        echo "<td>$localhost</td>";
                        echo "<td class='btn-acoes'>";
                        echo "<a href='cadastro-ban.php?id_usuario=$id'><button class='btn-editar'><img src='img/icones/adicionar-usuáriov.png' title='Cadastrar novo Sistema' alt='Cadastrar novo Sistema'></button></a>";
                        echo "<a href='editar-ban.php?id_usuario=$id'><button class='btn-editar'><img src='img/icones/editar-fille.png' title='Editar novo Sistema' alt='Editar novo Sistema'></button></a>";
                        echo "<a href='apagar-ban.php?id_usuario=$id'><button class='btn-editar'><img src='img/icones/excluir-fille.png' title='Excluir Sistema' alt='Cadastrar novo Sistema'></button></a>";
                        echo "</td>";
                    echo "</tr>";
                echo "</tbody>";
            }
        ?>    
    </table>
</body>
</html>