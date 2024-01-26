<?php
require __DIR__.'/vendor/autoload.php'; // ajuste o caminho conforme necessário
use Dompdf\Dompdf;
use Dompdf\Options;

// Inicialize a classe Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set("isPhpEnabled", true);
$dompdf = new Dompdf($options);

// Se o botão de exportação for clicado
if (isset($_POST['exportarPDF'])) {
    // Recupere o conteúdo HTML da página
    ob_start();
    include 'despesas.php'; // substitua 'sua_pagina.php' pelo nome do seu arquivo principal
    $html = ob_get_clean();

    // Carregue o HTML no Dompdf
    $dompdf->loadHtml($html);

    // Defina o tamanho do papel (A4, carta, etc.)
    $dompdf->setPaper('A4', 'portrait');

    // Renderize o PDF (saída para o navegador ou arquivo)
    $dompdf->render();

    // Saída para o navegador
    $dompdf->stream('despesas.pdf', array('Attachment' => 0));
    exit;
}
?>
