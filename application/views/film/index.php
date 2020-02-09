<div class="card">
<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message');?>"> </div>
      <?php $this->session->flashdata('message')?$this->session->flashdata('message'):''?>
  <div class="card-header">
    <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahUser">Tambah Ukuran Film</a>
  </div>
  <div class="card-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Ukuran Film</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
      <?php 
        $no = 1;
        foreach($user as $usr){
      ?>
      <tr>
        <td><?php echo $no++;?></td>
        <td><?php echo $usr['ukuranfilm']; ?></td>
        <td style="text-align: center;">
        <!-- <a href="#" data-toggle="modal" data-target="#detailUser<?= $usr['Id']; ?>" class="glyphicon glyphicon-pencil btn btn-sm btn-success" ></a> -->
        <a href="#" data-toggle="modal" data-target="#editUser<?= $usr['Id']; ?>" class="btn btn-sm btn-primary" >Ubah</a>
        <a href="<?= base_url('parameterfilm/hapusFilm/'.$usr['Id']); ?>" class="btn btn-sm btn-danger hapusUser" >Hapus</a>
        </td>
      </tr>
      <?php }?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="tambahUser" tabindex="-1" role="dialog" aria-labelledby="tambahUserLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahUserLabel">Tambah Ukuran Film</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url();?>parameterfilm/tambahFilm" method="POST">
      <div class="modal-body">
      <input type="text" class="form-control" id="name" name="ukuran" placeholder="Ukuran Film" required oninvalid="this.setCustomValidity('Ukuran Wajib Diisi')">
        <input type="text" hidden name="user_id" value="<?= $this->session->userdata('id'); ?>">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit User -->
<?php
    foreach($user as $key => $user):
    $id = $user['Id'];
    $ukuran = $user['ukuranfilm'];
?>
<div class="modal fade" id="editUser<?= $id; ?>" tabindex="-1" role="dialog" aria-labelledby="editUserLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUserLabel">Edit User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('parameterfilm/editFilm');?>" method="POST">
      <div class="modal-body">
        <input type="text" class="form-control" id="nameEdit<?= $id; ?>" name="ukuran" placeholder="Nama" value="<?= $ukuran; ?>" required oninvalid="this.setCustomValidity('Ukuran Wajib Diisi')">
        <input type="text" hidden="" name="id" value="<?= $id; ?>">
        <input type="text" hidden name="user_id" value="<?= $this->session->userdata('id'); ?>">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php endforeach;?>
<script>
  $('.hapusUser').on('click',function(e){
      e.preventDefault();
      var href = $(this).attr('href');
      Swal.fire({
        title: 'Pesan',
        text: "Ukuran Film Akan Di Hapus ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText : 'Tidak'
      }).then((result) => {
        if (result.value) {
          document.location.href = href;
        }
      })
  });
</script>