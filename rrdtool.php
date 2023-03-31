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
$cor_preenchimento = $_GET['cor_preenchimento'];
$transparencia = $_GET['transparencia'];
$cor_linha = $_GET['cor_linha'];
$cor_grade_geral = $_GET['cor_grade_geral'];
$cor_grade_escala = $_GET['cor_grade_escala'];
$periodo = $_GET['periodo'];
$escala = $_GET['escala'];
$start = $_GET['start'];
$end = $_GET['end'];

if ($debug) echo "cor_preenchimento: " . $cor_preenchimento . "<br />";
if ($debug) echo "transparencia: " . $transparencia . "<br />";
if ($debug) echo "cor_linha: " . $cor_linha . "<br />";
if ($debug) echo "cor_grade_geral: " . $cor_grade_geral . "<br />";
if ($debug) echo "cor_grade_escala: " . $cor_grade_escala . "<br />";
if ($debug) echo "periodo: " . $periodo . "<br />";
if ($debug) echo "escala: " . $escala . "<br />";
if ($debug) echo "start: " . $start . "<br />";
if ($debug) echo "end: " . $end . "<br />";

$file = "/var/www/programas/dev/grafico.png";
$rrdb = "/var/www/programas/graphs/fdb.rrd";
if ($debug) echo "file: " . $file . "<br />";
if ($debug) echo "rrdb: " . $rrdb . "<br />";

// parâmetros do gráfico
$graphArgs = array(
 "--start","-24h",
 "--end","now",
 "--step=60",
 "--width=1152", "--height=300",
 "--x-grid=MINUTE:10:HOUR:1:HOUR:1:0:%Hh",
 "-Y",
 "--alt-autoscale",
 "--lower-limit=0",
 "--rigid",
 "--color=BACK#EEEEEE00",
 "--color=SHADEA#EEEEEE00",
 "--color=SHADEB#EEEEEE00",
 "--color=FONT#000000",
 "--color=CANVAS#FFFFFF00",
 "--color=GRID#a5a5a5",
 "--color=MGRID#FF6666",
 "--color=FRAME#5e5e5e",
 "--color=ARROW#5e5e5e",
 "--font=LEGEND:12:'DroidSansMono,DejaVuSansMono'",
 "--font=AXIS:12:'DroidSansMono,DejaVuSansMono'", "--font-render-mode=normal", "--dynamic-labels",
 "DEF:arraymax=$rrdb:devices:MAX",
 "LINE2:arraymax#ff8c00ff",
 "AREA:arraymax#ffa500cc: Devices\l",
 "COMMENT:Último\:  ",
 "GPRINT:arraymax:LAST:%6.0lf\l",
 "COMMENT:Máximo\:",
 "GPRINT:arraymax:MAX:%6.0lf\l",
 "COMMENT:Mínimo\: ",
 "GPRINT:arraymax:MIN:%6.0lf\l"
);

// gerar o gráfico
$imageData = rrd_graph($file, $graphArgs);

// verifica erro
if ($debug && !$imageData) echo "erro: " . rrd_error() . "<br />";

?>

 