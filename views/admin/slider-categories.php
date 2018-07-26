
<form method="post">
<div class="grid cols-2">
	<div>
    	<h1><?php echo $this->title  ?></h1>
    </div>
    <div> 
    	
        <input type="hidden" value="update_ordering" name="task" />
        <button class="button default float-right"><i class="fa fa-sort-amount-asc"></i> Update Ordering</button>
        
    </div>
</div>

<br />


<table id="mediaTableData" class="datatable table border-outer xborder-cell-h table-striped">
<thead>
	<tr>
        <th>Title</th>
        <th class="text-center">Action</th>
        <th>pathName</th>
        <th class="text-center">Ordering</th>
    </tr>
</thead>
<tfoot>
    <tr>
        <td colspan="10">
        ...
        </td>
    </tr>
</tfoot>
<?php foreach($this->terms as $item){
	$status = $item->status!=1?'':' published';
?>
	<tr>
        <td class="main"><div id="termTitle<?php echo $item->id ?>"><?php echo $item->title ?></div></td>
        <td class="text-center">
        <span class="relative">
        	<a data-dock="br" data-role="dropdown" href="javascript:;" class="fa fa-pencil"></a>
            <div class="popup">
            	<div class="wrapper" style="min-width:320px; width:400px">
                    <label class="text-gray">Category Title</label>
                    <div class="input-group">
                      <input class="form-element" value="<?php echo htmlentities($item->title) ?>" />
                      <span class="input-group-button">
                        <button onclick="term_save_data(this,<?php echo $item->id ?>)" 
                        type="button" class="button default"><i class="fa fa-floppy-o"></i></button>
                      </span>
                    </div>
                </div>
            </div>
        </span>
        
        		<span class="spacer"></span>
     
				<a href="javascript:;" style="float:left;" data-status="<?php echo $item->status; ?>" onclick="_status(this,<?php echo $item->id ?>)">
				<span class="status <?php echo $item->status ? "active" : "unactive";  ?> ">
					<?php echo $item->status ? "Aktif" : "Tidak Aktif"; ?>
					
				</span>
				</a>
			
        <!-- <a data-status="<?php echo $item->status ?>" 
        onclick="_status(this,<?php echo $item->id ?>)" 
        href="javascript:;" class="status icon icon-checkmark<?php echo $status ?>"></a> -->
        </td>
        
        
        <td>/<span id="termPath<?php echo $item->id ?>"><?php echo $item->pathName ?></span></td>
        <td class="text-center">
		<input name="ordering[<?php echo $item->id ?>]" style="width:50px" value="<?php echo $item->ordering ?>" /></td>
        
    </tr>
<?php } ?>
</table>
</form>

<br />
<br />
<?php $this->pageMessage() ?>
<form method="post" class="form">
<input type="hidden" value="add_new" name="task" />
<label>Add New Category</label>
<div>
	<div class="input-group">
	<label>Parent Category :</label>
  <select class="form-element" name="parentId" id="parentId">
  	<?php
  	echo '<option value="0">None</option>';
  		foreach ($this->terms as $value) {
  			
			
		
				echo '<option  value="'.$value->id.'"> '.$value->title.'</option>';	
		
			
			
			  ?>
			  
			  
			  
	
	<?php
		  }
  	
  	 ?>
  </select>
</div>
</div>



<div>
<div class="input-group">
  <input autocomplete="off" class="form-element" name="title" value="" />
  <span class="input-group-button">
    <button type="submit" class="button success"><i class="fa fa-plus"></i></button>
  </span>
</div>
</div>

</form>


<script>

function _status(a, id){
	var el = $(a);
	var s =  el.data('status');
	
	data_table_row_status(a, id,  "/admin/categories", s, function(obj)
	{
		
		// if(currentStatus==-1)
		// {
			if(s==1){
				el.data('status',0);
				el.html('<span class="status unactive">Tidak Aktif</span>');
			}else{
				el.data('status',1);
				el.html('<span class="status active">Aktif</span>');
			}
		
	});


}


function term_save_data(a,id)
{
	var inp = $('input',a.parentNode.parentNode);
	var prev=$(a).html();
	var value = inp.val();
	inp[0].disabled = a.disabled=true;
	$(a).html('<span class="spinner16 run"></span>');
	var postData = {"id":id, "task":"update_title","value":value};
	
	$.post("/admin/categories",postData,function(s)
	{
		inp[0].disabled = a.disabled=false;
		$(a).html(prev);
		if(s){
			$('#termTitle'+ id).text(value);
			$('#termPath'+ id).text(s);
		}
	});
}
</script>

