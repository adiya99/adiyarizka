<?php
@$page=$_GET['page'];//page
@$tabel=$_GET['tabel'];//tabel 
@$laporan=$_GET['laporan'];//tabel 
@$query=$_GET['query'];//query_pilih    
@$id=$_GET['id'];//id
$no=0;//var$no
date_default_timezone_set('Asia/Hong_Kong');
$waktu=date('Y-m-d H:i:s');//2020-12-30 14:12:10
$now=date('YmdHis');//20201230141210		
$tanggal=date('d-M-Y');//30-12-2020

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
    				$target="foto$tabel/$now$foto";
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
        	$nama_gallery=$_GET['nama_gallery'];
        	rmdir("gallery/$nama_gallery");
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
    			$target="foto$tabel/$now$foto";
    			@$temp=$_FILES[$kolom]["tmp_name"];
				$data[]="$now$foto";
				move_uploaded_file("$temp","$target");
			}else{
				@$data[]="$_POST[$kolom]";
				if($kolom=="nama_gallery"){
				mkdir("gallery/$_POST[$kolom]");
			}
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
	$d=$_SERVER['HTTP_REFERER'];
	echo "<script>location.href='$d';</script>";
}else{
	//echo "$values";
	// echo "<br>";
	// echo "ADA KESALAHAN";
}
//fungsii php
function modify($str) {
    return ucwords(str_replace("_", " ", $str));
}
function convert_to_rupiah($angka){
	return 'Rp. '.strrev(implode('.',str_split(strrev(strval($angka)),3)));
}
?>
