<div class="container-fluid">
<form id="form">
<input type="text" class="form-control" id="idpasien" hidden>
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
    <a class="btn btn-success active" onclick="idpasien.value?edit():save()">Simpan</a>
    <a class="btn btn-danger active" onclick="reset();">Batal</a>
</div>
<script>
    function save(){
        var kode = kdpasien.value;
        var nama = nmpasien.value;
        var umur = umpasien.value;
        var beratBadan = brtpasien.value;
        var nop = noppasien.value;
        var ctdi = ctdipasien.value;
        var dlp = dlppasien.value;

        if(!nama){
          Swal.fire(
                  'Pesan',
                  'Nama Pasien Wajib Diisi',
                  'warning'
                )
            return false;
        }else if(!umur){
            Swal.fire(
                  'Pesan',
                  'Umur Pasien Wajib Diisi',
                  'warning'
                )
            return false;
        }else if(!beratBadan){
            Swal.fire(
                  'Pesan',
                  'Berat Badan Pasien Wajib Diisi',
                  'warning'
                )
            return false;
        }if(!nop){
            Swal.fire(
                  'Pesan',
                  'No of Phase Wajib Diisi',
                  'warning'
                )
            return false;
        }if(!ctdi){
            Swal.fire(
                  'Pesan',
                  'Avarange CTDI Wajib Diisi',
                  'warning'
                )
            return false;
        }if(!dlp){
            Swal.fire(
                  'Pesan',
                  'Total DLP Wajib Diisi',
                  'warning'
                )
            return false;
        }

        $.ajax({
              url: url+"pasien",
              type: "POST",
              beforeSend: function (xhr) {
                  xhr.setRequestHeader('Authorization', token);
              },
              data: {
                kdpasien:kode,
                nama:nama,
                umur:umur,
                beratBadan : beratBadan,
                nop:nop,
                ctdi:ctdi,
                dlp:dlp
              },
              success:function(response){
                const data = response;
                if(data.status === true){
                    Swal.fire(
                    'Pesan',
                    'Data Berhasil Ditambahkan',
                    'success'
                  )
                  reset();
                }else{
                  Swal.fire(
                  'Pesan',
                  data.data,
                  'warning'
                )
                return false;
                }
              },
              error:function(jqXHR, textStatus, errorThrown){
                console.log(textStatus, errorThrown);
              }
            });
    }

    function edit(){
        var id = idpasien.value;
        var kode = kdpasien.value;
        var nama = nmpasien.value;
        var umur = umpasien.value;
        var beratBadan = brtpasien.value;
        var nop = noppasien.value;
        var ctdi = ctdipasien.value;
        var dlp = dlppasien.value;

        if(!umur){
            Swal.fire(
                  'Pesan',
                  'Umur Pasien Wajib Diisi',
                  'warning'
                )
            return false;
        }else if(!beratBadan){
            Swal.fire(
                  'Pesan',
                  'Berat Badan Pasien Wajib Diisi',
                  'warning'
                )
            return false;
        }if(!nop){
            Swal.fire(
                  'Pesan',
                  'No of Phase Wajib Diisi',
                  'warning'
                )
            return false;
        }if(!ctdi){
            Swal.fire(
                  'Pesan',
                  'Avarange CTDI Wajib Diisi',
                  'warning'
                )
            return false;
        }if(!dlp){
            Swal.fire(
                  'Pesan',
                  'Total DLP Wajib Diisi',
                  'warning'
                )
            return false;
        }

        $.ajax({
              url: url+"pasien",
              type: "PUT",
              beforeSend: function (xhr) {
                  xhr.setRequestHeader('Authorization', token);
              },
              data: {
                id:id,
                kdpasien:kode,
                nama:nama,
                umur:umur,
                beratBadan : beratBadan,
                nop:nop,
                ctdi:ctdi,
                dlp:dlp
              },
              success:function(response){
                const data = response;
                if(data.status === true){
                    Swal.fire(
                    'Pesan',
                    data.data,
                    'success'
                  )
                  reset();
                }else{
                  Swal.fire(
                  'Pesan',
                  data.data,
                  'warning'
                )
                return false;
                }
              },
              error:function(jqXHR, textStatus, errorThrown){
                console.log(textStatus, errorThrown);
              }
            });
    }

    function reset(){
        $('#form').trigger("reset");
    }
</script>