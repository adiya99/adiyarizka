<?php
@$id_teknisi=$_GET['id_teknisi'];
@$tgl1=$_GET['tgl1'];
@$tgl2=$_GET['tgl2'];
if($tgl1!="" && $tgl2!=""){
$filter="Dari : $tgl1 Sampai : $tgl2";
if(isset($id_teknisi)){
$where=" where $tabel.id_teknisi='id_teknisi' and $tabel.$filter_kolom[$isi] between '$tgl1' and '$tgl2' $and";
$link="print/print_tabel.php?laporan=$laporan&id_teknisi=$id_teknisi&tgl1=$tgl1&tgl2=$tgl2";
}else{
$where=" where $tabel.$filter_kolom[$isi] between '$tgl1' and '$tgl2' $and";
$link="print/print_tabel.php?laporan=$laporan&tgl1=$tgl1&tgl2=$tgl2";
}
}
$query=$query.$where;
if(isset($id_login)){
?>
<form action="" method="GET">
<input type="hidden" name="laporan" value="<?php echo $laporan?>">
<?php if($laporan=="perawatan_perteknisi" || $laporan=="perbaikan_perteknisi"){?>
Teknisi : <select name="id_teknisi" required>
  <option disabled>--- Klik Cari ---</option>
        <?php
        
       $sql2=$db->query("select * from teknisi");
        while($row2=$sql2->fetch_array()){
          if($id_teknisi==$row2[0]){
?>
  <option value='<?php echo $row2[0]?>' selected><?php echo "$row2[nama_teknisi]"?></option>
  <?php }else{
          ?>
  <option value='<?php echo $row2[0]?>'><?php echo "$row2[nama_teknisi]"?></option>
  <?php }}?>
</select>
<?php }?>
Dari : <input type="date" name="tgl1" value="<?php echo $tgl1?>" required> Sampai :<input type="date" name="tgl2" value="<?php echo $tgl2?>" required>
<button class="btn btn-primary">Filter</button>
<a href="?laporan=<?php echo $laporan?>" class="btn btn-primary">Reset</a>

</form>
<?php }?>