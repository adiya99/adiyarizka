<?php
if(@$where==""){
	$where="";
}
//pk tabel
$sqlpk=$db->query("select column_name,column_key,data_type,extra from information_schema.columns where table_name='$tabelffk' && table_schema='$database' and column_key='PRI'");
$rowpk=$sqlpk->fetch_object();
@$pk=$rowpk->column_name;
$query="select * from $tabelffk $where";

//fk tabel
$sql3 = $db->query("select column_name as fk,SUBSTRING(COLUMN_NAME, 4, 100) AS tabel from information_schema.columns where table_schema='$database' and table_name='$tabelffk' and COLUMN_KEY='Mul' ");
$ir=0;
$typefk = array();
$tabel_fk = array();
while($row3=$sql3->fetch_object()){
$typefk[$ir]=$row3->fk;	
$tabel_fk[$ir]=$row3->tabel;	
$sqlir=$db->query("select table_name as tabelfk from information_schema.columns where table_schema='$database' and COLUMN_KEY='PRI' and COLUMN_NAME='$typefk[$ir]' ");
$rowir=$sqlir->fetch_object();
//$tabel_fk[$ir]=$rowir->tabelfk;

if($ir==0){
$query2="select * from $tabel_fk[$ir]";
$query="select $tabelffk.*,$tabel_fk[$ir].* from $tabelffk join $tabel_fk[$ir] on $tabelffk.$typefk[$ir]=$tabel_fk[$ir].$typefk[$ir] $where";

}if($ir==1){
$tabelfk3=$rowir->tabelfk;
$query3="select * from $tabelfk3";
$query="select $tabelffk.*,$tabel_fk[0].*,$tabelfk3.* from $tabelffk join $tabel_fk[0] join $tabelfk3 on $tabelffk.$typefk[0]=$tabel_fk[0].$typefk[0] and $tabelffk.$typefk[$ir]=$tabelfk3.$typefk[$ir] $where"; 

}if($ir==2){
$tabelfk4=$rowir->tabelfk;
$query4="select * from $tabelfk4";
$query="select $tabelffk.*,$tabel_fk[0].*,$tabel_fk[1].*,$tabelfk4.* from $tabelffk join $tabel_fk[0] join $tabel_fk[1] join $tabelfk4 on $tabelffk.$typefk[0]=$tabel_fk[0].$typefk[0] and $tabelffk.$typefk[1]=$tabel_fk[1].$typefk[1] and $tabelffk.$typefk[$ir]=$tabelfk4.$typefk[$ir] $where"; 
}

$ir++; 	
}
@$typefk=array("$typefk[0]","$typefk[1]","$typefk[2]");
@$tabel_fk=array("$tabel_fk[0]","$tabelfk3","$tabelfk4");

//tabel

  
 
?>
