\<?php
require 'vendor/autoload.php'; //carrega biblioteca mpdf
 
//dados de conexão com o banco de dados
$host = 'localhost';
$dbname = 'biblioteca';
$username = 'root';
$password = '';

try {
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
 
 
$query = "SELECT titulo, autor, ano_publicacao, resumo FROM livros";
$stmt = $pdo->prepare($query);
$stmt->execute();
 
$livros = $stmt->fetchAll(PDO::FETCH_ASSOC);

$mpdf = new \Mpdf\Mpdf();

$html= '<h1>Lista de Livros</h1>
<table border = "1" cellpadding = "10" cellspacing = "30" width="100%";>
    <tr>
        <th>Titulo</th>
        <th>Autor</th>
        <th>Ano de Publicacao</th>
        <th>Resumo</th>
    </tr>';

foreach($livros as $livro){
    $html .= '<tr>';
    $html .= '<td>'.htmlspecialchars($livro['titulo']).'</td>';
    $html .= '<td>'.htmlspecialchars($livro['autor']).'</td>';
    $html .= '<td>'.htmlspecialchars($livro['ano_publicacao']).'</td>';
    $html .= '<td>'.htmlspecialchars($livro['resumo']).'</td>';
}

$html .='</table>';

$mpdf->WriteHTML($html);

$mpdf->Output('relPDF.php',\Mpdf\Output\Destination::DOWNLOAD);

} catch (PDOException $e) {
    echo "Erro na conexao com o banco de dados: " . $e->getMessage();
} catch (\Mpdf\MpdfException $e) {
    echo "Erro ao gerar o PDF: " . $e->getMessage();
}
//professora, esse teclado e americano entao nao tem acento pra colocar nas palavras
?>