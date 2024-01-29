<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        @media (max-width: 600px) {
            table {
                border: 0;
            }

            table thead {
                display: none;
            }

            table, table tbody, table tr, table td {
                display: block;
                width: 100%;
            }

            table td {
                text-align: right;
                padding: 10px;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>

    <?php
    // Conectar ao banco de dados (substitua as credenciais conforme necessário)
    $host = "localhost";
    $usuario = "novousuario";
    $senha = "senac123456789";
    $banco = "gastos";
    $conn = new mysqli($host, $usuario, $senha, $banco);
    
    // Verificar a conexão
    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }
    
    // Processar os dados do formulário
    $nomeUsuario = $_POST['nomeUsuario'];
    $descricao = $_POST['descricao'];
    $data = $_POST['data'];
    $valor = $_POST['valor'];
    $tipoDespesa = $_POST['tipoDespesa'];
    
    // Inserir dados no banco de dados
    $sql = "INSERT INTO despesas (nome_usuario, descricao, data, valor, tipo_despesa) VALUES ('$nomeUsuario', '$descricao', '$data', '$valor', '$tipoDespesa')";
    if ($conn->query($sql) === TRUE) {
        echo "Registro de despesa inserido com sucesso!";
    
        // Calcular a soma dos valores na tabela despesas
        $consultaSoma = "SELECT SUM(valor) AS soma FROM despesas";
        $resultadoSoma = $conn->query($consultaSoma);
    
        if ($resultadoSoma->num_rows > 0) {
            $row = $resultadoSoma->fetch_assoc();
            $soma = $row['soma'];
            echo "<br>Soma total das despesas: $soma";
    
            // Recuperar dados da tabela despesas
            $consultaDespesas = "SELECT * FROM despesas";
            $resultadoDespesas = $conn->query($consultaDespesas);
    
            if ($resultadoDespesas->num_rows > 0) {
                echo "<br><br>Tabela de Despesas:<br>";
                echo "<table border='1'>";
                echo "<tr><th>ID</th><th>Nome do Usuário</th><th>Descrição</th><th>Data</th><th>Valor</th><th>Tipo de Despesa</th></tr>";
    
                while ($rowDespesas = $resultadoDespesas->fetch_assoc()) {
                    echo "<tr><td>{$rowDespesas['id']}</td><td>{$rowDespesas['nome_usuario']}</td><td>{$rowDespesas['descricao']}</td><td>{$rowDespesas['data']}</td><td>{$rowDespesas['valor']}</td><td>{$rowDespesas['tipo_despesa']}</td></tr>";
                }
    
                echo "</table>";
            } else {
                echo "Nenhum registro encontrado na tabela despesas.";
            }
    
        } else {
            echo "<br>Nenhum resultado encontrado para a soma das despesas.";
        }
    
    } else {
        echo "Erro ao inserir registro: " . $conn->error;
    }
    
    // Fechar a conexão
    $conn->close();
      echo '<a href="index.html">voltar</a';
    ?>
    

</body>
</html>
