<?php
if(@$where==""){
	$where="";
}
//pk tabel
$sqlpk=$db->query("select column_name,column_key,data_type,extra from information_schema.columns where table_name='$tabel' && table_schema='$database' and column_key='PRI'");
$rowpk=$sqlpk->fetch_object();
@$pk=$rowpk->column_name;
$query="select * from $tabel $where";

//fk tabel
$sql3 = $db->query("select column_name as fk,SUBSTRING(COLUMN_NAME, 4, 100) AS tabel from information_schema.columns where table_schema='$database' and table_name='$tabel' and COLUMN_KEY='Mul' ");
//$ir=0;
$typefk = array();
$tabel_fk = array();
$tabel_fk2 = array();
while($row3=$sql3->fetch_object()){
$typefk[]=$row3->fk;	
}
if(empty($typefk)){}else{
$tfk2=array();
foreach ($typefk as $keyfk) {
	$sqlir=$db->query("select table_name as tabelfk from information_schema.columns where table_schema='$database' and COLUMN_KEY='PRI' and COLUMN_NAME='$keyfk' ");
$rowir=$sqlir->fetch_object();
$tabel_fk[]=$rowir->tabelfk;
if(in_array($rowir->tabelfk,$no_wajib)){}else{
$tabel_fk2[]=$rowir->tabelfk;
$tfk2[]=$rowir->tabelfk.".".$keyfk."=".$tabel.".".$keyfk;
}
}
$vtfk=implode(",", $tabel_fk2);
$vfk=implode(",", $typefk);
$join=implode(" join ", $tabel_fk2);
$on=implode(" and ", $tfk2);
if(empty($tabel_fk2)){}else{
$query="select * from $tabel join $join on $on $where";
}
} 
if($qnew!=""){
$query=$qnew.$where;
}
//echo $where;

?>
