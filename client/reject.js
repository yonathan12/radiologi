
function getDataReject(){
    $('.detailReject').remove();
    $.ajax({
    url: url+"reject",
    type: "GET",
    beforeSend: function (xhr) {
        xhr.setRequestHeader('Authorization', token);
    },
    data: null,
    success:function(response){
        var data= response.data;
        var detail = document.getElementById("detail");
        $("#loader").hide();
        $.each(data, function(i,reject){
            data ='<div class="card mb-3" style="max-width: auto;"><div class="card-header detailReject" id="'+reject.id+'">'+reject.norm+'</div></div>';
            $(data).appendTo('#detail');
        });
        $('.detailReject').click(function(){
        $('.body').load('add_data_reject.php');
        var id = $(this).attr('id');
        getList();
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
        url: url+"reject",
        type: "GET",
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', token);
        },
        data: {id:id},
        success:function(response){
            var pasien = response.data;
            $('#idreject').val(pasien.id);
            $('#tglperiksa').val(pasien.tglperiksa);
            $('#ukuran_film').val(pasien.ukuranfilm);
            $('#norm').val(pasien.norm);
            $('#nmpasien').val(pasien.fullnm);
            $('#nofoto').val(pasien.nofoto);
            $('#jnsperiksa').val(pasien.jenisperiksa);
            $('#alasan').val(pasien.alasan);

        },
        error:function(jqXHR, textStatus, errorThrown){
            console.log(textStatus, errorThrown);
        }
    });	
}

function searchData(){
    $('.body').load('all_data_reject.php');
    $.ajax({
        url: url+"reject",
        type: "GET",
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', token);
        },
        data: {method:'searchPasien',search:search.value},
        success:function(response){
            var data = response.data;
            var detail = document.getElementById("detail");
            $.each(data, function(i,pasien){
                data ='<div class="card mb-3" style="max-width: auto;"><div class="card-header detailReject" id="'+pasien.id+'">'+pasien.norm+'</div></div>';
                $(data).appendTo('#detail');
            });

            $('.detailReject').click(function(){
            $('.body').load('add_data.php');
            var id = $(this).attr('id');
            getList();
            getDataDetail(id);
            });
        },
        error:function(jqXHR, textStatus, errorThrown){
            console.log(textStatus, errorThrown);
        }
    });	
}

function getList(){
  $.ajax({
    url: url+"reject",
    type: "GET",
    beforeSend: function (xhr) {
        xhr.setRequestHeader('Authorization', token);
    },
    data: {method :'getList'},
    success:function(response){
        var data= response.data;
        $.each(data, function( key, row ) {
          $('#ukuran_film').append('<option value="'+row.id+'">'+row.ukuranfilm+'</option>');
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
      url: url + "reject",
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

  function editReject() {
    var id = idreject.value;
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
      url: url + "reject",
      type: "PUT",
      beforeSend: function(xhr) {
        xhr.setRequestHeader('Authorization', token);
      },
      data: {
        id:id,
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
            'Data Berhasil Diubah',
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