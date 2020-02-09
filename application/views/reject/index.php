<div class="card">
<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message');?>"> </div>
      <?php $this->session->flashdata('message')?$this->session->flashdata('message'):''?>
  <div class="card-header">
  <form class="form-inline" action="reject/export" method="POST">
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
          <th>Tanggal Periksa</th>
          <th>Ukuran Film</th>
          <th>No RM</th>
          <th>Nama Pasien</th>
          <th>No Foto</th>
          <th>Jenis Periksa</th>
          <th>Alasan</th>
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
        <td><?php echo $value['tglperiksa']; ?></td>
        <td><?php echo $value['ukuranfilm']; ?></td>
        <td><?php echo $value['norm']; ?></td>
        <td><?php echo $value['fullnm'];?></td>
        <td><?php echo $value['no_foto'];?></td>
        <td><?php echo $value['jenisperiksa'];?></td>
        <td><?php echo $value['alasan'];?></td>
        <td style="text-align: center;">
        <a href="<?= base_url('reject/hapusData/'.$value['Id']); ?>" class="btn btn-sm btn-danger glyphicon glyphicon-trash hapusData">Hapus</a>
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