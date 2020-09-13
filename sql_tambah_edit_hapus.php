<?php
date_default_timezone_set('Asia/Hong_Kong');
$waktu=date('Y-m-d H:i:s');//2020-12-30 14:12:10
$now=date('YmdHis');//20201230141210		
$tanggal=date('d-M-Y');//30-12-2020

@$tabel=$_GET['tabel'];//tabel 
@$query=$_GET['query'];//query_pilih    
@$id=$_GET['id'];//id

if($tabel!=""){
$queryinfo=$db->query("select column_name,column_key,data_type,extra from information_schema.columns where table_name='$tabel' && table_schema='$database' order by ordinal_position asc");
}if($tabel!="" && $id!=""){
	while ($row=$queryinfo->fetch_object()){
		@$kolom=$row->column_name;
        $kolomtype=$row->data_type;

    	if($row->column_key=="PRI"){
        	$pkai=$kolom;
        }else{    		
        	if($query=="edit"){

    		if($kolomtype=="longtext"){
    			@$foto=$_FILES[$kolom]["name"];	
				if($foto!=""){
    			$target="$kolom"."-"."$tabel/$now$foto";				
    				@$temp=$_FILES[$kolom]["tmp_name"];
					$image="$now$foto";
					$sql = $db->query("UPDATE $tabel SET $tabel.$kolom='$image' where $tabel.$pkai = '$id'");
					move_uploaded_file("$temp","$target");
				}
			}else{
				
				if(@$_POST[$kolom]!="" && ($kolom=="password" || $kolom=="Password")){
				@$isikolom=$_POST[$kolom];	
							
				@$sql = $db->query("UPDATE $tabel SET $tabel.$kolom='$isikolom' where $tabel.$pkai = '$id'");			
    		}else{
				@$sql = $db->query("UPDATE $tabel SET $tabel.$kolom='$_POST[$kolom]' where $tabel.$pkai = '$id'");
    		}
    	}			
		}
        if($query=="hapus"){
		$sql = $db->query("DELETE from $tabel where $pkai='$id'");
		
	}
}
}
}
if($query=="tambah"){
	while ($row=$queryinfo->fetch_object()){
		$kolom=$row->column_name;
    	$kolomtype=$row->data_type;

    	if($row->extra=="auto_increment"){
        	$ai=$kolom;
        }
    	if($kolom!=@$ai ){	
   			if($kolom=="password" || $kolom=="Password"){
				$data[]=$_POST[$kolom];
			} else if($kolomtype=="longtext"){
				@$foto=$_FILES[$kolom]["name"];		
    			$target="$kolom"."-"."$tabel/$now$foto";
    			@$temp=$_FILES[$kolom]["tmp_name"];
				$data[]="$now$foto";
				move_uploaded_file("$temp","$target");
			}else{
				@$data[]="$_POST[$kolom]";
				
			}
		}
	}		
	$values=implode("','", $data);
	$status_ai=$db->query("SHOW TABLE STATUS LIKE '$tabel'");
	$rowstatus_ai=$status_ai->fetch_object();
	if(@$ai!=""){
		@$sql = $db->query("INSERT INTO $tabel VALUES ($rowstatus_ai->Auto_increment,'$values')");
	}else{
		@$sql = $db->query("INSERT INTO $tabel VALUES ('$values')");
	}
}

if(@$sql){
	echo "<script>location.href='$_SERVER[HTTP_REFERER]';</script>";
}
@$page=$_GET['page'];//page
@$laporan=$_GET['laporan'];//laporan 
$no=0;//var$no
//fungsii php
function modify($str){
    return ucwords(str_replace("_", " ", $str));
}
function php_to_rp($angka){
	return 'Rp. '.strrev(implode('.',str_split(strrev(strval($angka)),3)));
}
?>
<script type="text/javascript">
  function js_to_rp(angka){
  var rupiah = '';    
  var angkarev = angka.toString().split('').reverse().join('');
  for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
  return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
}
  function js_to_angka(rupiah){
  return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
}
</script>