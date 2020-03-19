<!-- <u style="font-size: 30px"><b>Tabel <?php echo modify("$tabel");?></b></u> -->
<table id="tb" class="display nowrap" style="width: 100%">
	<thead>
		<th>No</th>
    <?php
    foreach ($kolom as $key) {
      echo "<th>".modify($key)."</th>";
    }
    ?>		
		<th>Aksi</th>
	</thead>
	<tbody>
	<?php    	
      $sql=$db->query($query);
    	while($row=$sql->fetch_object()) {        
		$no++;
    ?>
		<tr>
			<td><?php echo $no;?></td>
        <?php
    foreach ($baris as $key) {
      echo "<td>".$row->$key."</td>";
    }
    ?>     
      <td>
		        <button data-toggle="modal" data-target="#edit<?php echo $row->$pk;?>">
					<i class="fa fa-edit"></i>
		        </button>
		        <button onclick="if(confirm('Are you sure you want to delete your post?')){location.href='konek.php?tabel=<?php echo $tabel;?>&query=hapus&id=<?php echo $row->$pk;?>';return false;};">
		            <i class="fa fa-trash"></i>
		        </button>
      		</td>
		</tr>
		<?php }?>
	</tbody>
</table>

<script type="text/javascript">  
  $(document).ready(function() {
  $('#tb').DataTable({
  	dom: 'Bfrtip',
    "scrollX": true,
  	buttons: [{
           	text: 'Tambah Data',
            action: function (e, node, config){
            		$('#tbh').modal('show')
                	}
            },{
                extend: 'pageLength'
                            
            }]
    });
});
</script>

<div class="modal fade" id="tbh">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Tambah <?php echo modify("$tabel");?></h5>
        <button class="close" data-dismiss="modal" ></button>
      </div>
      <form action="konek.php?tabel=<?php echo $tabel;?>&query=tambah" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
  <?php
    foreach ($tambahlabel as $key) {

      echo "<label>".modify($key)."</label>";

      if(in_array($key,$typedate)){
      echo "<input type='date' class='form-control' name='$key'>";
      }else if(in_array($key,$typefile)){
      echo "<input type='file' class='form-control' name='$key'>";
      }else if(@in_array($key,$typefk)){
        echo "<select class='form-control' name='$key'>";
        if (in_array($fk,$typefk) && $fk==$key) {
        echo "<option disabled selected>--- Pilih Data ---</option>";
        $sql2=$db->query($query2);
        while($row2=$sql2->fetch_array()){  
        echo "<option value='$row2[0]'>$row2[0] | $row2[1]</option>";
        }
      }else if (in_array($fk2,$typefk) && $fk2==$key) {
        echo "<option disabled selected>--- Pilih Data ---</option>";
        $sql2=$db->query($query3);
        while($row2=$sql2->fetch_array()){  
        echo "<option value='$row2[0]'>$row2[0] | $row2[1]</option>";
        }
      }
        echo "</select>";
      }else{
      echo "<input type='text' class='form-control' name='$key'>";
      }
     
    }
    ?>    
      
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>

<?php 
      $sql=$db->query($query);
      while($row=$sql->fetch_object()) {
?>
<div class="modal fade" id="edit<?php echo $row->$pk;?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Edit <?php echo modify("$tabel");?></h5>
        <button class="close" data-dismiss="modal" ></button>
      </div>
      <form action="konek.php?tabel=<?php echo $tabel;?>&query=edit&id=<?php echo $row->$pk?>" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
       <?php
    foreach ($tambahlabel as $key) {
      $editkey=$row->$key;

      echo "<label>".modify($key)."</label>";

      if(in_array($key,$typedate)){
      echo "<input type='date' class='form-control' name='$key' value='$editkey'>";
      }else if(in_array($key,$typefile)){
      echo "<input type='file' class='form-control' name='$key' value='$editkey'>";
      }else if(@in_array($key,$typefk)){
        echo "<select class='form-control' name='$key'>";
        if (in_array($fk,$typefk)  && $fk==$key) {
        //echo "<option disabled selected>--- Pilih Data ---</option>";
        $sql2=$db->query($query2);
        while($row2=$sql2->fetch_array()){  
          if($row2[0]==$editkey){
        echo "<option value='$row2[0]' selected>$row2[0] | $row2[1]</option>";
          }else{
        echo "<option value='$row2[0]'>$row2[0] | $row2[1]</option>";
      }
        }
      }else  if (in_array($fk2,$typefk)  && $fk2==$key) {
        //echo "<option disabled selected>--- Pilih Data ---</option>";
        $sql2=$db->query($query3);
        while($row2=$sql2->fetch_array()){  
          if($row2[0]==$editkey){
        echo "<option value='$row2[0]' selected>$row2[0] | $row2[1]</option>";
          }else{
        echo "<option value='$row2[0]'>$row2[0] | $row2[1]</option>";
      }
        }
      }
        echo "</select>";
      }else{
      echo "<input type='text' class='form-control' name='$key' value='$editkey'>";
      }
     
    }
    ?>    
      
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php }?>
