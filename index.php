<!doctype html>
<html>
<head>
  <meta charset="utf8">
  <title>Logaramus</title>
   <link rel="stylesheet" href="http://openfontlibrary.org/face/pecita"> 
  <link rel="stylesheet" href="include/style.css"> 
  <script src="include/script.js" type="text/javascript"></script>
</head>
<body>
<h1>Logaramus</h1>
<p>
<?php 
$result = `uptime`;
$uptime = substr(trim($result), 11, -43);
$uptime = str_replace(":", " hours ", $uptime);
$uptime .= " minutes ";?>
<span id="uptime">
<?php echo "\nUp $uptime"; ?>
</span>
</p>

<div id="graph-scale">
<ul>
<li>0%</li><li>10</li><li>20</li><li>30</li><li>40</li>
<li>50</li><li>60</li><li>70</li><li>80</li><li>90</li>
</ul>
</div>

<div id="graph-wrap">
<div style="background-color:#95B858;height:1px;"></div>
<?php
$log_file = 'log.txt';
$lograw = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$log = array();
foreach($lograw as $line) {
   $split = explode('|',$line, 2);
   $timestamp = trim($split[0]);
   $log[$timestamp] = trim($split[1]);
}
$times = array('6:00','12:00','18:00');
foreach ($log as $timestamp => $loadavg) {
  $real_load = $loadavg;
  $cores = `cat /proc/cpuinfo | grep "cpu cores"`;
  $cores = $cores[12];
  $loadavg = ($loadavg * 100)/$cores;
  $date = getdate($timestamp);
  $hnm = $date['hours'].":".str_pad($date['minutes'], 2, 0, STR_PAD_LEFT);

  $bar_detail = "<a title=\"$hnm - $real_load\">";
  $bar_detail .= "<div style=\"width: $loadavg%;\"";

  if($hnm == '0:00') {
    $bar_detail .= " class=\"days\"><span>";
    $bar_detail .= $date['weekday']." ".$date['mday']."</span";
  }
  elseif(in_array($hnm, $times)) {
    $bar_detail .= " class=\"hours\"><span>$hnm</span";
  } 
  $bar_detail .= "></div></a>\n"; 
  echo $bar_detail;
}
?>
</div>

<div id="bottom-pusher"></div>

<div id="status-wrap">
  <div id="status-bar">
  <?php 
    echo date("g:i a, D j M Y")." - Load Averages: ";
    $sb_load = `cat /proc/loadavg`;
    $sb_load = substr(trim($sb_load),0,14);
    echo $sb_load;
  ?>
  <a href="javascript:location.reload(true);">Refresh</a> 
  </div>
</div>

</body>
</html>
