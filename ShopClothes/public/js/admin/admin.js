$( document ).ready(function() {
  var paginate = $(".paginate");
  paginate.remove("br");
});

$(".deleteTr").on("click", function () {

  var $this = $(this);
  var idTr = $this.attr("id-tr");
  var urlTr = $("#deleteTr").val();
  swal({
    title: "Xóa dòng này?",
    text: "Bạn có chắc muốn xóa dòng này chứ?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {

    if (willDelete) {

      $.ajax({
        url: urlTr,
        method: 'GET',
        dataType: 'json',
        data: { "idTr": idTr },
        success: function (response) {

          if (response.STATUS == "ERROR") {
            swal("Xóa dữ liệu thất bại!", {
              icon: "error",
            });
          } 
          else {
            console.log(response);
            swal("Xóa dữ liệu thành công!", {
              icon: "success",
            });
            $this.closest("tr").remove();
          }
        } 
      });
    }
  });
});

$(".deleteUser").on("click", function () {

  var $this = $(this);
  var idTr = $this.attr("id-tr");
  var urlTr = $("#deleteUser").val();
  swal({
    title: "Xóa tài khoản này?",
    text: "Bạn có chắc muốn xóa tài khoản này không?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {

    if (willDelete) {

      $.ajax({
        url: urlTr,
        method: 'GET',
        dataType: 'json',
        data: { "idTr": idTr },
        success: function (response) {

          if (response.STATUS == "ERROR") {
            swal("Xóa dữ liệu thất bại!", {
              icon: "error",
            });
          } 
          else {
            swal("Xóa dữ liệu thành công!", {
              icon: "success",
            });
            $this.closest("tr").remove();
          }
        } 
      });
    }
  });
});


$(".resetPass").on("click", function () {

  var $this = $(this);
  var idTr = $this.attr("id-tr");
  var urlTr = $("#resetPass").val();
  swal({
    title: "Reset mật khẩu tài khoản này?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willReset) => {

    if (willReset) {

      $.ajax({

        url: urlTr,
        method: 'GET',
        dataType: 'json',
        data: { "idTr": idTr },
        success: function (response) {

          if (response.STATUS == "ERROR") {
              swal("Reset mật khẩu thất bại", {
              icon: "error",
            });
          } 
          else {
              swal("Reset mật khẩu thành công!", {
                icon: "success",
              });
              // swal( response.data, "success", "success" );
          }
        }
        });
    }
  });
});
$('#check_alias').change(function(){
  var check = $(this);
  var alias = $("#constant_alias")
  if(check.is(':checked'))
  {
    console.log(alias.val());
    alias.val("")
    alias.attr('readonly',true);
  }
  else
    alias.removeAttr('readonly');
});

$(document).delegate("#remove_image","click",function(){
  var parent = $(this).parent();
  parent.remove();
});

$(document).on("change","#avatar",function() {
  var files = $(this)[0].files;
  var parent = $(this).parent().parent();
  console.log(parent.attr('id'));
  var url = $(this).attr("url");
  var image_data = new FormData();
  var image_name = [];
  var files_arr = [];
  var url = $(this).attr('url');
  for(var i = 0 ; i< files.length;i++)
  {
    image_data.append("images[]",this.files[i]);
  }
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    async: false,
    type: "POST",
    url:url,
    data:image_data,
    contentType:false,
    cache: false,
    processData:false,
    success:function (msg) {
      files_arr = $.parseJSON(msg)
    },
  });
  for(var i = 0 ; i < files.length; i++)
  {
    image_name.push(files_arr[i]);
    var reader = new FileReader();
    reader.onload = function(index) {
      return function(e){
        var htmlappend = '<div class="col-xs-2 col-sm-2 col-md-2 clear-padding block_preview_images" id="image_preview">';
        htmlappend += '<img name="'+files_arr[index]+'" id="image_preview" width="100%" src="'+e.target.result+'"';
        htmlappend += '</img>';
        htmlappend += '<button id="remove_image" type="button">&#10006</button>';
        htmlappend += '<input id="images_name"  name="images[]"  value="'+files_arr[index]+'" type="hidden">';
        htmlappend += '</div>';
        $("#preview_images").prepend($(htmlappend));
      }
    }(i);
    reader.readAsDataURL(files[i]);
  }
  $(this).val("")
});

$(document).on("change","#avatar_news",function() {
  var old_images = $(document).find("#image_preview")  
  old_images.remove();
  var files = $(this)[0].files;
  var url = $(this).attr("url");
  console.log(url)
  var image_data = new FormData();
  var image_name = [];
  var files_arr = [];
  var url = $(this).attr('url');
  for(var i = 0 ; i< files.length;i++)
  {
    image_data.append("images[]",this.files[i]);
  }
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    async: false,
    type: "POST",
    url:url,
    data:image_data,
    contentType:false,
    cache: false,
    processData:false,
    success:function (msg) {
      files_arr = $.parseJSON(msg)
    },
  });
  for(var i = 0 ; i < files.length; i++)
  {
    image_name.push(files_arr[i]);
    var reader = new FileReader();
    reader.onload = function(index) {
      return function(e){
        var htmlappend = '<div class="col-xs-2 col-sm-2 col-md-2 clear-padding block_preview_images" id="image_preview">';
        htmlappend += '<img name="'+files_arr[index]+'" id="image_preview" width="100%" src="'+e.target.result+'"';
        htmlappend += '</img>';
        htmlappend += '<button id="remove_image" type="button">&#10006</button>';
        htmlappend += '<input id="images_name"  name="images[]"  value="'+files_arr[index]+'" type="hidden">';
        htmlappend += '</div>';
        $("#preview_images").prepend($(htmlappend));
      }
    }(i);
    reader.readAsDataURL(files[i]);
  }
  $(this).val("")
});

$(document).on("change","#avatar_logo",function() {
  var old_images = $(document).find("#logo_preview")  
  old_images.remove();
  var files = $(this)[0].files;
  var url = $(this).attr("url");
  console.log(url)
  var image_data = new FormData();
  var image_name = [];
  var files_arr = [];
  var url = $(this).attr('url');
  for(var i = 0 ; i< files.length;i++)
  {
    image_data.append("images[]",this.files[i]);
  }
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    async: false,
    type: "POST",
    url:url,
    data:image_data,
    contentType:false,
    cache: false,
    processData:false,
    success:function (msg) {
      files_arr = $.parseJSON(msg)
    },
  });
  for(var i = 0 ; i < files.length; i++)
  {
    image_name.push(files_arr[i]);
    var reader = new FileReader();
    reader.onload = function(index) {
      return function(e){
        var htmlappend = '<div class="col-xs-2 col-sm-2 col-md-2 clear-padding block_preview_images" id="logo_preview">';
        htmlappend += '<img name="'+files_arr[index]+'" id="image_preview" width="100%" src="'+e.target.result+'"';
        htmlappend += '</img>';
        htmlappend += '<button id="remove_image" type="button">&#10006</button>';
        htmlappend += '<input id="images_name"  name="enterprise_logo"  value="'+files_arr[index]+'" type="hidden">';
        htmlappend += '</div>';
        $("#enterprise_logo").prepend($(htmlappend));
      }
    }(i);
    reader.readAsDataURL(files[i]);
  }
  $(this).val("")
});

$(document).on("change","#avatar_lincence",function() {
  var files = $(this)[0].files;
  var url = $(this).attr("url");
  console.log(url)
  var image_data = new FormData();
  var image_name = [];
  var files_arr = [];
  var url = $(this).attr('url');
  for(var i = 0 ; i< files.length;i++)
  {
    image_data.append("images[]",this.files[i]);
  }
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    async: false,
    type: "POST",
    url:url,
    data:image_data,
    contentType:false,
    cache: false,
    processData:false,
    success:function (msg) {
      files_arr = $.parseJSON(msg)
    },
  });
  for(var i = 0 ; i < files.length; i++)
  {
    image_name.push(files_arr[i]);
    var reader = new FileReader();
    reader.onload = function(index) {
      return function(e){
        var htmlappend = '<div class="col-xs-2 col-sm-2 col-md-2 clear-padding block_preview_images" id="lincence_preview">';
        htmlappend += '<img name="'+files_arr[index]+'" id="image_preview" width="100%" src="'+e.target.result+'"';
        htmlappend += '</img>';
        htmlappend += '<button id="remove_image" type="button">&#10006</button>';
        htmlappend += '<input id="images_name"  name="enterprise_licence_images[]"  value="'+files_arr[index]+'" type="hidden">';
        htmlappend += '</div>';
        $("#enterprise_licence_images").prepend($(htmlappend));
      }
    }(i);
    reader.readAsDataURL(files[i]);
  }
  $(this).val("")
});


$('#cargo_offer_proposed_price').keyup(function(e) { 
    if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || (e.keyCode == 8))
    {
        var str = $(this).val().replace(/\,/g,'') + '';
        $(this).val(String(str).replace(/(.)(?=(\d{3})+$)/g,'$1,'))
    }
});

$('#cargo_offer_proposed_price').keydown(function(e){
    if ((e.keyCode != 9) && (e.keyCode != 8) && (e.keyCode != 116) && ((e.shiftKey || (e.keyCode < 48  || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105 ))) {
        e.preventDefault();
    }
})