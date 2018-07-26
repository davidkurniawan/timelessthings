
<div class="grid cols-2">
	<div>
    	<h1><?php echo $this->title ?></h1>
    </div>
	<div class="text-right">
        <!--form>
            <div class="input-group float-right" style="width:60%;">
                <input placeholder="Search..." class="form-element">
                <span class="input-group-button">
                <button type="button" class="button primary">Go!</button>
                </span>
            </div>
        </form-->
    </div>
</div>
<br />
<?php if(!$this->items): ?>

<?php else:  ?>



<table id="tableUsers" class="datatable table border-outer xtable-hover  table-striped">
<thead>
	<tr>
    	<!--th><i class="icon icon-menu"></i></th-->
        <th class="full-width">Name</th>
        <th>Email</th>
       
        <th>Role</th>
		<th></th>
        	<th class="nowrap text-right">Last Visit</th>
      
        
        <th class="text-right">Registered</th>
    </tr>
</thead>
<tfoot>
    <tr>
        <td colspan="10" class="pagination">
            <ul>
                <?php echo $this->dataview->pagination->getHtml(6,"p");?>
            </ul>
            Page <?php echo $this->pageIndex;?>  of <?php echo $this->dataview->pageLength ?>
        </td>
    </tr>
</tfoot>
<tbody>

<?php foreach( $this->items as $item) {
	$status = $item->status!=1?'':' published';
	?>
	<tr class="status<?php  echo $item->status  ?>">
    	<!--td>
        <label class="checkbox"><input type="checkbox" /><div></div></label>
        </td-->
        <td class="nowrap bold main">
        	<a href="<?php echo Request::$pathUrl ?>/edit?id=<?php echo $item->id ?>"><i class="icon icon-user"></i> <?php echo $item->name ?></a>
        </td>
        <td class="nowrap"><?php echo $item->email ?></td>
        <td class="nowrap"><?php echo $item->roleTitle ?> 
        	
        	
        </td>
 
        <td class="nowrap text-center">
		
		<?php if($item->id != $this->currentUser->id)
		{
			?>
			
			 <a id="statusid" data-status="<?php echo $item->status ?>" onclick="_status(this,<?php echo $item->id ?>)" href="javascript:;" 
            class="status <?php echo  $item->status ? "active" : "unactive" ?>">
            	<i class="fa fa-check"></i>
            </a>
            
            
            
            
            <span class="spacer"></span>
            
            <a href="javascript:;"  onclick="_delete(this,<?php echo $item->id ?>)"  title="Delete permanently" >
            	<i class="fa fa-trash"></i>
            </a>
			
		<?php } ?>
            
        
            
        </td>
        
	
        	<td class="nowrap text-right"><?php echo date('d M Y H:i',strtotime($item->lastVisit)) ?></td>

        
        <td class="nowrap text-right"><?php echo date('d M Y H:i',strtotime($item->dateRegistered)) ?></td>
    </tr>
<?php } ?>




</tbody>
</table>

<?php endif;  ?>

<script language="javascript">
var pathUrl = window.location.href.split('?')[0];

function _status(a, id){
	var el = $(a);
	var s =  el.data('status');
	data_table_row_status(a, id,  pathUrl, s, function(obj)
	{
		
		
			if(s==1){
				el.data('status',0);
				el.removeClass('active');
				el.addClass('unactive');
				el.html('<i class="fa fa-check"></i>');
			}else{
				el.data('status',1);
				el.removeClass('unactive');
				el.addClass('active');
				el.html('<i class="fa fa-check"></i>');
			}
		
	});
}
function _delete(a, id)
{
	if(confirm("Are you sure to delete the selected user?")){
		var el = $(a);
		data_table_row_delete(a, id, pathUrl,null);
	}
}



</script>

