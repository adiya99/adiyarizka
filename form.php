<style type="text/css">
  #scrollbox {
overflow-y: auto;
max-height: calc(90vh - 150px);
}
</style>
<?php
 @$edit_id=$_COOKIE["headvalue"];
    if(@$edit_id!=""){ 
      $where=" where $tabel.$pk='$edit_id'";
      ?>
        <script>
                 $(function(){
                     $('#edit').modal('show');
                     document.cookie = "headvalue" + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                 });
        </script>
<?php
if($qnew!=""){
  $query=$qnew;
}
$sql=$db->query("$query"."$where");
      $row=$sql->fetch_object();
?>
<div class="modal modal-info fade" id="edit">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Edit <?php echo modify("$tabel");?></h5>
        <button class="close" data-dismiss="modal" ></button>
      </div>
        <form action="tabel/sql_tambah_edit_hapus.php?tabel=<?php echo $tabel;?>&query=edit&id=<?php echo $row->$pk?>" method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-12 mx-auto">
      
         <div class="modal-body">          
        <div id="scrollbox">
        <div class="form-group row">

          <?php
        if(@isset($view_form)){
        foreach ($view_form as $vkolom2) {?>
          <div class='col-sm-6'>
          <label><?php echo modify($vkolom2);?></label>
          <input type='text' class='form-control' id='<?php echo $vkolom2;?>' value='<?php echo $row->$vkolom2;?>' readonly></div>
          <?php }}
        foreach ($form_edit as $key) {
          @$editkey=$row->$key;
          if(in_array($key,$hidden_form)){?>
          <input type="hidden" name='<?php echo $key?>' id='<?php echo $key?>' value='<?php echo $row->$key;?>'>
          <?php
          }else{
          include "isiform.php";
          }
        }
        ?>  
      
           </div>
           </div>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-secondary close-edit" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
  </div>      
    </div>
    </form>
    </div>
  </div>
</div>
<?php         
    }else{?>
<!-- form tambah -->
<div class="modal modal-info fade" id="tbh">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Tambah <?php echo modify("$tabel");?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="tabel/sql_tambah_edit_hapus.php?tabel=<?php echo $tabel;?>&query=tambah" method="POST" enctype="multipart/form-data">

       <div class="row">
        <div class="col-md-12 mx-auto">
      <div class="modal-body ">
        <div id="scrollbox">
        <div class="form-group row">   

        <?php
        if(@isset($view_form)){
        foreach ($view_form as $vkolom2) {?>
          <div class='col-sm-6'>
          <label><?php echo modify($vkolom2);?></label>
          <input type='text' class='form-control' id='<?php echo $vkolom2;?>' readonly></div>
          <?php }}
        foreach ($form_tambah as $key) {
          if(in_array($key,$hidden_form)){?>
          <input type="hidden" name='<?php echo $key?>' id='<?php echo $key?>'>
          <?php
          }else{
          include "isiform.php";
          }
        }
        ?>  
      </div>
      </div>
      </div>
      <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </div>
  </div>
      </form>
    </div>
  </div>
</div>
    <?php }

if(empty($tabel_fk)){}else{
foreach ($tabel_fk as $tbfk) {    
  $qfk=$db->query("select column_name from information_schema.columns where table_name='$tbfk' && table_schema='$database'");
  $kolomfk=array();
while ($rowfk=$qfk->fetch_object()){
    $kolomfk[]=$rowfk->column_name;
  }
$tabelffk=$tbfk;
if($tabelffk=="barang"){
$where=" where stok>0";
}else{
$where="";
}
include "sqlfk.php";
include "form_fk.php";
}
}

?>
