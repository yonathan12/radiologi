<div class="card">
<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message');?>"> </div>
      <?php $this->session->flashdata('message')?$this->session->flashdata('message'):''?>
  <div class="card-header">
    <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahUser">Tambah User</a>
  </div>
  <div class="card-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Username</th>
          <th>Admin</th>
          <th>Status</th>
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
        <td><?php echo $usr['fullnm']; ?></td>
        <td><?php echo $usr['username'];?></td>
        <td>
        <?php
          if ($usr['admin'] == "Y") {
            echo 'Admin';
          }else {
            echo 'Staff';
          }
        ?>
        </td>
        <td>
        <?php
          if ($usr['status'] == 1) {
            echo "Aktif";
          } else {
            echo "Tidak Aktif";
          }
        ?>
        </td>
        <td style="text-align: center;">
        <a href="#" data-toggle="modal" data-target="#editUser<?= $usr['id']; ?>" class="btn btn-sm btn-primary" >Ubah</a>
        <a href="<?= base_url('user/delete/'.$usr['id']); ?>" class="btn btn-sm btn-danger hapusUser" >Hapus</a>
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
        <h5 class="modal-title" id="tambahUserLabel">Tambah User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url();?>user/create" method="POST">
      <div class="modal-body">
      <input type="text" class="form-control" id="name" name="fullnm" placeholder="Nama">
      <input type="text" hidden name="user_id" value="<?= $this->session->userdata('id'); ?>">
      </div>
      <div class="modal-body">
      <input type="text" class="form-control" id="username" name="username" placeholder="Username" required oninvalid="this.setCustomValidity('Username Wajib Diisi')">
      </div>
      <div class="modal-body">
      <input type="password" class="form-control" id="password" name="password" placeholder="Password" required oninvalid="this.setCustomValidity('Password Wajib Diisi')">
      </div>
      <div class="modal-body">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="exampleCheck1" name="admin">
          <label class="form-check-label" for="exampleCheck1">Admin ?</label>
        </div>
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
    $id = $user['id'];
    $fullnm = $user['fullnm'];
    $username = $user['username'];
    $admin = $user['admin'];
    $status = $user['status'];
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
      <form action="<?= base_url('user/update');?>" method="POST">
      <div class="modal-body">
        <input type="text" class="form-control" id="nameEdit<?= $id; ?>" name="fullnm" placeholder="Nama" value="<?= $fullnm; ?>">
        <input type="text" hidden="" name="id" value="<?= $id; ?>">
        <input type="text" hidden name="user_id" value="<?= $this->session->userdata('id'); ?>">
      </div>
      <div class="modal-body">
        <input type="text" class="form-control" id="usernameEdit<?= $id; ?>" name="username" placeholder="Email" value="<?= $username; ?>" required oninvalid="this.setCustomValidity('Username Wajib Diisi')">
      </div>
      <div class="modal-body">
        <input type="text" class="form-control" id="passwordEdit<?= $id; ?>" name="password" placeholder="Password">
      </div>
      <div class="modal-body">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" name="admin" 
          <?= $admin=="Y"?'checked':''; ?>>
          <label class="form-check-label" for="exampleCheck1">Admin ?</label>
        </div>
      </div>
      <div class="modal-body">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" name="status" 
          <?= $status=="1"?'checked':''; ?>>
          <label class="form-check-label" for="exampleCheck1">Aktif ?</label>
        </div>
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
        text: "User Akan Di Hapus ?",
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