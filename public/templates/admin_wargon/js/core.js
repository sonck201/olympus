function responsive_filemanager_callback(e){$("#imgPreview").prop("src",$("#"+e).val())}function basename(e){return e.replace(/\\/g,"/").replace(/.*\//,"")}function dirname(e){return e.replace(/\\/g,"/").replace(/\/[^\/]*$/,"")}var loading='<section id="loadingBlock"><div class="loader">Loading...</div></section>',icoInfo='<i class="fa fa-fw fa-lg fa-info-circle"></i> ',icoErr='<i class="fa fa-fw fa-lg fa-times-circle"></i> ',errDetect="Error detected... Wait a moments for refreshing application!!";$(function(){$("#navbarTop li.dropdown").hover(function(){$(this).addClass("open")},function(){$(this).removeClass("open")}),ctrlAct=controller.toLowerCase()+action.substr(0,1).toUpperCase()+action.substr(1),$("#"+ctrlAct).closest(".dropdown").addClass("active"),$("#"+ctrlAct).addClass("active");var e=controller+"All",t=["add","edit"];e!=ctrlAct&&$.inArray(action,t)>=0&&($("#"+e).addClass("active"),$("#"+e).closest(".dropdown").addClass("active")),$(".hasTooltip").tooltip(),"undefined"!=typeof tinymce&&null!==tinymce&&tinymce.init({selector:".tinymce",height:300,relative_urls:!1,remove_script_host:!0,document_base_url:siteurl,valid_elements:"*[*]",entity_encoding:"raw",toolbar_items_size:"small",image_advtab:!0,plugins:["advlist autolink lists link image charmap print preview hr anchor pagebreak","searchreplace wordcount visualblocks visualchars code fullscreen","insertdatetime media nonbreaking save table contextmenu directionality","emoticons template paste textcolor colorpicker textpattern imagetools codesample responsivefilemanager"],toolbar:"undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media responsivefilemanager | forecolor backcolor | pagebreak code | wordcount",filemanager_title:"Wargon CMS - File manager",filemanager_access_key:"gCguUk5r",external_filemanager_path:siteurl+"public/plugins/filemanager/",external_plugins:{filemanager:siteurl+"public/plugins/filemanager/plugin.min.js"},content_css:[siteurl+"public/assets/css/bootstrap.min.css"]}),"undefined"!=typeof datetimepicker&&null!==datetimepicker&&$("#datetimepicker").datetimepicker({format:"YYYY-MM-DD HH:mm:ss",showTodayButton:!0}),"object"==typeof $.fancybox&&$("[data-fancybox]").fancybox(),$(".btnAdd, .btnCancel").on("click",function(){window.location.href=$(this).attr("data-href")}),$(".btnReset").on("click",function(){$("form").trigger("reset")}),$.ajaxSetup({error:function(e,t){$(".authLogin .page").removeClass("fadeIn").addClass("shake").show(),$("#loadingBlock").remove();var a=[];if(500==e.status)a.push("<p>"+icoErr+errDetect+"</p>");else if(422==e.status){var i=e.responseJSON;$.each(i,function(e,t){a.push("<p>"+icoErr+t+"</p>")})}m=a.join("\n"),""!==m&&$("#message").html('<div class="alert alert-danger animated fadeIn" role="alert">'+m+"</div>")}}),$(this).on("click",".btnActive, .btnDeactive",function(e){e.preventDefault(),$.ajax({url:$('input[name="urlUpdateStatus"]').val(),type:"POST",dataType:"json",data:{action:$(this).data("name"),id:$(this).closest("tr").prop("id"),_token:$('input[name="_token"').val()},success:function(e){$("tr#"+e.id).find(".status").html(e.view),cName=$("tr#"+e.id+" td:eq(1)").text().replace(/\|/g,"").replace(/—/g,""),alertType="active"==e.action?"success":"warning",$("#message").html('<div class="alert alert-'+alertType+' animated fadeIn" role="alert">'+icoInfo+controller+"#"+e.id+" <b>"+cName+"</b> "+e.action+"!!</div>")}})}),$("#checkAll").on("click",function(){$(this).prop("checked")===!0?$(".table").find('input[type="checkbox"]').prop("checked",!0):$(".table").find('input[type="checkbox"]').prop("checked",!1)}),onChange=!0,onChangeAttemp=1,$(this).on("change",":input",function(){onChange=!0}),$(".btnSave, .btnSaveClose, .btnSaveAdd").on("click",function(e){if(e.preventDefault(),btnName=$(this).attr("data-type"),urlEdit=$("#urlEdit").val(),urlAdd=$("#urlAdd").val(),urlAll=$("#urlAll").val(),0==onChange&&"btnSaveClose"==btnName)return void $(".btnCancel").click();if(0==onChange&&"btnSaveAdd"==btnName)return void(window.location.href=urlAdd);if(0==onChange)return void(onChangeAttemp>=3?alert("Nothing change!!"):onChangeAttemp++);if(urlUpdate=$("#urlUpdate").val(),"undefined"==typeof urlUpdate||""===urlUpdate)return alert("Let's set URL for submit data via ajax."),!1;var t={action:action,id:$("#id").val()};$.each($(":input"),function(){inputId=$(this).prop("name"),inputId.indexOf("url")<0&&(inputId.indexOf("[]")>=0&&"select-multiple"!=$(this).prop("type")?(t[inputId]=void 0!==t[inputId]&&t[inputId]instanceof Array?t[inputId]:[],$(this).is(":checked")&&t[inputId].push($(this).val())):"radio"==$(this).prop("type")||"checkbox"==$(this).prop("type")?t[inputId]=$(this).is(":checked")?$(this).val():null:t[inputId]=""!=inputId?$(this).val():null)}),"undefined"!=typeof tinymce&&null!==tinymce&&(tinyMCE.triggerSave(),$.each(t,function(e,a){var i=e.match(/^(title|content)\w+/);void 0!==i&&null!==i&&(t[i.input]=$("#"+i.input).val())})),$.ajax({url:urlUpdate,type:"POST",dataType:"json",data:t,beforeSend:function(){$("body").append(loading)},success:function(e){$("#loadingBlock").remove(),onChange=!0,"add"!=action&&$("#message").html('<div class="alert alert-success animated fadeIn" role="alert">'+icoInfo+e.message+"</div>"),"btnSave"==btnName&&"add"==action&&urlAll.length>0?($("#message").hide(),window.location.href=urlAll+"/edit/"+e.id):"btnSaveAdd"==btnName&&urlAdd.length>0?($("#message").hide(),window.location.href=urlAdd):"btnSaveClose"==btnName&&urlAll.length>0&&($("#message").hide(),window.location.href=urlAll)}})}),$(this).on("click",".btnPublish, .btnUnpublish, .btnTrash, .btnDelete",function(e){return e.preventDefault(),0==$("table.tableList input:checked").length?(alert("Please first make a selection from the list"),!1):(arrId=[],$("table.tableList input:checked").each(function(){var e=$(this).closest("tr").attr("id");e>0&&arrId.push(e)}),actionName=$.trim($(this).text()),!("Delete"==actionName&&!confirm("Are you sure to delete this item(s)?"))&&void $.ajax({url:$('input[name="urlUpdateAll"]').val(),type:"POST",dataType:"json",data:{action:actionName,arrId:arrId,_token:$('input[name="_token"').val()},success:function(e){"Delete"==e.action?($.each(e.arrId,function(e,t){$("tr#"+t).remove()}),$(".downP, .upP").addClass("disabled"),window.location.reload()):($.each(e.arrId,function(t,a){$("tr#"+a).find(".status").html(e.view)}),alertType="active"==e.action?"success":"warning",$("#message").html('<div class="alert alert-'+alertType+' animated fadeIn" role="alert">'+icoInfo+e.message+"!!</div>")),$(".table").find('input[type="checkbox"]').prop("checked",!1)}}))}),$(this).on("click",".downP, .upP",function(e){e.preventDefault();var t=$(this).closest("tr").prop("id"),a=$(this).parents("tr:first"),i=$(this).data("direction");$.ajax({url:$('input[name="urlUpdatePriority"]').val(),type:"POST",dataType:"json",data:{direction:i,id:t,_token:$('input[name="_token"').val()},success:function(e){if(1==e.reloaded)return void location.reload();cName=$("tr#"+t+" td:eq(1)").text().replace(/\|/g,"").replace(/—/g,""),$("#message").html('<div class="alert alert-success animated fadeIn" role="alert">'+icoInfo+" <b>"+cName+"#"+t+"</b> move "+i+"!!</div>"),$("tr#"+t).find(".priority").html(e.view),"up"==i?(a.prev().find(".priority").html(e.viewRelated),a.insertBefore(a.prev())):(a.next().find(".priority").html(e.viewRelated),a.insertAfter(a.next()))}})}),$(".filterGroup button").on("click",function(){a()}),$(".filterGroup select").on("change",function(){a()});var a=function(){var e=[];$.each($(".filterGroup :input"),function(){filterType=$(this).prop("name").replace("filter","").toLowerCase(),""!=filterType&&e.push(filterType+"="+$(this).val())}),window.location=siteuri+"/"+controller+"?"+e.join("&")}});