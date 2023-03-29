<?php
/*
2023-03-28 KCSC

A pagina recebe os valores pela URL e gera um gráfico novo que substitui o anterior.
Após gerar o gráfico, redireciona para a página de exibição.
*/

$debug = true;

// check IP
if ($debug) echo $_SERVER['REMOTE_ADDR'] . "<br />";
$IP=substr($_SERVER['REMOTE_ADDR'],0,12);
if ($IP != '200.144.232.') {// { die("No no no..."); }
if ($IP != '143.107.191.') { die("No no no..."); }
}

// recebe valores
$cor_preenchimento = $_POST['cor_preenchimento'];
$transparencia = $_POST['transparencia'];
$cor_linha = $_POST['cor_linha'];
$cor_grade_geral = $_POST['cor_grade_geral'];
$cor_grade_escala = $_POST['cor_grade_escala'];
$periodo = $_POST['periodo'];
$escala = $_POST['escala'];
$start = $_POST['start'];
$end = $_POST['end'];

if ($debug) echo "cor_preenchimento: " . $cor_preenchimento . "<br />";
if ($debug) echo "transparencia: " . $transparencia . "<br />";
if ($debug) echo "cor_linha: " . $cor_linha . "<br />";
if ($debug) echo "cor_grade_geral: " . $cor_grade_geral . "<br />";
if ($debug) echo "cor_grade_escala: " . $cor_grade_escala . "<br />";
if ($debug) echo "periodo: " . $periodo . "<br />";
if ($debug) echo "escala: " . $escala . "<br />";
if ($debug) echo "start: " . $start . "<br />";
if ($debug) echo "end: " . $end . "<br />";

// check id_atualizar, verifica se existe, e se a data de devolução é null, então executa update.
if (isset($id_atualizar) && !empty($id_atualizar)) {
}

?>