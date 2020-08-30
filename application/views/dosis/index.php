<div class="card">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"> </div>
    <?php $this->session->flashdata('message') ? $this->session->flashdata('message') : '' ?>
    <div class="card-header">
        <form class="form-inline" action="dosis/export" method="POST">
            <div class="form-group">
                <label for="date">Tanggal Awal &nbsp;</label>
                <input type="date" class="form-control" name="tgl1">
            </div>
            <div class="form-group">
                <label for="date">&nbsp; Tanggal Akhir &nbsp;</label>
                <input type="date" class="form-control" name="tgl2">
            </div>
            <div class="form-group">
                <label for="device">&nbsp; Alat &nbsp;</label>
                <select name="device" class="form-control" id="role" required>
                    <option value="">Pilih Alat</option>
                    <?php foreach ($device as $key => $value) : ?>
                        <option value="<?= $value['id'] ?>"><?= $value['descr'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div> <label for="date">&nbsp;</label></div>
            <button type="submit" class="btn btn-primary">Export Data</button>
            &nbsp;
            <button type="reset" class="btn btn-danger">Reset</button>
        </form>
    </div>
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Periksa</th>
                    <th>Kode Pasien</th>
                    <th>Nama Pasien</th>
                    <th>Umur Pasien</th>
                    <th>Berat Badan</th>
                    <th>NOP</th>
                    <th>CTDI</th>
                    <th>DLP</th>
                    <th>Alat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($data as $value) {
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $value['tglperiksa']; ?></td>
                        <td><?php echo $value['kdpasien']; ?></td>
                        <td><?php echo $value['fullnm']; ?></td>
                        <td><?php echo $value['umur']; ?></td>
                        <td><?php echo $value['berat_badan']; ?></td>
                        <td><?php echo $value['nop']; ?></td>
                        <td><?php echo $value['ctdi']; ?></td>
                        <td><?php echo $value['dlp']; ?></td>
                        <td><?php echo $value['descr']; ?></td>
                        <td style="text-align: center;">
                            <form method="POST" action="dosis/delete" id="form_dosis">
                                <input type="hidden" value="<?= $value['id'] ?>" name="id" />
                                <button type="submit" class="btn btn-sm btn-danger glyphicon glyphicon-trash" id="delete_dosis">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $('#delete_dosis').on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Pesan',
            text: "Data Akan Di Hapus ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.value) {
                $('#form_dosis').submit();
            }
        })
    });
</script>