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
      <label for="staticEmail" class="col-sm-2 col-form-label">Ukuran Film</label>
      <div class="col-sm-10">
        <select class="form-control" id="ukuran_film" name="ukuran_film">
            <option value="">Pilih</option>
            <option value="1">Ukuran Satu</option>
            <option value="2">Ukuran Dua</option>
            <option value="3">Ukuran Tiga</option>
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
  <a class="btn btn-success active" onclick="idpasien.value?edit():save()" id="simpan">Simpan</a>
  <a class="btn btn-danger active" onclick="reset();" id="batal">Batal</a>
</div>
<script>
  date = new Date();
  tglNow = date.getFullYear() + '-' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '-' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate()));

  function save() {
    var tgl = tglperiksa.value;
    var no_rm = norm.value;
    var nama = nmpasien.value;
    var ukuran = ukuran_film.value;
    var no_foto = nofoto.value;
    var jenisPeriksa = jnsperiksa.value;
    var alasanReject = alasan.value;
    
    if (tgl > tglNow) {
      Swal.fire(
        'Pesan',
        'Tidak Boleh Melebihi Tanggal Hari Ini',
        'warning'
      )
      return false;
    }else if (!ukuran) {
      Swal.fire(
        'Pesan',
        'Ukuran Film Wajib Diisi',
        'warning'
      )
      return false;
    }else if (!no_rm) {
      Swal.fire(
        'Pesan',
        'Nama Pasien Wajib Diisi',
        'warning'
      )
      return false;
    }else if (!nama) {
      Swal.fire(
        'Pesan',
        'Nama Pasien Wajib Diisi',
        'warning'
      )
      return false;
    }else if(!no_foto){
        Swal.fire(
        'Pesan',
        'Nomor Foto Wajib Diisi',
        'warning'
      )
      return false;
    }else if(!jenisPeriksa){
        Swal.fire(
        'Pesan',
        'Jenis Pemeriksaan Wajib Diisi',
        'warning'
      )
      return false;
    }else if(!alasanReject){
        Swal.fire(
        'Pesan',
        'Alasan Wajib Diisi',
        'warning'
      )
      return false;
    }
    $("#loader").show();
    $("#simpan").hide();
    $("#batal").hide();
    $.ajax({
      url: url + "pasien",
      type: "POST",
      beforeSend: function(xhr) {
        xhr.setRequestHeader('Authorization', token);
      },
      data: {
        tanggal: tgl,
        no_rm: no_rm,
        nama: nama,
        ukuran: ukuran,
        no_foto: no_foto,
        jenisPeriksa: jenisPeriksa,
        alasanReject: alasanReject
      },
      success: function(response) {
        const data = response;
        if (data.status === true) {
          Swal.fire(
            'Pesan',
            'Data Berhasil Ditambahkan',
            'success'
          )
          reset();
          $("#loader").hide();
          $("#simpan").show();
          $("#batal").show();
        } else {
          Swal.fire(
            'Pesan',
            data.data,
            'warning'
          )
          return false;
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
      }
    });
  }

  function edit() {
    var id = idpasien.value;
    var tgl = tglperiksa.value;
    var kode = kdpasien.value;
    var nama = nmpasien.value;
    var umur = umpasien.value;
    var beratBadan = brtpasien.value;
    var nop = noppasien.value;
    var ctdi = ctdipasien.value;
    var dlp = dlppasien.value;

    if (!umur) {
      Swal.fire(
        'Pesan',
        'Umur Pasien Wajib Diisi',
        'warning'
      )
      return false;
    } else if (!beratBadan) {
      Swal.fire(
        'Pesan',
        'Berat Badan Pasien Wajib Diisi',
        'warning'
      )
      return false;
    }
    if (!nop) {
      Swal.fire(
        'Pesan',
        'No of Phase Wajib Diisi',
        'warning'
      )
      return false;
    }
    if (!ctdi) {
      Swal.fire(
        'Pesan',
        'Avarange CTDI Wajib Diisi',
        'warning'
      )
      return false;
    }
    if (!dlp) {
      Swal.fire(
        'Pesan',
        'Total DLP Wajib Diisi',
        'warning'
      )
      return false;
    } else if (tgl > tglNow) {
      Swal.fire(
        'Pesan',
        'Tidak Boleh Melebihi Tanggal Hari Ini',
        'warning'
      )
      return false;
    }
    $("#loader").show();
    $("#simpan").hide();
    $("#batal").hide();
    $.ajax({
      url: url + "pasien",
      type: "PUT",
      beforeSend: function(xhr) {
        xhr.setRequestHeader('Authorization', token);
      },
      data: {
        id: id,
        tanggal: tgl,
        kdpasien: kode,
        nama: nama,
        umur: umur,
        beratBadan: beratBadan,
        nop: nop,
        ctdi: ctdi,
        dlp: dlp
      },
      success: function(response) {
        const data = response;
        if (data.status === true) {
          Swal.fire(
            'Pesan',
            data.data,
            'success'
          )
          reset();
          $("#loader").hide();
          $("#simpan").show();
          $("#batal").show();
        } else {
          Swal.fire(
            'Pesan',
            data.data,
            'warning'
          )
          return false;
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
      }
    });
  }

  function reset() {
    $('#form').trigger("reset");
  }
</script>