<div class="container-fluid">
  <form id="form">
    <input type="text" class="form-control" id="idreject" hidden>
    <div class="form-group row">
      <label for="staticEmail" class="col-sm-2 col-form-label">Tanggal Pemeriksaan</label>
      <div class="col-sm-10">
        <input type="date" class="form-control" id="tglperiksa">
      </div>
    </div>
    <div class="form-group row">
      <label for="staticEmail" class="col-sm-2 col-form-label">Ukuran Film</label>
      <div class="col-sm-10">
        <select class="form-control" id="ukuran_film" name="ukuran_film">
            <option value="">Pilih</option>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label for="staticEmail" class="col-sm-2 col-form-label">NO RM</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="norm" placeholder="NO RM">
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Nama Pasien</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="nmpasien" placeholder="Nama Pasien Jika Ada">
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">No Foto</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="nofoto" placeholder="No Foto" require>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Jenis Pemeriksaan</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="jnsperiksa" placeholder="Jenis Pemeriksaan" require>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Alasan Reject</label>
      <div class="col-sm-10">
          <textarea name="alasan" class="form-control" id="alasan" cols="30" rows="10"></textarea>
      </div>
    </div>
  </form>
  <a class="btn btn-success active" onclick="idreject.value?editReject():save()" id="simpan">Simpan</a>
  <a class="btn btn-danger active" onclick="reset();" id="batal">Batal</a>
</div>
<script type="text/javascript" src="reject.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    getList();
  });
</script>