
function getData(){
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
        // $.each(data, function(i,pasien){
        // data ='<p class="list-group-item detailPasien" id="'+pasien.id+'">'+pasien.fullnm+' - '+pasien.umur+' </p>';
        // $(data).appendTo('#detail');
        // });

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
    $('.detailPasien').remove();
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
            data ='<p class="list-group-item detailPasien" id="'+pasien.id+'">'+pasien.fullnm+' - '+pasien.umur+' </p>';
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