<?php
$servername = "localhost";
$username = "seu_usuario";
$password = "sua_senha";
$dbname = "seu_banco_de_dados";

// Conectar ao banco de dados
$conexao = new mysqli('localhost', 'aplicacao_agenda', 'agenda123', 'agenda');

// Verificar a conexão
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}


// Consulta para obter a idade das pessoas
$sql = "SELECT TIMESTAMPDIFF(YEAR, dt_nasc, CURDATE()) AS idade FROM tb_pessoa;";
$result = $conexao->query($sql);

$datay = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $datay[] = $row["idade"];
    }
}

// Fechar a conexão
$conexao->close();


// Código do gráfico
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_bar.php');

// Create the graph.
// One minute timeout for the cached image
// INLINE_NO means don't stream it back to the browser.
$graph = new Graph(310, 250, 'auto');
$graph->SetScale("textlin");
$graph->img->SetMargin(60, 30, 20, 40);
$graph->yaxis->SetTitleMargin(45);
$graph->yaxis->scale->SetGrace(30);
$graph->SetShadow();

// Turn the tickmarks
$graph->xaxis->SetTickSide(SIDE_DOWN);
$graph->yaxis->SetTickSide(SIDE_LEFT);

// Create a bar plot
$bplot = new BarPlot($datay);

// Create targets for the image maps. One for each column
$targ = array("bar_clsmex1.php#1", "bar_clsmex1.php#2", "bar_clsmex1.php#3", "bar_clsmex1.php#4");
$alts = array("val=%d", "val=%d", "val=%d", "val=%d");
$bplot->SetCSIMTargets($targ, $alts);
$bplot->SetFillColor("orange");

// Use a shadow on the bar graphs (just use the default settings)
$bplot->SetShadow();
$bplot->value->SetFormat(" $ %2.1f", 70);
$bplot->value->SetFont(FF_ARIAL, FS_NORMAL, 9);
$bplot->value->SetColor("blue");
$bplot->value->Show();

$graph->Add($bplot);

$graph->title->Set("Idade das Pessoas");
$graph->xaxis->title->Set("Pessoas");
$graph->yaxis->title->Set("Idade");

$graph->title->SetFont(FF_FONT1, FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1, FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1, FS_BOLD);

// Send back the HTML page which will call this script again
// to retrieve the image.
$graph->StrokeCSIM();

?>
