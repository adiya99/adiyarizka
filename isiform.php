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
      <input type='number' class='form-control' name='<?php echo $key?>' min='1' id='<?php echo $key?>' value="<?php echo @$editkey?>" PlaceHolder="Silahkan isi <?php echo @modify($key)?>" required>
      <?php }else if(in_array($key,$typedate)){?>
      <input type='date' class='form-control' name='<?php echo $key?>' value="<?php echo @$editkey?>" PlaceHolder="Silahkan isi <?php echo @modify($key)?>" required>
      <?php }else if(in_array($key,$typetime)){?>
      <input type='time' class='form-control' name='<?php echo $key?>' value="<?php echo @$editkey?>" PlaceHolder="Silahkan isi <?php echo @modify($key)?>" required>
      <?php }else if(in_array($key,$typelongtext)){?>
      <input type='file' class='form-control' name='<?php echo $key?>' value="<?php echo @$editkey?>" required>
      <?php }else if(@in_array($key,$typefk)){?>
        <div class="row">
        <div class="col-sm-9">
        <input type="text" class='form-control' name='<?php echo $key?>' id='<?php echo $key?>' value="<?php echo @$editkey?>" onkeypress="return false" onkeydown="return false" required>
    </div>
    <div class="col-sm-3">
      <a class="btn btn-success" data-toggle="modal" data-target="#cari<?php echo $key?>">Cari</a>
    </div>
  </div>
      <?php  }else if(in_array($key,$typetext)){?>
      <textarea rows="3" cols="50" name='<?php echo $key?>' class='form-control' PlaceHolder="Silahkan isi <?php echo @modify($key)?>" required><?php echo @$editkey?></textarea>
      <?php }else{?>
      <input type='text' class='form-control' name='<?php echo $key?>' id='<?php echo $key?>' value="<?php echo @$editkey?>" PlaceHolder="Silahkan isi <?php echo @modify($key)?>" required>
      <?php } ?>

       </div>
      
