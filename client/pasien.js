
function getDataPasien(){
    $('.detailPasien').remove();
    $.ajax({
    url: url+"pasien",
    type: "GET",
    beforeSend: function (xhr) {
        xhr.setRequestHeader('Authorization', token);
    },
    data: null,
    success:function(response){
        var data= response.data;
        var detail = document.getElementById("detail");
        $("#loader").hide();
        $.each(data, function(i,pasien){
            data ='<div class="card mb-3" style="max-width: auto;"><div class="card-header detailPasien" id="'+pasien.id+'">'+pasien.fullnm+'</div></div>';
            $(data).appendTo('#detail');
        });
        $('.detailPasien').click(function(){
        $('.body').load('add_data.php');
        var id = $(this).attr('id');
        getDataDetail(id);
        });
    },
    error:function(jqXHR, textStatus, errorThrown){
        console.log(textStatus, errorThrown);
    }
    });	
}

function getDataDetail(id){
    $.ajax({
        url: url+"pasien",
        type: "GET",
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', token);
        },
        data: {id:id},
        success:function(response){
            var pasien = response.data;
            $('#idpasien').val(pasien.id);
            $('#tglperiksa').val(pasien.tglperiksa);
            $('#kdpasien').val(pasien.kdpasien);
            $('#nmpasien').val(pasien.fullnm);
            $('#umpasien').val(pasien.umur);
            $('#brtpasien').val(pasien.berat_badan);
            $('#noppasien').val(pasien.nop);
            $('#ctdipasien').val(pasien.ctdi);
            $('#dlppasien').val(pasien.dlp);

        },
        error:function(jqXHR, textStatus, errorThrown){
            console.log(textStatus, errorThrown);
        }
    });	
}

function searchData(){
    $('.body').load('all_data.php');
    $.ajax({
        url: url+"pasien",
        type: "GET",
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', token);
        },
        data: {method:'searchPasien',search:search.value},
        success:function(response){
            var data = response.data;
            var detail = document.getElementById("detail");
            $.each(data, function(i,pasien){
                data ='<div class="card mb-3" style="max-width: auto;"><div class="card-header detailPasien" id="'+pasien.id+'">'+pasien.fullnm+'</div></div>';
                $(data).appendTo('#detail');
            });

            $('.detailPasien').click(function(){
            $('.body').load('add_data.php');
            var id = $(this).attr('id');
            getDataDetail(id);
            });
        },
        error:function(jqXHR, textStatus, errorThrown){
            console.log(textStatus, errorThrown);
        }
    });	
}

date = new Date();
  tglNow = date.getFullYear() + '-' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '-' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate()));

  function save() {
    var tgl = tglperiksa.value;
    var kode = kdpasien.value;
    var nama = nmpasien.value;
    var umur = umpasien.value;
    var beratBadan = brtpasien.value;
    var nop = noppasien.value;
    var ctdi = ctdipasien.value;
    var dlp = dlppasien.value;

    if (!nama) {
      Swal.fire(
        'Pesan',
        'Nama Pasien Wajib Diisi',
        'warning'
      )
      return false;
    } else if (!umur) {
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
      type: "POST",
      beforeSend: function(xhr) {
        xhr.setRequestHeader('Authorization', token);
      },
      data: {
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

  function editPasien() {
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