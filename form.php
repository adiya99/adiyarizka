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
if(@isset($qnew)){
  $query=$qnew;
}
//echo "$query"."$where";
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
        <form action="konek.php?tabel=<?php echo $tabel;?>&query=edit&id=<?php echo $row->$pk?>" method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-12 mx-auto">
      
         <div class="modal-body">
        <div class="form-group row">

          <?php
        if(@isset($view)){
        foreach ($view as $vkolom2) {?>
          <div class='col-sm-6'>
          <label><?php echo modify($vkolom2);?></label>
          <input type='text' class='form-control' id='<?php echo $vkolom2;?>' value='<?php echo $row->$vkolom2;?>' readonly></div>
          <?php }}
        foreach ($form_tambah as $key) {
          $editkey=$row->$key;
          if(in_array($key,$hidden_form)){?>
          <input type="hidden" name='<?php echo $key?>' id='<?php echo $key?>' value='<?php echo $row->$key;?>'>
          <?php
          }else{
          include "https://raw.githubusercontent.com/adiya99/adiyarizka/master/isiform.php";
          }
        }
        ?>  
      
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
        <h5>Tambah <?php echo modify("$tabel");?></h5>
        <button class="close" data-dismiss="modal" ></button>
      </div>
      <form action="konek.php?tabel=<?php echo $tabel;?>&query=tambah" method="POST" enctype="multipart/form-data">

       <div class="row">
        <div class="col-md-12 mx-auto">
      <div class="modal-body ">
        <div class="form-group row">   

        <?php
        if(@isset($view)){
        foreach ($view as $vkolom2) {?>
          <div class='col-sm-6'>
          <label><?php echo modify($vkolom2);?></label>
          <input type='text' class='form-control' id='<?php echo $vkolom2;?>' readonly></div>
          <?php }}
        foreach ($form_tambah as $key) {
          if(in_array($key,$hidden_form)){?>
          <input type="hidden" name='<?php echo $key?>' id='<?php echo $key?>'>
          <?php
          }else{
          include "https://raw.githubusercontent.com/adiya99/adiyarizka/master/isiform.php";
          }
        }
        ?>  
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

//form fk    
for($i=-1;$i<100;$i++){
if(@$tabel_fk[$i]!=""){
  $qfk=$db->query("select column_name from information_schema.columns where table_name='$tabel_fk[$i]' && table_schema='$database'");
  $kolom=array();
while ($rowfk=$qfk->fetch_object()){
    $kolom[]=$rowfk->column_name;
  }
$tabel=$tabel_fk[$i];
$where="";
include "https://raw.githubusercontent.com/adiya99/adiyarizka/master/sql.php";
include "https://raw.githubusercontent.com/adiya99/adiyarizka/master/form_fk.php";
//echo $query;
}
}

?>
