

function data_table_row_status(a, id, url, status, callback)
{
	data_table_row_action(a, id, url, 'status', {'status':status},callback);
}
function data_table_row_delete(a, id, url,callback)
{
	data_table_row_action(a, id, url, 'delete', {},
	function(){
		$(a.parentNode.parentNode).remove();
		callback();
	});
}

function data_table_row_category_delete(a, id, url,callback)
{
	data_table_row_action(a, id, url, 'delete', {},
	function(){
		$(a.parentNode.parentNode.parentNode).remove();
		callback();
	});
}
function data_table_row_action(a, id, url, task,data, callback)
{
	var el =$(a);
	data.id=id;
	data.task=task;
	// el.html('<i class="fa fa-spinner fa-spin"></i>');
	
	setTimeout(function()
	{
		$.post(url,data,function(obj)
		{
			if(isObject(obj))
			{
				if(isFunction(callback))
					callback(obj);
				
			}else{
				alert("Error: "+ obj);
			}
			
			// el.show().next().remove();
			
		},"json");
	},200);
}




function media_save_credit(a,id)
{
	media_save_data(a,id,"save_credit", function(){});
}
function media_save_title(a,id)
{
	media_save_data(a,id,"save_title", function(value)
	{
		$('#mediaTitle'+ id).text(value);
	});
}
function dlg_media_save_title(a)
{
	media_save_title(a,$.mediaDialog.selectedItem.id);
}
function dlg_media_save_credit(a)
{
	media_save_credit(a,$.mediaDialog.selectedItem.id);
}

function media_save_data(a,id,task, callback)
{
	var inp = $('input',a.parentNode.parentNode);
	var prev=$(a).html();
	var value = inp.val();
	inp[0].disabled = a.disabled=true;
	$(a).html('<span class="spinner16 run"></span>');
	
	var postData = {"id":id, "task":task,"value":value};
	setTimeout(function()
	{
		$.post("/admin/media",postData,function()
		{
			inp[0].disabled = a.disabled=false;
			$(a).html(prev);
			if(callback)
			callback(value);
		});
	},300);
}
