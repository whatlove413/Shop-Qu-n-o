/* Toggle between adding and removing the "responsive" class to topnav when the user clicks on the icon */
$( document ).ready(function() {
    $(".category_checkbox").each(function(){
        if($(this).is(":checked"))
        {   
            $(this).parent().css({
                'box-shadow': '0 0 20px 0 rgba(0,0,0,0.3)',
                'background-color': '#ffdab1',
            });
            $(this).next().css('display', 'none');
            $(this).prev().css('display', 'block');
        }
        else
        {
            $(this).parent().css({
                'box-shadow': 'none',
                'background-color': '#fff',
            });
            $(this).prev().css('display', 'none');
            $(this).next().css('display', 'block');
        }
    })
});
//bar active blade
$( document ).ready(function() {
    $('.progress-bar').addClass('progress_full');
});
/*$( document ).ready(function() {
  var paginate = $(".paginate br");
  paginate.remove("br");
});*/

//go to exchange in list new in user
$('#cargoOffer').click(function(event) {
    event.preventDefault();
    var list_news_position = $('#list_news_head').offset().top;
    $('html').animate({scrollTop: list_news_position},400);
});
$('#vehicleOpen').click(function(event) {
    event.preventDefault();
    var list_news_position = $('#vehicleOpen_head').offset().top;
    $('html').animate({scrollTop: list_news_position},400);
});
$('#wareHouse').click(function(event) {
    event.preventDefault();
    var list_news_position = $('#wareHouse_head').offset().top;
    $('html').animate({scrollTop: list_news_position},400);
});
$('#deal').click(function(event) {
    event.preventDefault();
    var list_news_position = $('#deal_head').offset().top;
    $('html').animate({scrollTop: list_news_position},400);
});
$('#service').click(function(event) {
    event.preventDefault();
    var list_news_position = $('#service_head').offset().top;
    $('html').animate({scrollTop: list_news_position},400);
});
$('#recruitment').click(function(event) {
    event.preventDefault();
    var list_news_position = $('#recruitment_head').offset().top;
    $('html').animate({scrollTop: list_news_position},400);
});
$('#enterprise').click(function(event) {
    event.preventDefault();
    var list_news_position = $('#enterprise_head').offset().top;
    $('html').animate({scrollTop: list_news_position},400);
});

$('#deal_price').keyup(function(e) { 
    if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || (e.keyCode == 8))
    {
        var str = $(this).val().replace(/\,/g,'') + '';
        $(this).val(String(str).replace(/(.)(?=(\d{3})+$)/g,'$1,'))
    }
});

$('#deal_price').keydown(function(e){
    if ((e.keyCode != 9) && (e.keyCode != 8) && (e.keyCode != 116) && ((e.shiftKey || (e.keyCode < 48  || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105 ))) {
        e.preventDefault();
    }
})

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
// change color of khoi hinh tam giac vuong tren menu
$('.homepage_nav').hover(function(){
    if(!$(this).hasClass('menu_active')){
        $(this).prev().toggleClass('border-bottom-black');
    }
});
// change url image khi width <= 414px
if($(window).width() <= 414) {
    var count = 1;
    $(".slide_responsive_414").each(function() {
      $(this).attr("src", $(this).attr("src").replace("slide"+count, "slide"+count+"_414"));
      count++;
  });
};
if($(window).width() > 414){
    $(".slide_responsive_414").each(function() {
      $(this).attr("src", $(this).attr("src").replace("slide"+count+"_414","slide"+count));
      count++;
  });
};
// change url image khi width <= 414px
if($(window).width() <= 414) {
    $(".banner_responsive").each(function() {
      $(this).attr("src", $(this).attr("src").replace("full", "responsive"));
  });
};
if($(window).width() > 414){
    $(".banner_responsive").each(function() {
      $(this).attr("src", $(this).attr("src").replace("responsive", "full"));
  });
};
// rate doanh nghiep
$(".rating").on('change',function(){
    $user_id = $('#hidden_user_id').val();
    $value = $(this).val();
    $enterprise_id = $(this).attr('id');
    $url = window.location.origin+"/doanh-nghiep/danh-gia";    
    $enterprise_id = $enterprise_id.split("_",1);
    console.log($enterprise_id);
    $.ajax({
        url: $url,
        method: 'get',
        dataType: 'json',
        data: { "enterprise_id": $enterprise_id, "value": $value },
        success: function(e)
        {
            if(e.STATUS == "ERROR")
            {
                if(e.data == "user_null")
                {
                    swal({
                        title: "Thông báo",
                        text: "Bạn phải đăng nhập để đánh giá doanh nghiệp này",
                        icon: "error",
                    })
                } 
                else if (e.data == "enterprise_null")
                {
                    swal({
                        title: "Thông báo",
                        text: "Không tìm thấy thông tin doanh nghiệp",
                        icon: "warning",
                    })
                }
            }
            else
            {
                swal({
                    title:  "Đánh giá thành công",
                    icon:   "success"
                })
            }
        },
        error: function()
        {
            swal({
                title: "Thông báo",
                text: "Bạn phải đăng nhập để đánh giá doanh nghiệp này",
                icon: "error",
            })      
        }
    })
});
if($(window).width() <= 768) {
    $('.triangle-bottomright').removeClass('border-bottom-black');
};
// menu responsive
function myFunction() {
    var x = document.getElementById("myTopnav");
    var a = $('.homepage_nav');
    if (x.className === "topnav") {
        x.className += " responsive";
        if(a.attr('class') === "menu_active homepage_nav")
        {
            $('.triangle-bottomright').addClass('border-bottom-black');
            $('.triangle-bottomright').css('transition', 'all ease 0s');
        }
    } else {
        x.className = "topnav";
        if(a.attr('class') === "menu_active homepage_nav")
        {
            $('.triangle-bottomright').removeClass('border-bottom-black');
            $('.triangle-bottomright').css('transition', 'all ease 0s');
        }
    }
};

// prevent enter when use autocomplete address
var input_autocomplete = ["#noi_nhan","#noi_giao","#dich_vu","#dia_chi"];
for(var i = 0; i < input_autocomplete.length; i += 1) {
    $(input_autocomplete[i]).keydown(function (e) {
        if (e.which == 13 && $('.pac-container:visible').length) return false;
    });
}

// delete tin cua user
$(".deleteItem").on("click", function () {

  var $this = $(this);
  var idTr = $this.attr("id-tr");
  var urlTr = $this.next().val();
  swal({
    title: "Xóa tin này?",
    text: "Bạn có chắc muốn xóa tin này chứ?",
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

            console.log(response);
            swal("Xóa tin thất bại!", {
              icon: "error",
          });
            console.log(response);
                          // swal( response.data, "error", "error" );
                      } else {

                          console.log(response);
                          swal("Xóa tin thành công!", {
                            icon: "success",
                        });
                          $this.parent().remove();
                          // swal( response.data, "success", "success" );
                      }
                  }
              });
  }
});
});
// ẩn tin cua user
$(".hideItem").on("click", function () {

  var $this = $(this);
  var idTr = $this.attr("id-tr");
  var urlTr = $this.next().val();
  swal({
    title: "Ẩn tin này?",
    text: "Bạn có chắc muốn ẩn tin này chứ?",
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

            console.log(response);
            swal("Ẩn tin thất bại!", {
              icon: "error",
          });
            console.log(response);
                          // swal( response.data, "error", "error" );
                      } else {

                          console.log(response);
                          swal("Ẩn tin thành công!", {
                            icon: "success",
                        });
                          $this.parent().remove();
                          // swal( response.data, "success", "success" );
                      }
                  }
              });
  }
});
});

// cau hinh fancybox
$('[data-fancybox="gallery"]').fancybox({
   loop : true,
   transitionDuration : 100,
   animationDuration : 500,
   animationEffect : "fade",
   buttons : [
   'slideShow',
   'fullScreen',
   'thumbs',
        //'share',
        'download',
        //'zoom',
        'close'
        ],
        slideShow : {
            autoStart : false,
            speed     : 300,
        },
        thumbs : {
            autoStart : true
        },
    });
// click slide change url large image
/*$('a.thumb').click(function(event) {
    var href_image_clicked = $(this).attr('href');
    href_image_clicked = href_image_clicked.replace("small","large");
    $('#big_img_detail').attr('src',href_image_clicked);
    $('#large').css("background-image", "url("+href_image_clicked+")");
});*/
// click button chinh sua show cho nguoi dung sua profile
$('.btnProfile').click(function(event) {
    var input = $('.postNews .form_post input');
    var status_of_input = input.attr('readonly');
    if(status_of_input == "readonly")
    {
        event.preventDefault();
        input.attr('readonly',false);
        input.css('border', '1px solid #ccc');
        $(this).text('Lưu thay đổi');
        $(this).css('margin-left','-6%');
    }
    input.focus(function(){
        $(this).css('box-shadow','inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102,175,233,.6)');
    })
    input.focusout(function(event) {
        $(this).css('box-shadow','none');
    });
});
// khong co du lieu khong tim kiem
$('#timkiem_icon form').submit(function(){
    var value = $('#search_all').val();
    if(value == "")
    {
        event.preventDefault();
    }
});
//scroll top
$('.backtotop').hide();
$(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.backtotop').fadeIn();
        } else {
            $('.backtotop').fadeOut();
        }
    });
    // scroll body to 0px on click
    $('.backtotop').click(function () {
        $('body,html').animate({
            scrollTop: 0
        });
        return false;
    });
});
//scroll danh muc
/*$(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > ($('.enterprise__news-menu').offset().top)) {
            $('.enterprise__news-menu').addClass('fixed');
            }
        else if($(this).scrollTop() < ($('.enterprise__news-menu').offset().top)){
            $('.enterprise__news-menu').removeClass('fixed');
        }
});
});*/
// hieu ung danh sach tin cua user
$('.category_checkbox').click(function(e) {

    if($(this).is(":checked"))
    {   
        $(this).parent().css({
            'box-shadow': '0 0 20px 0 rgba(0,0,0,0.3)',
            'background-color': '#ffdab1',
        });
        $(this).next().css('display', 'none');
        $(this).prev().css('display', 'block');
    }
    else
    {
        $(this).parent().css({
            'box-shadow': 'none',
            'background-color': '#fff',
        });
        $(this).prev().css('display', 'none');
        $(this).next().css('display', 'block');
    }
});
$('#cargo_checkbox').on('change',function(e){
    var a = $(document).find('#cargo_component');
    if(!$(this).is(":checked"))
    { 
        a.css('display','none');
    }
    else
    {
        a.css('display','block');
    }
});
$('#vehicle_checkbox').on('change',function(e){
    var a = $(document).find('#vehicle_component');
    if(!$(this).is(":checked"))
    { 
        a.css('display','none');
    }
    else
    {
        a.css('display','block');
    }
});
$('#warehouse_for_checkbox').on('change',function(e){
    var a = $(document).find('#for_component');
    if(!$(this).is(":checked"))
    { 
        a.css('display','none');
    }
    else
    {
        a.css('display','block');
    }
});
$('#warehouse_need_checkbox').on('change',function(e){
    var a = $(document).find('#need_component');
    if(!$(this).is(":checked"))
    { 
        a.css('display','none');
    }
    else
    {
        a.css('display','block');
    }
});
$('#deal_checkbox').on('change',function(e){
    var a = $(document).find('#deal_component');
    if(!$(this).is(":checked"))
    { 
        a.css('display','none');
    }
    else
    {
        a.css('display','block');
    }
});
$('#service_checkbox').on('change',function(e){
    var a = $(document).find('#service_component');
    if(!$(this).is(":checked"))
    { 
        a.css('display','none');
    }
    else
    {
        a.css('display','block');
    }
});

// autocomplete google map api
var noi_nhan,noi_giao,dich_vu,dia_chi;
        //autocomplete google address
        function initAutocomplete() {
        // autocomplete tỉnh, thành phố cho sort
        if(document.getElementById('tinh_thanhpho') != null)
        {
            noi_nhan = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById('tinh_thanhpho')),
                {types: ['(cities)'],componentRestrictions: {country: "vn"}});
        }
        // khởi tạo autocomplete nơi nhận
        //thêm sự kiện select autocomplete
        if(document.getElementById('noi_nhan') != null)
        {
            noi_nhan = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById('noi_nhan')),
                {types: ['geocode'],componentRestrictions: {country: "vn"}});
        }
        if(typeof(geolocate_noi_nhan) !== "undefined")
        {
            noi_nhan.addListener('place_changed', geolocate_noi_nhan);
        }
        // khởi tạo autocomplete nơi giao
        if(document.getElementById('noi_giao') != null)
        {
            noi_giao = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById('noi_giao')),
                {types: ['geocode'],componentRestrictions: {country: "vn"}});
        }
        //thêm sự kiện select autocomplete
        if(typeof(geolocate_noi_giao) !== "undefined"){
            noi_giao.addListener('place_changed', geolocate_noi_giao);
        }

        if (document.getElementById('dich_vu') != null) {
            dich_vu = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById('dich_vu')),
                { types: ['geocode'], componentRestrictions: { country: "vn" } });
        }
        if (typeof (geolocate_dich_vu) !== "undefined") 
        {
            dich_vu.addListener('place_changed', geolocate_dich_vu);
        }
        
        if(document.getElementById('dia_chi') != null)
        {
            dia_chi = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById('dia_chi')),
                {types: ['geocode'],componentRestrictions: {country: "vn"}});
        }
        if(typeof(geolocate_dia_chi) !== "undefined")
        {
            dia_chi.addListener('place_changed', geolocate_dia_chi);
        }
        if(typeof(myMap) !== "undefined"){
            myMap();
        }
    }
    $("#user_agent").val(navigator.userAgent);



    