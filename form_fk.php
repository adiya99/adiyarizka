 <div class="modal fade bd-example-modal-lg"  id="cari<?php echo $pk?>" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pilih <?php echo $tabel;?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

       <table id="cari<?php echo $tabel;?>" class="table table-bordered table-hover table-striped">
              <thead>
             <th>No</th>
     <?php
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
    ?>    
  </thead>
  <tbody>
  <?php    
      $sql=$db->query("$query");
      while($row=$sql->fetch_object()) {  
        $no++;
        ?>
    <tr class="pilih<?php echo $tabel;?>" data-id="<?php echo $row->$pk;?>" <?php if(@isset($view)){ foreach ($view as $vkolom) {if(in_array($vkolom,$kolom) || isset($row->$vkolom)){?> <?php echo $vkolom;?>="<?php echo $row->$vkolom;?>" <?php }}}?>>
      <td><?php echo $no;?></td>
        <?php
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
    ?>  
   
    </tr>
    <?php }?>  
            </tbody>
            </table>
  </div>
  </div>
</div>
<script type="text/javascript">
   $(function () {
                var table = $('#cari<?php echo $tabel;?>').DataTable();
              });
            $(document).on('click', '.pilih<?php echo $tabel;?>', function (e) {
              document.getElementById("<?php echo $pk?>").value = $(this).attr('data-id');
              <?php
            if(@isset($view)){
              $sql=$db->query($query);
              $row=$sql->fetch_object();
            foreach ($view as $vkolom) {
              if(in_array($vkolom,$kolom) || isset($row->$vkolom)){
                  if(in_array($vkolom,$typerp)){ ?>
              document.getElementById("<?php echo $vkolom?>").value = js_to_rp($(this).attr('<?php echo $vkolom?>'));
              <?php }else{?>
              document.getElementById("<?php echo $vkolom?>").value = $(this).attr('<?php echo $vkolom?>');
            <?php }}}}  ?>
              $('#cari<?php echo $pk?>').modal('hide');
            });
</script>
