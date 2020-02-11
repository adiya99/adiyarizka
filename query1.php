<?php
if(@$where==""){
  $where="";
}
if($fk2!="" && $tabel!=""){ //relasi 3 tabel
$query="select $tabel.*,$tabel2.*,$tabel3.* from $tabel join $tabel2 join $tabel3 on $tabel.$fk=$tabel2.$fk and $tabel.$fk2=$tabel3.$fk2 $where";
$query2="select * from $tabel2 $where";
$query3="select * from $tabel3 $where";
}
//jika ada 1 fk
else if($fk!="" && $fk2==""){ //relasi 2 tabel
$query="select $tabel.*,$tabel2.* from $tabel join $tabel2 on $tabel.$fk=$tabel2.$fk $where";
$query2="select * from $tabel2 $where";
}else{ //master data
$query="select * from $tabel $where";
}
//echo "$query";
?>
