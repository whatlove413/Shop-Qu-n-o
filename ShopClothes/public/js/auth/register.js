$(".btn-show-more").on('click',function(){$(".accept-info-title").css("display","none");$(".collapse-info").css("display","none");});$(".btn-close").on('click',function(){$('.collapse').collapse('hide');$(".accept-info-title").css("display","inline ");$(".collapse-info").css("display","inline ");});$('.collapse').on('hidden.bs.collapse',function(){$("#status").attr('value','0');})
$('.collapse').on('show.bs.collapse',function(){$("#status").attr('value','1');})
function readURLLicence(input){if($("#register_licence_images")[0]){var reader=new FileReader();reader.onload=function(e){$('#licence_images').attr('src',e.target.result);};reader.readAsDataURL(input.files[0]);}}function readURLDetail(input){if($("#register_detail_images")[0]){var reader=new FileReader();reader.onload=function(e){$('#detail_image').attr('src',e.target.result);};reader.readAsDataURL(input.files[0]);}}