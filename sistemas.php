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
    <meta name="description" content="Informações do sistema">
    <meta name="keywords" content="informacao do sistema">
    <link rel="stylesheet" href="css/style.css">
    <title>Sistemas</title>
    <link rel="shortcut icon" href="img/favicon.ico" type="imagem do icone">
</head>
<body>

    <h1 class="animacao-1">InfoBankData!</h1>
    <h2 class="animacao-1">Sistemas Desenvolvidos</h2>
    
    <nav class="nav">
        <a href="index.php"><button class="btn-index">Home</button></a>
        <a href="sistemas.php"><button class="btn-index active">Sistemas</button></a>
        <!--<a href="cadastro-sis.php"><button class="btn-index">Cadastrar Novo Sistema</button></a>-->
        <a href="banco-dados.php"><button class="btn-index">Banco de Dados</button></a>
        <!--<a href="cadastro-ban.php"><button class="btn-index">Cadastrar Novo Banco</button></a>-->
    </nav>

    <div class="pesquisar">
        <a href="pesquisar-sis.php"><img src="img/icones/pesquisar.png" title="Pesquisar" alt="Pesquisar">Pesquisar</a>
    </div>
    
    <table class="tabela">
        <thead class="list-head">
            <tr class="conteudo-titulo-tabela">
                <th class='list-head-content'>ID</th>
                <th class='list-head-content'>NOME do SISTEMA</th>
                <th class='list-head-content'>ID BANCO</th>
                <th class='list-head-content'>DESCRIÇÃO</th>
                <th class='list-head-content'>LINGUAGEM</th>
                <th class='list-head-content'>CRIAÇÃO</th>
                <th class='list-head-content'>MODIFICAÇÃO</th>
                <th class='list-head-content'>AÇÔES</th>
            </tr>
        </thead>

        <?php
            try {  
                //Receber os dados do formulário          
                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                //echo "<pre>" . print_r($dados, true) . " </pre>";

                if (isset($SESSION['msg'])) {
                    echo $SESSION['msg'];
                    unset($SESSION['msg']);
                }

                $query_sistemas = "SELECT id, nome, linguagem, descricao, banco_dado_id, created, modified FROM sistemas ORDER BY id DESC";
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
                        echo "<td name='id_usuario'>$id</td>";
                        echo "<td>$nome</td>";
                        echo "<td>$banco_dado_id</td>";
                        echo "<td>$descricao</td>";
                        echo "<td>$linguagem</td>";
                        echo "<td>" . date('d/m/Y H:i:s', strtotime($created)) ." </td>";
                        echo "<td>" . date('d/m/Y H:i:s', strtotime($modified)) . "</td>";
                        echo "<td class='btn-acoes'>";
                            echo "<a href='cadastro-sis.php?id_usuario=$id'><button class='btn-editar'><img src='img/icones/adicionar-usuáriov.png' title='Cadastrar novo Sistema' alt='Cadastrar novo Sistema'></button></a>";
                            echo "<a href='editar-sis.php?id_usuario=$id'><button class='btn-editar'><img src='img/icones/editar-fille.png' title='Editar novo Sistema' alt='Editar novo Sistema'></button></a>";
                            echo "<a href='apagar-sis.php?id_usuario=$id'><button class='btn-editar'><img src='img/icones/excluir-fille.png' title='Excluir Sistema' alt='Cadastrar novo Sistema'></button></a>";
                        echo "</td>";
                    echo "</tr>";
                echo "</tbody>";
            }
        ?>    
    </table>
</body>
</html>