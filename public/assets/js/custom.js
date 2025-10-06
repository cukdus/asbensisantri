function setAjaxData(object = null) {
  var data = {};
  data[BaseConfig.csrfTokenName] = $('meta[name="X-CSRF-TOKEN"]').attr('content');
  if (object != null) {
    Object.assign(data, object);
  }
  return data;
}

function setSerializedData(serializedData) {
  serializedData.push({ name: BaseConfig.csrfTokenName, value: $('meta[name="X-CSRF-TOKEN"]').attr('content') });
  return serializedData;
}

//delete item
function deleteItem(url, id, message) {
  swal({
    text: message,
    icon: "warning",
    buttons: [BaseConfig.textCancel, BaseConfig.textOk],
    dangerMode: true,
  }).then(function (willDelete) {
    if (willDelete) {
      var data = {
        'id': id,
      };
      $.ajax({
        type: 'POST',
        url: BaseConfig.baseURL + url,
        data: setAjaxData(data),
        success: function (response) {
          location.reload();
        },
        error: function (xhr, status, thrown) {
          console.log(xhr);
          console.log(status);
          console.log(thrown);
        },
      });
    }
  });
};

function fetchKelasJurusanData(type, target) {
  const url = type === 'kelas' ? BaseConfig.baseURL + 'admin/kelas/list-data' : BaseConfig.baseURL + 'admin/jurusan/list-data';
  const textProcessing = type === 'kelas' ? 'Daftar kelas muncul disini' : 'Daftar Jurusan muncul disini';

  $(target).html('<div id="loadingSpinner" class="spinner"></div><p class="text-center mt-3">' + textProcessing + '</p>');

  $.ajax({
    url: url,
    type: 'post',
    data: setAjaxData({}),
    success: function (response) {
      const obj = JSON.parse(response);
      if (obj.result === 1) {
        $(target).html(obj.htmlContent);
      } else {
        $(target).html('<p class="text-center mt-3">Data tidak ditemukan</p>');
      }
    },
    error: function (xhr, status, thrown) {
      $(target).html('<p class="text-center mt-3">' + thrown + '</p>');
    },
    complete: function () {
      $('#loadingSpinner').hide();
    }
  });
}

//delete selected posts
function deleteSelectedSiswa(message) {
  swal({
      text: message,
      icon: "warning",
      buttons: [BaseConfig.textCancel, BaseConfig.textOk],
      dangerMode: true,
  }).then(function (willDelete) {
      if (willDelete) {
          var siswaIds = [];
          $("input[name='checkbox-table']:checked").each(function () {
              siswaIds.push(this.value);
          });
          var data = {
              'siswa_ids': siswaIds,
          };
          $.ajax({
              type: 'POST',
              url: BaseConfig.baseURL + '/admin/siswa/deleteSelectedSiswa',
              data: setAjaxData(data),
              success: function (response) {
                  location.reload();
              }
          });
      }
  });
};

//graduate selected students
function graduateSelectedSiswa(message) {
  swal({
      text: message,
      icon: "warning",
      buttons: [BaseConfig.textCancel, BaseConfig.textOk],
      dangerMode: false,
  }).then(function (willGraduate) {
      if (willGraduate) {
          var siswaIds = [];
          $("input[name='checkbox-table']:checked").each(function () {
              siswaIds.push(this.value);
          });
          
          if (siswaIds.length === 0) {
              swal({
                  text: "Pilih siswa yang akan diluluskan terlebih dahulu",
                  icon: "warning",
                  button: "OK"
              });
              return;
          }
          
          var data = {
              'siswa_ids': siswaIds,
          };
          $.ajax({
              type: 'POST',
              url: BaseConfig.baseURL + '/admin/siswa/graduateSelectedSiswa',
              data: setAjaxData(data),
              success: function (response) {
                  var result = JSON.parse(response);
                  if (result.success) {
                      swal({
                          text: result.message,
                          icon: "success",
                          button: "OK"
                      }).then(function() {
                          location.reload();
                      });
                  } else {
                      swal({
                          text: result.message,
                          icon: "error",
                          button: "OK"
                      });
                  }
              },
              error: function() {
                  swal({
                      text: "Terjadi kesalahan saat meluluskan siswa",
                      icon: "error",
                      button: "OK"
                  });
              }
          });
      }
  });
};

$(document).on('click', '#checkAll', function () {
  $('input:checkbox').not(this).prop('checked', this.checked);
});

$(document).on('click', '.checkbox-table', function () {
  if ($(".checkbox-table").is(':checked')) {
    $(".btn-table-delete").show();
    $(".btn-table-graduate").show();
  } else {
    $(".btn-table-delete").hide();
    $(".btn-table-graduate").hide();
  }
});

