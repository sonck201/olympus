$(function(){"object"==typeof $.fancybox&&$(this).on("click",".page#menu .btnGetData",function(){$.fancybox.open({src:$("#urlGetData").val(),type:"ajax",opts:{ajax:{settings:{data:{appTitle:$("#appTitle").val(),appModel:$("#appModel").val(),appClass:$("#appClass").val(),appType:$("#appType").val(),appPrefix:$("#appPrefix").val()}}}}})}),$(this).on("click",".btnLoadMoreMenuData",function(a){a.preventDefault(),$.ajax({url:$("#urlGetDataMore").val(),dataType:"json",data:{appTitle:$("#appTitle").val(),appModel:$("#appModel").val(),appClass:$("#appClass").val(),appType:$("#appType").val(),appPrefix:$("#appPrefix").val(),appPage:parseInt($("#appPage").val())+1},complete:function(a){$(".tableGetData tbody").find("tr").remove(),$(".tableGetData tbody").append(a.responseText)}})}),$(this).on("click",".btnChooseId",function(a){a.preventDefault(),$("#data").val($(this).prop("id")),$.fancybox.close()})});