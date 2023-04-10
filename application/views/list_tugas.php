<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">

            <h2>List Tugas</h2>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">V1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->

    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
            
                <?php foreach ($matakuliah as $mk) {?>        
                <div class="col-lg-3 col-md-6 col-sm-9">
                    <!-- small box -->
                    <div class="small-box <?php if($mk->warna == 1) {
                        echo "bg-info";
                    } else if ($mk->warna == 2) {
                        echo "bg-success";
                    } else if ($mk->warna == 3) {
                        echo "bg-warning";
                    } else {
                        echo "bg-danger";
                    }?>">
                    <div class="inner">
                        <h2 style="font-size: huge; color: white;"><a href="" data-toggle="modal" data-target="#modalMK<?=$mk->id?>" style="color: white;"><?= $mk->mata_kuliah?></a></h2>
                        <?php 
                            $i = 0;
                        ?>
                        <?php foreach($tugas as $tg) {
                            if ($tg->mata_kuliah == $mk->mata_kuliah) {
                                $i++;
                            }                        
                        }?>
                        <p style="color: white;"><?=$i?> tugas</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <span class="small-box-footer">
                        <!-- More info <i class="fas fa-arrow-circle-right"></i> -->
                        <ul style="text-align: left;">
                        <?php foreach ($tugas as $tg) {?>
                            <?php if ($tg->mata_kuliah == $mk->mata_kuliah) {?>
                                <li><a href="" style="color: white;" data-toggle="modal" data-target="#modalTugas<?=$tg->id?>"><span class="badge badge-info right"><?=$tg->sudah_selesai?></span> <?=$tg->nama_tugas?></a></li>
                            <?php }?> 
                        <?php }?>
                        </ul>
                    </span>
                    </div>
                </div>
                <!-- ./col -->
                <?php }?>
            </div>
            
            <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Persentase Selesai tugas
                        </h3>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                      <div class="row">
                        <div class="col">
                          <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                        <div class="col">
                        <?php 
                          $belum = 0;
                          $sudah = 0;
                          foreach ($tugas as $tg) {
                          $compare = "Belum";
                          if(strcmp( $tg->sudah_selesai, $compare ) == 0) {
                            $belum = $belum+1;
                          } else {
                            $sudah = $sudah+1;
                          }
                          if($belum == 0 || $sudah == 0) {
                            if($belum == 0) {
                              $belumPerc = 0;
                            } else {
                              $belumPerc = ($belum/($belum+$sudah))*100;
                            }    
                            if($sudah == 0) {
                              $sudahPerc = 0;
                            } else {
                              $sudahPerc = ($sudah/($belum+$sudah))*100;
                            }                           
                          } else {
                            $belumPerc = ($belum/($belum+$sudah))*100;
                            $sudahPerc = ($sudah/($belum+$sudah))*100;
                          }
                        }?>
                          <br><br>
                          <p>Belum selesai : <?=$belum?></p>
                          <div class="progress">
                              <div class="progress-bar bg-danger" role="progressbar" style="width: <?=$belumPerc?>%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                          <br>
                          <p>Sudah selesai : <?=$sudah?></p>
                          <div class="progress">
                              <div class="progress-bar bg-success" role="progressbar" style="width: <?=$sudahPerc?>%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>
                    </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->


        </div>
    </section>


    
</div>

<?php foreach($tugas as $tg) {?>
<!-- Modal -->
<div class="modal fade" id="modalTugas<?=$tg->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?=$tg->nama_tugas?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3>Deskripsi</h3>
        <p><?=$tg->deskripsi?></p>
        <h3>Apakah sudah selesai?</h3> 
        <p><span><?=$tg->sudah_selesai?></span><span style="float: right;">
          <?php if($tg->sudah_selesai == "Belum") {?>
            <?php echo anchor('Dashboard/sudahtugas/'.$tg->id, '<button type="button" class="btn btn-success">Sudah selesai</button>')?></span>
          <?php } else {?>
            <?php echo anchor('Dashboard/belumtugas/'.$tg->id, '<button type="button" class="btn btn-danger">Belum selesai</button>')?></span>
          <?php }?>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editTugas<?=$tg->id?>">Edit</button>
        <?php echo anchor('Dashboard/hapustugas/'.$tg->id, '<button type="button" class="btn btn-danger">Hapus Tugas</button>');?>
      </div>
    </div>
  </div>
</div>
<?php }?>

<?php foreach($matakuliah as $mk) {?>
<!-- Modal -->
<div class="modal fade" id="modalMK<?=$mk->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Mata Kuliah</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        

      <form action="<?php echo base_url()?>Dashboard/editmatkul" method="post">
        <div class="form-group">
          <label for="exampleInputEmail1">Nama Mata Kuliah</label>
          <input type="hidden" name="matakuliahold" value="<?=$mk->mata_kuliah?>" class="form-control" id="whatever2" aria-describedby="emailHelp">
          <input type="text" name="matakuliahnew" value="<?=$mk->mata_kuliah?>" class="form-control" id="whatever" aria-describedby="emailHelp" placeholder="Masukkan Nama Mata Kuliah Baru">
        </div>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
        <?php echo anchor('Dashboard/hapusmatkul/'.$mk->mata_kuliah, '<button type="button" class="btn btn-danger">Hapus Mata Kuliah</button>');?>
      </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<?php }?>

<?php foreach($tugas as $tg) {?>
  <div class="modal fade" id="editTugas<?php echo $tg->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Tugas</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">

          <form action="<?php echo base_url()?>Dashboard/edit_tugas" method="POST">
          <div class="form-group">
            <label for="exampleFormControlInput1">Nama Tugas</label>
            <input value="<?=$tg->id?>" name="id" type="hidden" class="form-control" id="exampleFormControlInput1">
            <input value="<?=$tg->nama_tugas?>" name="namatugas" type="text" class="form-control" id="exampleFormControlInput1">
          </div>
          <div class="form-group">
            <label for="exampleFormControlSelect1">Mata Kuliah</label>
            <select name="matakuliah" class="form-control" id="exampleFormControlSelect1">
              <?php foreach($matakuliah as $mk) {?>
                <option <?php if($tg->mata_kuliah == $mk->mata_kuliah) {echo "selected";}?>><?php echo $mk->mata_kuliah?></option>
              <?php }?>
            </select>
          </div>
          <div class="form-group">
            <label for="exampleFormControlTextarea1">Deskripsi Tugas</label>
            <textarea name="deskripsi" class="form-control" id="exampleFormControlTextarea1" rows="3"><?=$tg->deskripsi?></textarea>
          </div>
          <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>     
    </div>
  </div>
  </div>
  <?php }?>