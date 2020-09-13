       <div class="col-sm-6">
       <?php     
       if(@in_array($key,$ganti)){        
        $isi=array_search($key, $ganti);
        $visi=$isiganti[$isi];
      }else{
        $visi=$key;
      }?>
      <label><?php echo modify($visi);?></label>    
      <?php
      if(in_array($key,$auto)){
        $isi=array_search($key, $auto);?>
      <input type='text' class='form-control' name='<?php echo $key?>' id='<?php echo $key?>' value='<?php echo $autoisi[$isi];?>' readonly>
      <?php 
      }else if(in_array($key,$typeenum)){?>
      <select class='form-control' name='<?php echo $key?>' required>
        <?php if(@$editkey!=""){}else{?>
        <option value="" selected>--- Pilih Data ---</option>
        <?php
      }
      $enumq=$db->query("select substring(COLUMN_TYPE,5) as pilihan from information_schema.columns where table_name='$tabel' && table_schema='$database' and COLUMN_NAME='$key'");  
      while($enum =$enumq->fetch_assoc()){ 
        $cek=$enum['pilihan'];
      }
      $str = str_replace("')", "", str_replace("('", "", $cek));
      $pisah = explode("','", $str);
      $no=0;
      while($no < count($pisah)){?>
        <option value=<?php echo $pisah[$no]?> <?php if(@$editkey==$pisah[$no]){echo "selected";}?>><?php echo $pisah[$no]?></option>
      <?php $no++;
      }?>
      </select>
      <?php
      }else if(in_array($key,$typeint) and @!in_array($key,$typefk)){?>
      <input type='number' class='form-control' name='<?php echo $key?>' min='1' id='<?php echo $key?>' value="<?php echo @$editkey?>" required>
      <?php }else if(in_array($key,$typedate)){?>
      <input type='date' class='form-control' name='<?php echo $key?>' value="<?php echo @$editkey?>" required>
      <?php }else if(in_array($key,$typetime)){?>
      <input type='time' class='form-control' name='<?php echo $key?>' value="<?php echo @$editkey?>" required>
      <?php }else if(in_array($key,$typelongtext)){?>
      <input type='file' class='form-control' name='<?php echo $key?>' value="<?php echo @$editkey?>" required>
      <?php }else if(@in_array($key,$typefk)){?>
        <div class="row">
        <div class="col-sm-9">
        <select class='form-control' name='<?php echo $key?>' id='<?php echo $key?>' required>
        <?php
      if($typefk[0]==$key){
        $query=$query2;
      }if($typefk[1]==$key){
        $query=$query3;
      }if($typefk[2]==$key){
        $query=$query4;
      }
    if(@$editkey!=""){}else{?>
        <option value="" selected>--- Klik Cari ---</option>
        <?php
        }        
       $sql2=$db->query($query);
        while($row2=$sql2->fetch_array()){?>
        <option value='<?php echo $row2[0]?>' <?php if(@$editkey==$row2[0]){echo "selected";}?>><?php echo "$row2[$visi]"?></option>
        <?php }?>
    </select>
    </div>
    <div class="col-sm-3">
      <a class="btn btn-success" data-toggle="modal" data-target="#cari<?php echo $key?>"><i class="fa fa-search"></i></a>
    </div>
  </div>
      <?php  }else if(in_array($key,$typetext)){?>
      <textarea rows="3" cols="50" name='<?php echo $key?>' class='form-control' required><?php echo @$editkey?></textarea>
      <?php }else{?>
      <input type='text' class='form-control' name='<?php echo $key?>' id='<?php echo $key?>' value="<?php echo @$editkey?>" required>
      <?php } ?>

       </div>
      
