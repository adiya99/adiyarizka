<?php
//form
$queryinfo=$db->query("select column_name,column_key,data_type,extra from information_schema.columns where table_name='$tabel' && table_schema='$database' and extra!='auto_increment'");
while ($row=$queryinfo->fetch_object()){
    $form_tambah[]=$row->column_name;
    $form_edit[]=$row->column_name;
  }
?>
<br>
<div class="box">
<div class="box-body table-responsive">
  <table id="tb" class="table table-bordered table-striped">
  <thead style="font: bold 15px serif;">
    <th>No</th>
    <?php
    if(@isset($view)){
      foreach (@$view as $vkolom2) {?>
      <th><?php echo modify($vkolom2);?></th>
      <?php }}
      foreach ($kolom as $key) {
      if(@in_array($key,$hidden_tb)){      
      }else if(@in_array($key,$ganti)){        
        $isi=array_search($key, $ganti);        
        $visi=$isiganti[$isi];
        ?>      
      <th><?php  echo modify($visi);?></th>
      <?php
      }else{?>
      <th><?php echo modify($key);?></th>
    <?php }}
    if(@$_GET['print']){}else{
    ?>    
    <th>Aksi</th>
    <?php }?>
  </thead>
  <tbody>
  <?php    
  if(@isset($qnew)){
  $query=$qnew.$where;
  }
  //echo "$query";
   $sql=$db->query($query);
   while($row=$sql->fetch_object()) {  
        $no++;
        ?>
    <tr>
      <td width="50px"><?php echo $no;?></td>
      <?php
      if(@isset($view)){
        foreach ($view as $vkolom2) {?>
      <td><?php echo $row->$vkolom2;?></td>
      <?php }}
    foreach ($baris as $key) {
      if(@in_array($key,$hidden_tb)){      
      }else if(@in_array($key,$ganti)){        
        $isi=array_search($key, $ganti);        
        $visi=$isiganti[$isi];
        ?>      
      <td><?php  echo $row->$visi;?></td>
      <?php
      }else if(in_array($key,$typerp)){?>
      <td><?php  echo php_to_rp($row->$key)?></td>
      <?php
      }else if(in_array($key,$typeimg)){?>
      <td><img src='<?php echo $key."-".$tabel."/".$row->$key?>' height=50></td>
      <?php }else{?>      
      <td><?php  echo $row->$key;?></td>
      <?php
      }}
      if(@$_GET['print']){}elseif(@$_GET['laporan']){?>
    <td width="50px">
      <?php if(in_array($tabel,$print_satuan)){ ?>
      <button class="btn btn-xs btn-success" onclick="location.href='tabel/print_satuan.php?print=<?php echo $tabel;?>&id=<?php echo $row->$pk;?>'"><i class="fa fa-print"></i> Print</button>
      <?php }?>
</td>
      <?php }else{
    ?>  
    <td width="250px">
      <?php if(in_array($tabel,$print_satuan)){ ?>
      <button class="btn btn-xs btn-success" onclick="location.href='tabel/print_satuan.php?print=<?php echo $tabel;?>&id=<?php echo $row->$pk;?>'"><i class="fa fa-print"></i> Print</button>
      <?php }if(in_array($tabel,$detail)){ ?>
      <detail class="btn btn-xs btn-success" onclick="location.href='?tabel=<?php echo $tabel."_detail";?>&id=<?php echo $row->$pk;?>'"><i class="fa fa-eye"></i> Detail</detail>
      <?php }if(!in_array($tabel,$no_edit) and @$_GET['tabel']){ ?>
          <button class="btn btn-xs btn-info btn-edit" id="<?php echo $row->$pk;?>" ><i class="fa fa-edit"></i> Edit</button>
      <?php }if(!in_array($tabel,$no_del) and @$_GET['tabel']){?>
          <button class="btn btn-xs btn-danger" onclick="if(confirm('Are you sure you want to delete your post?')){location.href='konek.php?tabel=<?php echo $tabel;?>&query=hapus&id=<?php echo $row->$pk;?>';return false;};"><i class="fa fa-trash"></i> Hapus</button>
          <?php }?>
          </td>   
          <?php }?>
    </tr>
    <?php }?>
  </tbody>
</table>
  
