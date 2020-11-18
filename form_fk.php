<?php
$tabel=$tabelffk;
include "$folder/tabel/atur.php";
if(@isset($knewfk) and !in_array($tabelffk,$normalfk)){
  $kolomfk=$knewfk;
  $barisfk=$knewfk;
}
?>
 <div class="modal fade bd-example-modal-lg"  id="cari<?php echo $pk?>" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Pilih <?php echo modify("$tabel");?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>

       <table id="cari<?php echo $tabel;?>" class="table table-bordered table-striped table-hover display responsive nowrap" style="width:100%">
              <thead>
             <!-- <th>No</th> -->
     <?php
     if(@isset($view_tb)){
      foreach (@$view_tb as $vkolom2) {?>
      <th><?php echo modify($vkolom2);?></th>
      <?php }}
     foreach ($kolomfk as $key) {
      if(@in_array($key,$hidden_tb)){      
      }
      
      else{?>
      <th><?php echo modify($key);?></th>
    <?php }}
    ?>    
  </thead>
  
            </table>
  </div>
  </div>
</div>

<script type="text/javascript">
  $(document).on('shown.bs.modal', function (e) {
      $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
});
     $(function () {
                var table = $('#cari<?php echo $tabel;?>').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": true, // Set true agar bisa di sorting
            "order": [[ 0, 'desc' ]], // Default sortingnya
            "ajax":{
                "url": "view.php?tabel=<?php echo "$tabel";?>&id=<?php echo "$id";?>",
                "type": "POST"
            },
            "deferRender": true,
            "aLengthMenu": [[10, 50, 100],[10, 50, 100]], // Combobox Limit
            "lengthChange": true,
            "columns": [   
            <?php for($i=0;$i<count($kolomfk);$i++){
              if(in_array($kolomfk[$i],$typeimg)){?>
                  { "data": "<?php echo $kolomfk[$i]?>",
                      "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                          $(nTd).html("<img src='<?php echo $kolomfk[$i]."-".$tabel."/";?>"+oData.<?php echo $kolomfk[$i]?>+"' width=50>");
                      }
                    },
              <?php }else if(in_array($kolomfk[$i],$typerp)){?>
                  { "data": "<?php echo $kolomfk[$i]?>",
                   render: $.fn.dataTable.render.number( '.', '.', 0, 'Rp. ' ) 
                    },
              <?php }else{?>
                            
                { "data": "<?php echo $kolomfk[$i]?>" }, // Tampilkan nis
                <?php }}?> // Tampilkan alamat
               
            ],"scrollX": true,
            fnCreatedRow: function( nRow, aData, iDataIndex ) {
        $(nRow).attr('my_custom_attr',aData['<?php echo $kolomfk[0]?>']);
    }});
              });
            $(document).on('click', '#cari<?php echo $tabel;?> tr', function (e) {
              document.getElementById("<?php echo $pk?>").value = $(this).attr('my_custom_attr');
              <?php
            if(@isset($view_form)){
              $sql=$db->query($query);
              $row=$sql->fetch_object();
            foreach ($view_form as $vkolom) {
              if(in_array($vkolom,$kolom) || isset($row->$vkolom)){
                  if(in_array($vkolom,$typerp)){ ?>
              document.getElementById("<?php echo $vkolom?>").value = js_to_rp($(this).attr('<?php echo $vkolom?>'));
              <?php }else{?>
              document.getElementById("<?php echo $vkolom?>").value = $(this).attr('<?php echo $vkolom?>');
            <?php }}}}
              ?>
            $("#cari<?php echo $pk?> .close").click();
              
            });
</script>
