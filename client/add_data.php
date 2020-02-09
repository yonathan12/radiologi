<div class="container-fluid">
  <form id="form">
    <input type="text" class="form-control" id="idpasien" hidden>
    <div class="form-group row">
      <label for="staticEmail" class="col-sm-2 col-form-label">Tanggal Pemeriksaan</label>
      <div class="col-sm-10">
        <input type="date" class="form-control" id="tglperiksa">
      </div>
    </div>
    <div class="form-group row">
      <label for="staticEmail" class="col-sm-2 col-form-label">Kode Pasien</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="kdpasien" placeholder="Kode Pasien Jika Ada">
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Nama Pasien</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="nmpasien" placeholder="Nama Pasien Jika Ada">
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Umur Pasien *</label>
      <div class="col-sm-10">
        <input type="number" class="form-control" id="umpasien" placeholder="Umur (th)" require>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Berat Badan Pasien *</label>
      <div class="col-sm-10">
        <input type="number" class="form-control" id="brtpasien" placeholder="Berat Badan (kg)" require>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">No of Phase * [0/1/2/3/>=4]</label>
      <div class="col-sm-10">
        <input type="number" class="form-control" id="noppasien" placeholder="No of Phase" require>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Averange CTDI *</label>
      <div class="col-sm-10">
        <input type="number" class="form-control" id="ctdipasien" placeholder="(mGy)" require>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Total DLP *</label>
      <div class="col-sm-10">
        <input type="number" class="form-control" id="dlppasien" placeholder="(mGy cm)" require>
      </div>
    </div>
  </form>
  <a class="btn btn-success active" onclick="idpasien.value?editPasien():save()" id="simpan">Simpan</a>
  <a class="btn btn-danger active" onclick="reset();" id="batal">Batal</a>
</div>
<script type="text/javascript" src="pasien.js"></script>