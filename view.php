<?php
include "$folder/konek.php"; // Load file koneksi.php
@$tabelffk=$_GET['tabel'];//tabel
@$tabel=$_GET['tabel'];//tabel 

include "$folder/tabel/atur.php"; // Load file koneksi.php
include "https://raw.githubusercontent.com/adiya99/adiyarizka/master/sql.php"; // Load file sql.php
//echo $;
@$search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
@$limit = $_POST['length']; // Ambil data limit per page
@$start = $_POST['start']; // Ambil data start

if(isset($knewv)){
	foreach ($knewv as $key) {    
//if(in_array($key,$no_cari)){}else{
	$kolom[]=$key." like '%$search%'";
//}
  }

}elseif(isset($knewfkv)){
  foreach ($knewfkv as $key) {    
//if(in_array($key,$no_cari)){}else{
  $kolom[]=$key." like '%$search%'";
//}
  }

}else{
$queryinfo=$db->query("select column_name,column_key,data_type,extra from information_schema.columns where table_name='$tabel' && table_schema='$database'");
$kolom=array();
while ($row=$queryinfo->fetch_object()){
//if(in_array($row->column_name,$no_cari)){}else{
    $kolom[]=$tabel.".".$row->column_name." like '%$search%'";
 // }
}
}

$values=implode(" or ", $kolom);
if($where==""){
$where=" where $values";
}else{
$where=" and ($values)";

}
//echo $values;
//include "tabel/sql.php";
// $where=" where nama_kategori like '%$search%'";
//echo $query.$where;
$sql = mysqli_query($connect, $query.$where); // Query untuk menghitung seluruh data siswa
// if($qnew!=""){
//   $sql= mysqli_query($connect, $qnew.$where);
//   }
@$sql_count = mysqli_num_rows($sql); // Hitung data yg ada pada query $sql

//$query = "SELECT * FROM $tabel";
// if($qnew!=""){
//   $query=$qnew.$where;
//   }else{
  $query=$query.$where;
  //}
//echo "$query";
@$order_index = $_POST['order'][0]['column']; // Untuk mengambil index yg menjadi acuan untuk sorting
@$order_field = $_POST['columns'][$order_index]['data']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
@$order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
$order = " ORDER BY ".$order_field." ".$order_ascdesc;

$sql_data = mysqli_query($connect, $query.$order." LIMIT ".$limit." OFFSET ".$start); // Query untuk data yang akan di tampilkan
$sql_filter = mysqli_query($connect, $query); // Query untuk count jumlah data sesuai dengan filter pada textbox pencarian
@$sql_filter_count = mysqli_num_rows($sql_filter); // Hitung data yg ada pada query $sql_filter

@$data = mysqli_fetch_all($sql_data, MYSQLI_ASSOC); // Untuk mengambil data hasil query menjadi array
$callback = array(
    'draw'=>@$_POST['draw'], // Ini dari datatablenya
    'recordsTotal'=>$sql_count,
    'recordsFiltered'=>$sql_filter_count,
    'data'=>$data
);

header('Content-Type: application/json');
echo json_encode($callback); // Convert array $callback ke json
?>
