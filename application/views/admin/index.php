<div class="card">
<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message');?>"> </div>
      <?php $this->session->flashdata('message')?$this->session->flashdata('message'):''?>
  <div class="card-header">
  <form class="form-inline" action="admin/export" method="POST">
    <div class="form-group">
      <label for="date">Tanggal Awal &nbsp;</label>
      <input type="date" class="form-control" name="tgl1">
    </div>
    <div class="form-group">
      <label for="date">&nbsp; Tanggal Akhir &nbsp;</label>
      <input type="date" class="form-control" name="tgl2" >
    </div>
    <div> <label for="date">&nbsp;</label></div>
    <button type="submit" class="btn btn-primary">Export Data</button>
    &nbsp;
    <button type="reset" class="btn btn-danger">Reset</button>
  </form>

    <!-- <a href="admin/export" class="btn btn-primary mb-3">Export Data</a> -->
  </div>
  <div class="card-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Kode Pasien</th>
          <th>Nama Pasien</th>
          <th>Umur Pasien</th>
          <th>Berat Badan</th>
          <th>NOP</th>
          <th>CTDI</th>
          <th>DLP</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
      <?php 
        $no = 1;
        foreach($data as $value){
      ?>
      <tr>
        <td><?php echo $no++;?></td>
        <td><?php echo $value['kdpasien']; ?></td>
        <td><?php echo $value['fullnm']; ?></td>
        <td><?php echo $value['umur'];?></td>
        <td><?php echo $value['berat_badan'];?></td>
        <td><?php echo $value['nop'];?></td>
        <td><?php echo $value['ctdi'];?></td>
        <td><?php echo $value['dlp'];?></td>
        <td style="text-align: center;">
        <!-- <a href="#" data-toggle="modal" data-target="#detailUser<?= $value['Id']; ?>" class="glyphicon glyphicon-pencil btn btn-sm btn-success" ></a> -->
        <!-- <a href="#" data-toggle="modal" data-target="#editUser<?= $value['Id']; ?>" class="glyphicon glyphicon-pencil btn btn-sm btn-primary" >Ubah</a> -->
        <a href="<?= base_url('admin/hapusData/'.$value['Id']); ?>" class="btn btn-sm btn-danger glyphicon glyphicon-trash hapusData">Hapus</a>
        </td>
      </tr>
      <?php }?>
      </tbody>
    </table>
  </div>
</div>
<script>
  $('.hapusData').on('click',function(e){
      e.preventDefault();
      var href = $(this).attr('href');
      Swal.fire({
        title: 'Pesan',
        text: "Data Akan Di Hapus ?",
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