<?php
if(!isset($database)){
include "../konek.php";
$dir="../";
?>
    <link rel="stylesheet" href="../assets/datatables/jquery.dataTables.css"/>
    <link rel="stylesheet" href="../assets/datatables/buttons.dataTables.min.css"/>
    <!-- <link rel="stylesheet" href="../assets/datatables/responsive.dataTables.css?_=0733d80df58ca2854b640850303e9ae6.css"/> -->
    <script src="../assets/datatables/jquery-1.11.3.min.js"></script>    
    <script src="../assets/datatables/jquery.dataTables.js"></script>
    <script src="../assets/datatables/buttons.colVis.min.js"></script>
    <script src="../assets/datatables/buttons.html5.js"></script>
    <script src="../assets/datatables/buttons.html5.min.js"></script>
    <script src="../assets/datatables/buttons.print.min.js"></script>
    <script src="../assets/datatables/dataTables.buttons.min.js"></script>
    <!-- <script src="../assets/datatables/dataTables.responsive.js?_=0733d80df58ca2854b640850303e9ae6"></script> -->
    <script src="../assets/datatables/dataTables.select.min.js"></script>
    <script src="../assets/datatables/jszip.min.js"></script> 
    <script src="../assets/datatables/pdfmake.min.js"></script>
    <script src="../assets/datatables/vfs_fonts.js"></script>
    <link rel="stylesheet" href="../assets/bs/bootstrap.min.css">


  <a href="../login.php" class="btn btn-primary">Kembali</a><br>
<?php
}else{
$dir="";
}
//echo $query;
$queryinfo=$db->query("select column_name,column_key,data_type,extra from information_schema.columns where table_name='$tabel' && table_schema='$database'");
$kolom=array();
$baris=array();
while ($row=$queryinfo->fetch_object()){
    $kolom[]=$row->column_name;
    $baris[]=$row->column_name;
  }
if(@isset($knew)){
  $kolom=$knew;
  $baris=$knew;
}
$queryinfo=$db->query("select column_name,column_key,data_type,extra from information_schema.columns where table_name='$tabel' && table_schema='$database' and extra!='auto_increment'");
while ($row=$queryinfo->fetch_object()){
    $form_tambah[]=$row->column_name;
    $form_edit[]=$row->column_name;
  }

?>
</script>

        <table class="table table-bordered table-striped table-hover display responsive nowrap" style="width:100%" id="tb" >
          <thead>
            <tr>
              <?php 
              foreach ($kolom as $key) {?>
                <th><?= modify($key);?></th>
              <?php } ?>
            </tr>
          </thead>

            <tfoot>
            <tr style="text-align: center;">
              <?php 
              foreach ($kolom as $key) {?>
                <th><?= modify($key);?></th>
              <?php } ?>
            </tr>
          </tfoot>          
        </table>
<script type="text/javascript">
 
    $(document).ready(function() {
        tabel = $('#tb').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": true, // Set true agar bisa di sorting
            "order": [[ 0, 'desc' ]], // Default sortingnya
            "ajax":{
                "url": "<?= $folder;?>/view.php?tabel=<?= "$_GET[tabel]";?>&id=<?= "$id";?>",
                "type": "POST"
            },
            "deferRender": true,
            "aLengthMenu": [[10, 50, 100],[10, 50, 100]], // Combobox Limit
            "lengthChange": false,
            "columns": [   
            <?php for($i=0;$i<count($kolom);$i++){
              if(in_array($kolom[$i],$typeimg)){?>
                  { "data": "<?= $kolom[$i]?>",
                      "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                          $(nTd).html("<img src='<?= $dir.$kolom[$i]."-".$tabelfoto."/";?>"+oData.<?= $kolom[$i]?>+"' width=50>");
                      }
                    },
              <?php }else if(in_array($kolom[$i],$typerp)){?>
                  { "data": "<?= $kolom[$i]?>",
                   render: $.fn.dataTable.render.number( '.', '.', 0, 'Rp. ' ) 
                    },
              <?php }else{?>
                            
                { "data": "<?= $kolom[$i]?>" }, // Tampilkan nis
                <?php }}?> // Tampilkan alamat
               
            ],select: 'single',            
            dom: 'Blfrtip',
            "scrollX": true,       
            "buttons": [
            <?php if(!in_array($_GET['tabel'],$no_add)){?> 
    {
            text: '<i class="mdi mdi-account-plus"></i> Tambah Data',
            className: "btnTambah",
            action: function (e, node, config){
            $('#tbh').modal('show');            
                  }
            },
            <?php }?><?php if(!in_array($_GET['tabel'],$no_edit)){?> 
                {
                    text: "<i class='mdi mdi-update'></i> Edit Data ",
                    extend: "selected",
                    className: "btnEdit",
                    action: function ( e, dt, node, config ) {
                        data = dt.rows( { selected: true } ).data()[0]['<?= $kolom[0]?>'];
                        document.cookie = "headvalue="+data;
                        location.reload();
                    }
                },<?php }?><?php if(!in_array($_GET['tabel'],$no_del)){?>  {
                    text: "<i class='mdi mdi-trash-can-outline'></i> Hapus Data ",
                    extend: "selected",
                    className: "btnHapus",
                    action: function ( e, dt, node, config ) {
                        data = dt.rows( { selected: true } ).data()[0]['<?= $kolom[0]?>'];
                        if(confirm('Are you sure you want to delete your post?')){
                          location.href='tabel/sql_tambah_edit_hapus.php?tabel=<?= $tabel;?>&query=hapus&id='+data;
                          return false;
                        }
                    }
                },<?php }?><?php if(in_array($_GET['tabel'],$detail)){?>       
            {
            text: "<i class='mdi mdi-eye'></i> Detail Data ",
                    extend: "selected",
                    className: "btnDetail",
            action: function (e,dt, node, config){
              data = dt.rows( { selected: true } ).data()[0]['<?= $kolom[0]?>'];
          location.href='?tabel=<?= $_GET['tabel']."_detail";?>&id='+data;
                }
            },
    <?php }?>
    <?php if(@$_GET['laporan']!=""){?>       
            {
            text: 'Print',
            action: function (e, node, config){
         window.open('<?= $link;?>','_blank');
                }
            },
    <?php }?>
            {    
                extend: 'pageLength',
                className: "btnPage"                           
            }
                ],
        //         responsive: {
        //     details: {
        //         display: $.fn.dataTable.Responsive.display.modal( {
        //             header: function ( row ) {
        //                 var data = row.data();
        //                 return 'Details';
        //             }
        //         } ),
        //         renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
        //             tableClass: 'table'
        //         } )
        //     }
        // }
        });
        $(".dt-buttons").addClass("rapikan_tb_dtgrid");
        $(".btnTambah").removeClass("dt-button").addClass("btn btn-primary btn-sm");
        $(".btnEdit").removeClass("dt-button").addClass("btn btn-info btn-sm");
        $(".btnHapus").removeClass("dt-button").addClass("btn btn-danger btn-sm");
        $(".btnDetail").removeClass("dt-button").addClass("btn btn-warning btn-sm");
        $(".btnPage").removeClass("dt-button").addClass("btn btn-success btn-sm");
    });
    </script>
