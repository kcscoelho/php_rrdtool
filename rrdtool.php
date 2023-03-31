<?php
/*
2023-03-28 KCSC

A pagina recebe os valores pela URL e gera um gráfico novo que substitui o anterior.
Após gerar o gráfico, redireciona para a página de exibição.
*/

$debug = 0;

// check IP
if ($debug) echo $_SERVER['REMOTE_ADDR'] . "<br />";
$IP=substr($_SERVER['REMOTE_ADDR'],0,12);
if ($IP != '200.144.232.') {
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

// converter transparência de 0 a 255 em hexadecimal de dois dígitos, by ChatGPT =D
if ($debug) echo "transparencia: " . $transparencia . "<br />";
$transparencia = dechex($transparencia); // converter para hexadecimal
$transparencia = str_pad($transparencia, 2, '0', STR_PAD_LEFT); // adicionar zero à esquerda, se necessário

if ($debug) echo "cor_preenchimento: " . $cor_preenchimento . "<br />";
if ($debug) echo "transparencia: " . $transparencia . "<br />";
if ($debug) echo "cor_linha: " . $cor_linha . "<br />";
if ($debug) echo "cor_grade_geral: " . $cor_grade_geral . "<br />";
if ($debug) echo "cor_grade_escala: " . $cor_grade_escala . "<br />";
if ($debug) echo "periodo: " . $periodo . "<br />";
if ($debug) echo "escala: " . $escala . "<br />";
if ($debug) echo "start: " . $start . "<br />";
if ($debug) echo "end: " . $end . "<br />";

// files
$file = "/var/www/programas/dev/grafico.png";
$rrdb = "/var/www/programas/graphs/fdb.rrd";
if ($debug) echo "file: " . $file . "<br />";
if ($debug) echo "rrdb: " . $rrdb . "<br />";

// start to unix
if ($start == "") $start = date("d-m-Y");
$start = strtotime($start);
if ($debug) echo "start unix: " . $start . "<br />";

// end to unix
if ($end == "") $end = date("d-m-Y");
$end = strtotime($end);
if ($debug) echo "end unix: " . $end . "<br />";

// escala
$escala = ($escala == 0) ? "--alt-autoscale" : "--upper-limit=$escala";
if ($debug) echo "escala: " . $escala . "<br />";

// parâmetros do gráfico
$graphArgs = array(
 "--start", $start,
 "--end", $end+24*60*60,    // caso o usuário escolha como data inicial e final o mesmo dia, incrementa o tempo em 24h em unixtime.
 "--step=60",
 "--width=1152", "--height=300",
 "-Y",
 "--lower-limit=0",
 $escala,
 "--rigid",
 "--color=BACK#FFF",        // fixo, fundo da área da imagem
 "--color=SHADEA#FFF",      // fixo, borda superior e esquerda
 "--color=SHADEB#FFF",      // fixo, borda inferior e direita
 "--color=FONT#000",        // fixo, fonte
 "--color=CANVAS#FFF",      // fixo, fundo da área de plotagem
 "--color=GRID$cor_grade_geral",     // personalizado, grade geral
 "--color=MGRID$cor_grade_escala",    // personalizado, grade das escalas
 "--color=FRAME#5e5e5e",    // fixo, quadradinho da legenda
 "--color=ARROW#5e5e5e",    // fixo, setinha dos eixos
 "--font=LEGEND:10:'DroidSansMono,DejaVuSansMono'",
 "--font=AXIS:10:'DroidSansMono,DejaVuSansMono'", "--font-render-mode=normal", "--dynamic-labels",
 "DEF:arraymax=$rrdb:devices:MAX",
 "LINE2:arraymax$cor_linha",   // personalizado, linha dos dados
 "AREA:arraymax$cor_preenchimento$transparencia: Devices\l",   // personalizado, área dos dados + transparência
 "COMMENT:Último\:",
 "GPRINT:arraymax:LAST:%6.0lf\l",
 "COMMENT:Máximo\:",
 "GPRINT:arraymax:MAX:%6.0lf\l",
 "COMMENT:Mínimo\:",
 "GPRINT:arraymax:MIN:%6.0lf\l"
);

// gerar o gráfico
$imageData = rrd_graph($file, $graphArgs);

// verifica erro
if ($debug && !$imageData) echo "erro: " . rrd_error() . "<br />";

// redirect to show page
if ($debug) die();

header("Location: .");
die();