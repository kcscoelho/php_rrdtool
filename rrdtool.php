<?php
/*
2023-03-28 KCSC

A pagina recebe os valores pela URL e gera um gráfico novo que substitui o anterior.
Após gerar o gráfico, redireciona para a página de exibição.
*/

$debug = false;

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

// check id_atualizar, verifica se existe, e se a data de devolução é null, então executa update.
if (isset($id_atualizar) && !empty($id_atualizar)) {
}

$rrdb="/var/www/programas/graphs/fdb.rrd"

$graphObj->setOptions(array(
    "--start" => "-24h",
    "--end" => "now",
    "--width" => "1152",
    "--height" => "300",
    "--color=BACK#00000000",
    "--color=GRID#00000000",
    "--color=MGRID#00000000",
    "DEF:arraymax=$rrdb:devices:MAX",
    "LINE2:arraymax#ff8c00ff",
	"AREA:arraymax#ffa500cc"
));

rrd_graph("grafico.png", $setOptions)

/*
$fileName = "rrd.png";
rrd_graph($fileName, $options);

header("Content-Type: image/png");
header("Content-Length: " . filesize($name));

$fp = fopen($name, 'rb');
if( $fp ) {
  fpassthru($fp);
  fclose($fp);
}

exit();
*/

/*
$rrdb="/var/www/programas/graphs/fdb.rrd"

rrdtool graph "/var/www/programas/graphs/diario.png" \
 --start -24h --end now --step=60               \
 --width=1152 --height=300                      \
 --x-grid MINUTE:10:HOUR:1:HOUR:1:0:%Hh \
 -Y --alt-autoscale --lower-limit=0 --rigid -c BACK#EEEEEE00 -c SHADEA#EEEEEE00 -c SHADEB#EEEEEE00 \
 -c FONT#000000 -c CANVAS#FFFFFF00 -c GRID#a5a5a5 -c MGRID#FF6666 -c FRAME#5e5e5e  \
 -c ARROW#5e5e5e -R normal --font LEGEND:12:'DroidSansMono,DejaVuSansMono' \
 --font AXIS:12:'DroidSansMono,DejaVuSansMono' --font-render-mode normal --dynamic-labels \
 DEF:arraymax=$rrdb:devices:MAX                 \
 LINE2:arraymax#ff8c00ff			\
 AREA:arraymax#ffa500cc:'Devices\n' \
 COMMENT:'Atual\:  '\
 GPRINT:arraymax:LAST:%6.0lf\
 COMMENT:'\n'\
 COMMENT:'Máximo\: ' \
 GPRINT:arraymax:MAX:%6.0lf \
 COMMENT:'\n'\
 COMMENT:'Mínimo\: ' \
 GPRINT:arraymax:MIN:%6.0lf \
 COMMENT:'\l'	
*/

?>