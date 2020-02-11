<u style="font-size: 30px"><b>Laporan <?php echo modify("$judul");?></b></u>
<table id="tb" class="display nowrap" style="width: 100%">
	<thead>
		<th>No</th>
    <?php
    foreach ($kolom as $key) {
      echo "<th>".modify($key)."</th>";
    }
    ?>		
    <!-- <th>Aksi</th> -->
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
     <!-- <td><a href="laporan/print_satuan.php?tid=<?php echo $tabel;?>&id=<?php echo $row->$pk;?>" class="btn btn-primary"><i class="fa fa-print"></i></a></td> -->
		</tr>
		<?php }?>
	</tbody>
</table>

<script type="text/javascript">  
  $(document).ready(function() {
  $('#tb').DataTable({
  	dom: 'Bfrtip',
    responsive: true,
  	buttons: [{
                extend: 'pageLength'
                            
            },{
                text: 'Print',
      action: function ( e, dt, button, config ) {
         window.open('laporan/print_tabel.php?tid=<?php if(@$judul=="sertifikat_expired"){echo "sertifikat_exp";}elseif(@$judul=="sertifikat_masih_berlaku"){echo "sertifikat_no_exp";}else{echo $tabel;};?>','_blank');
      }        
              }]
    });
});
</script>
