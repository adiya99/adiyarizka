
<link rel="stylesheet" type="text/css" href="style_tabel.css">

<body onload="window.print()">
<?php
include "../konek.php";
$tabel=$_GET['print'];
?>
<center>
<img src="../assets/images/bg.jpg" width="600px">
  <?php
  echo "<h2>Laporan Data ".modify($tabel)."<br>".modify(@$filter)."</h2>";
  ?>
  <br>
  <br>
  <?php include "tabel.php";?>
<div style="width:900px;text-align: right;">
<h3> 
<?php
echo "Banjarmasin, $tanggal";
?>
<pre>
<!-- Administrator -->




(.....................)
</pre>
</h3>
</div>
</center>
</body>