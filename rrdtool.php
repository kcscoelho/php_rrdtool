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

/* check id_atualizar, verifica se existe, e se a data de devolução é null, então executa update.
if (isset($id_atualizar) && !empty($id_atualizar)) {
}
*/

$file = "/var/www/programas/dev/grafico.png";
$rrdb = "/var/www/programas/graphs/fdb.rrd";
if ($debug) var_dump($file);
if ($debug) var_dump($rrdb); 

// Get params if specified in the URL - otherwise assume some sensible defaults:
$host = isset($_GET['host']) ? htmlspecialchars($_GET['host']) : "palm";
$res = isset($_GET['res']) ? htmlspecialchars($_GET['res']) : "wan";
$start = isset($_GET['start']) ? htmlspecialchars($_GET['start']) : 1;
$end = isset($_GET['end']) ? htmlspecialchars($_GET['end']) : 0;
$type = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : "b"; 
$ds0 = str_pad(isset($_GET['ds0']) ? htmlspecialchars($_GET['ds0']) : "input", 10, " ");
$ds1 = str_pad(isset($_GET['ds1']) ? htmlspecialchars($_GET['ds1']) : "output", 10, " ");
$ds0color = isset($_GET['ds0color']) ? htmlspecialchars($_GET['ds0color']) : "00FF00";
$ds1color = isset($_GET['ds1color']) ? htmlspecialchars($_GET['ds1color']) : "0000FF";

$options = array(
	"--start", 1,
	"--end", 0,
	"--title=Teste",
	"--lower-limit=0",
	"--upper-limit=100",
	"--width=450",
	"--height=120",
	"--slope-mode",
	"DEF:arraymax=".$rrdb.":devices:MAX",
    "LINE2:arraymax#ff8c00ff",
    "AREA:arraymax#ffa500cc:'Devices\n'",
    "COMMENT:'Atual\:  '",
    "GPRINT:arraymax:LAST:%6.0lf",
    "COMMENT:'\n'",
    "COMMENT:'Máximo\: ' ",
    "GPRINT:arraymax:MAX:%6.0lf ",
	"COMMENT:'\n'",
	"COMMENT:'Mínimo\: ' ",
	"GPRINT:arraymax:MIN:%6.0lf ",
	"COMMENT:\\n",
);

$resultado = rrd_graph($file, $options);

/*
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