<?php
// content="text/plain; charset=utf-8"
require_once('jpgraph/jpgraph.php');
require_once('jpgraph/jpgraph_pie.php');

// Conectar-se ao banco de dados
$conexao = new mysqli('localhost', 'aplicacao_agenda', 'agenda123', 'agenda');

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

// Executar a consulta SQL para obter os dados
$sql = "SELECT cd_sexo, COUNT(*) AS total FROM tb_pessoa GROUP BY cd_sexo";
$resultado = $conexao->query($sql);

// Processar os resultados
$data = array();
$labels = array(); // Novo array para armazenar os rótulos
if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $data[] = $row['total'];

        // Adicionar rótulos com base no código de sexo
        if ($row['cd_sexo'] == 'F') {
            $labels[] = 'Feminino (' . $row['total'] . ')';
        } elseif ($row['cd_sexo'] == 'M') {
            $labels[] = 'Masculino (' . $row['total'] . ')';
        }
    }
}

// Fechar a conexão com o banco de dados
$conexao->close();

// Create the Pie Graph.
$graph = new PieGraph(350, 250);

$theme_class = "DefaultTheme";

$graph->title->Set("Sexo das Pessoas");
$graph->SetBox(true);

$p1 = new PiePlot($data);
$p1->SetLabels($labels); // Definir os rótulos no gráfico
$p1->SetLabelType(PIE_VALUE_PER); // Exibir porcentagens
$p1->value->Show(); // Mostrar os valores numéricos
$graph->Add($p1);

$p1->ShowBorder();
$p1->SetColor('black');
$p1->SetSliceColors(array('#1E90FF', '#2E8B57'));

$graph->Stroke();
?>
