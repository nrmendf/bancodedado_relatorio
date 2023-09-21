<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Relatório de Pedidos</title>
    </head>

    <body>
        <h1>Relatório de Pedidos</h1>
        
        <form method="post">
            <label>Data Inicial (dd/mm/aaaa):</label>
            <input type="text" name="data_inicial" required><br>
            
            <label>Data Final (dd/mm/aaaa):</label>
            <input type="text" name="data_final" required><br>
            
            <label>Tipo de Data:</label>
            <input type="radio" name="tipo_data" value="Data Pedido" checked>Data Pedido
            <input type="radio" name="tipo_data" value="Data Entrega">Data Entrega<br>
            
            <label>Tipo de Relatório:</label>
            <input type="radio" name="tipo_relatorio" value="Sintético" checked>Sintético
            <input type="radio" name="tipo_relatorio" value="Analítico">Analítico<br>
            
            <input type="submit" name="gerar_relatorio" value="Gerar Relatório">
        </form>

        <?php
            if (isset($_POST["gerar_relatorio"])) {
                $data_inicial = $_POST["data_inicial"];
                $data_final = $_POST["data_final"];
                $tipo_data = $_POST["tipo_data"];
                $tipo_relatorio = $_POST["tipo_relatorio"];

                // Conecte-se ao banco de dados SQLite
                $db = new SQLite3('C:\xampp\htdocs\projeto3mlbanco\desafio3ml_banco.db');

                // Construa a consulta SQL com base nos parâmetros fornecidos
                $query = "";
                if ($tipo_data == 'Data Pedido') {
                    $data_field = 'data_pedido';
                } elseif ($tipo_data == 'Data Entrega') {
                    $data_field = 'data_entrega';
                } else {
                    echo "Tipo de Data inválido.";
                }

                if (!empty($data_field)) {
                    if ($tipo_relatorio == 'Sintético') {
                        $query = "SELECT numero, $data_field, valor_produto, valor_desconto, valor_frete, (valor_produto - valor_desconto - valor_frete) AS valor_pedido FROM pedido_compra WHERE $data_field BETWEEN '$data_inicial' AND '$data_final'";
                    } elseif ($tipo_relatorio == 'Analítico') {
                        $query = "SELECT numero, $data_field, valor_produto, valor_desconto, valor_frete, (valor_produto - valor_desconto - valor_frete) AS valor_pedido FROM pedido_compra WHERE $data_field BETWEEN '$data_inicial' AND '$data_final'";
                    } else {
                        echo "Tipo de Relatório inválido.";
                    }
                }
            }

                if (!empty($query)) {
                    $result = $db->query($query);

                    if ($result) {
                        if ($tipo_relatorio == 'Sintético') {
                            echo "<h2>Relatório de Pedidos Sintético</h2>";
                            echo "<table border='1'>";
                            echo "<tr><th>Pedido</th><th>$data_field</th><th>Valor Produtos</th><th>Valor Desconto</th><th>Valor Frete</th><th>Valor Pedido</th></tr>";
                            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                                echo "<tr><td>{$row['numero']}</td><td>{$row[$data_field]}</td><td>R$ {$row['valor_produto']}</td><td>R$ {$row['valor_desconto']}</td><td>R$ {$row['valor_frete']}</td><td>R$ {$row['valor_pedido']}</td></tr>";
                            }
                            echo "</table>";
                        } if ($tipo_relatorio == 'Analítico') {
                            echo "<h2>Relatório de Pedidos Analítico</h2>";
                        
                            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                                // Inicialize uma variável para armazenar a soma dos valores totais dos produtos
                                $somaValoresTotais = 0;
                        
                                echo "</table>";
                        
                                // Exibir os dados gerais do pedido
                                echo "<p>Dados Gerais do Pedido:</p>";
                                echo "<table border='1'>";
                                echo "<tr><th>Pedido</th><th>Data_Pedido</th><th>Data_Entrega</th><th>Valor_Produtos</th><th>Valor_Desconto</th><th>Valor_Frete</th><th>Valor_pedido</th></tr>";
                                echo "<tr>";
                                echo "<td>{$row['numero']}</td>";
                                echo "<td>{$row['data_pedido']}</td>";
                                echo "<td>";
                                
                                // Verificar se a chave "data_entrega" existe antes de acessá-la
                                if (isset($row['data_entrega'])) {
                                    echo $row['data_entrega'];
                                } else {
                                    echo "N/A"; // Ou qualquer valor padrão que você preferir
                                }
                        
                                echo "</td>";
                                echo "<td>R$ {$row['valor_produto']}</td>";
                                echo "<td>R$ {$row['valor_desconto']}</td>";
                                echo "<td>R$ {$row['valor_frete']}</td>";
                        
                                // Consulta SQL para obter os detalhes dos produtos com descrição do produto
                                $pedido_numero = $row['numero'];
                                $produtos_query = "SELECT pcp.cod_prod, cp.descricao AS descricao_produto, cp.sigla_unidade, pcp.qtde, pcp.preco, pcp.desconto, pcp.frete, (pcp.qtde * pcp.preco - pcp.desconto - pcp.frete) AS valor_total FROM pedido_compra_produtos pcp
                                                JOIN cad_produto cp ON pcp.cod_prod = cp.cod
                                                WHERE pcp.numero_pedido = $pedido_numero";
                                $produtos_result = $db->query($produtos_query);
                        
                                if ($produtos_result) {
                                    echo "<table border='1'>";
                                    echo "<tr><th>COD</th><th>DESCRIÇÃO</th><th>UNIDADE</th><th>QTDE</th><th>VALOR_PROD</th><th>DESCONTO</th><th>FRETE</th><th>VALOR_TOTAL</th></tr>";
                        
                                    while ($produto_row = $produtos_result->fetchArray(SQLITE3_ASSOC)) {
                                        echo "<tr>";
                                        echo "<td>{$produto_row['cod_prod']}</td>";
                                        echo "<td>{$produto_row['descricao_produto']}</td>";
                                        echo "<td>{$produto_row['sigla_unidade']}</td>";
                                        echo "<td>{$produto_row['qtde']}</td>";
                                        echo "<td>R$ {$produto_row['preco']}</td>";
                                        echo "<td>R$ {$produto_row['desconto']}</td>";
                                        echo "<td>R$ {$produto_row['frete']}</td>";
                                        echo "<td>R$ {$produto_row['valor_total']}</td>";
                                        echo "</tr>";
                        
                                        // Adicione o valor total deste produto à soma geral
                                        $somaValoresTotais += $produto_row['valor_total'];
                                    }
                                    
                                    // Exibir a soma dos valores totais dos produtos
                                    echo "<tr><td colspan='7'>Soma dos Valores Totais:</td><td>R$ $somaValoresTotais</td></tr>";
                                    
                                    echo "</table>";
                                } else {
                                    echo "Erro ao obter detalhes dos produtos.";
                                }
                                echo "</div>"; // Feche a div de um pedido analítico
                        
                                // Adicione uma quebra de linha ou espaço entre os pedidos
                                echo "<br>";
                            }
                        }
                    }            
                // Feche a conexão com o banco de dados
                $db->close();
            }
        ?>

    </body>
</html>