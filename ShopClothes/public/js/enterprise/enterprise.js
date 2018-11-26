var dropdown=document.getElementsByClassName("dropdown-btn");var i;for(i=0;i<dropdown.length;i++){dropdown[i].addEventListener("click",function(){this.classList.toggle("active");var dropdownContent=this.nextElementSibling;if(dropdownContent.style.display==="block"){dropdownContent.style.display="none";}else{dropdownContent.style.display="block";}});}$('.enterprise_category_btn').on('click',function(){var type=$('#category_id');type.val($(this).val());$('#search_enterprise_form').submit();});$('#myDatepicker1').datepicker({format:"dd-mm-yyyy"});$('#myDatepicker2').datepicker({format:"dd-mm-yyyy"});
$(document).on("change","#avatar_logo",function(){
	var old_images=$(document).find("#logo_preview")
	var old_block=$(document).find("#logo_preview_block");
	old_block.remove();
	old_images.remove();
	var files=$(this)[0].files;
	var url=$(this).attr("url");
	var image_data=new FormData();
	var image_name=[];
	var files_arr=[];
	var url=$(this).attr('url');
	for(var i=0;i<files.length;i++)
		{image_data.append("images[]",this.files[i]);}
	$.ajaxSetup(
		{headers:{'X-CSRF-TOKEN':$('input[name="_token"]'
			).attr('value')}});
	$.ajax({
		async:false,
		type:"POST",
		url:url,
		data:image_data,
		contentType:false,
		cache:false,
		processData:false,
		success:function(msg){
			files_arr=$.parseJSON(msg)},
		});
	for(var i=0;i<files.length;i++)
	{
		image_name.push(files_arr[i]);
		var reader=new FileReader();
		reader.onload=function(index)
		{
			return function(e)
			{
				console.log(files_arr[index]);
				var htmlappend='<div class="col-xs-4 col-sm-4 col-md-4 clear-padding block_preview_images" id="logo_preview">';
				htmlappend+='<img name="'+files_arr[index]+'" id="image_preview" width="100%" src="'+e.target.result+'"';
				htmlappend+='</img>';htmlappend+='<button id="remove_image" type="button">&#10006</button>';
				htmlappend+='<input id="images_name"  name="enterprise_logo"  value="'+files_arr[index]+'" type="hidden">';
				htmlappend+='</div>';
				$("#enterprise_logo").prepend($(htmlappend));
			}
		}(i);
		reader.readAsDataURL(files[i]);
	}
	$(this).val("");
});
$(document).on("change","#avatar_lincence",function(){var files=$(this)[0].files;var url=$(this).attr("url");
	var image_data=new FormData();var image_name=[];var files_arr=[];var url=$(this).attr('url');for(var i=0;i<files.length;i++){image_data.append("images[]",this.files[i]);}$.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('value')}});$.ajax({async:false,type:"POST",url:url,data:image_data,contentType:false,cache:false,processData:false,success:function(msg){files_arr=$.parseJSON(msg)},});for(var i=0;i<files.length;i++){image_name.push(files_arr[i]);var reader=new FileReader();reader.onload=function(index){return function(e){var htmlappend='<div class="col-xs-4 col-sm-4 col-md-4 clear-padding block_preview_images" id="lincence_preview">';htmlappend+='<img name="'+files_arr[index]+'" id="image_preview" width="100%" src="'+e.target.result+'"';htmlappend+='</img>';htmlappend+='<button id="remove_image" type="button">&#10006</button>';htmlappend+='<input id="images_name"  name="enterprise_licence_images[]"  value="'+files_arr[index]+'" type="hidden">';htmlappend+='</div>';$("#enterprise_licence_images").prepend($(htmlappend));}}(i);reader.readAsDataURL(files[i]);}$(this).val("")});