<?php

	$statusTitles = array(
		0 => 'Draf / Pending Items',
		1 => 'Published Items',
		2 => 'Deleted Items'
	);
	
	$statusTitle = $this->statusView=== null ? "All Items": $statusTitles[$this->statusView];
?>

<div class="grid-title grid cols-2">
	<div>
    	<h1><?php echo $this->title ?></h1>
    </div>
    <div class="text-right">
    	<form>
        <div class="button-group" id="categoriesButton">
          <button class="button default" data-role="dropdown">Filter by: <span><?php echo $statusTitle; ?></span> <i class="caret"></i></button>
          <ul class="popup">
          	<li><a href="<?php echo Request::$pathUrl ?>">All Items (<?php echo $this->countAllItems ?>) </a></li>
            <li><a href="<?php echo Request::$pathUrl ?>?status=1">Published Items (<?php echo $this->countPublishItems ?>)</a></li>
            <li><a href="<?php echo Request::$pathUrl ?>?status=0">Draf / Pending Items (<?php echo $this->countDrafItems ?>)</a></li>
            <li class="divider"></li>
          	<li><a href="<?php echo Request::$pathUrl ?>?status=2">Deleted Items (<?php echo $this->countDeleteItems ?>)</a></li>
          </ul>
        </div>
        
        <div style="display:inline-block;width:50%;">
        	<form action="" method="get">
            <div class="input-group float-right">
                <input placeholder="Search..." name="q" class="form-element" />
                <span class="input-group-button">
                <button type="submit" class="button primary">Go!</button>
                </span>
            </div>
            </form>
        </div>
        <form>
    </div>
</div>


<?php if( $this->items){ ?> 
<table id="articleListTable" class="datatable table border-outer xborder-cell-h table-striped">
<thead>
	<tr>
        <?php if($this->featuredContent){ ?><th></th> <?php } ?>
        <th>Title</th>
        <th>Action</th>
         <?php if(count($this->categories)>1){ ?>
         	<td>Category</td>
         <?php }?>
      
        <th class="text-right">Date</th>
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
	<tr>
    <?php if($this->featuredContent){ ?>
    	<td class="text-center"><a href="javascript:;" 
        data-featured="<?php echo $item->featured ?>"  onclick="_featured(this,<?php echo $item->id ?>)"
        class="status fa fa-star <?php echo ($item->featured?' featured':'') ?>"></a></td>
   <?php } ?>
   
		<td class="nowrap bold main">
        	<a href="<?php echo Request::$pathUrl ?>/edit?id=<?php echo $item->id ?>"><?php echo $item->title ?></a>
        </td>
        
        <td class="text-left">
        
        <?php if($this->statusView==2){ ?>
        	<a title="Restore" data-role="tooltip" data-status="1" onclick="_status(this,<?php echo $item->id ?>)" href="javascript:;" class="status icon icon-undo"><i class="fa fa-undo"></i></a>
        	<span class="spacer"></span>
            <a title="Delete permanently" href="javascript:;" data-role="tooltip" class="icon icon-cancel-circle"></a>
        <?php }else{ ?>
        	<a href="javascript:;" style="display:inline-block;" data-status="<?php echo $item->status; ?>" onclick="_status(this,<?php echo $item->id ?>)">
									<span class="status <?php echo $item->status ? "active" : "unactive";  ?> ">
										<?php echo $item->status ? '<i class="fa fa-check"></i>' : '<i class="fa fa-close"></i>'; ?>
										
									</span>
				</a>
        	<span class="spacer"></span>
            <a title="Move to trash" data-role="tooltip" onclick="_trash(this,<?php echo $item->id ?>)" href="javascript:;"><i class="fa fa-trash"></i></a>
        <?php } ?>
        
        </td>
        
         <?php if(count($this->categories)>1){ ?>
         	<td class="nowrap"><?php echo $item->categoryTitle ?></td>
         <?php }?>
      
        <td class="text-right nowrap"><?php  echo date('d M Y H:i',strtotime($item->dateModified)) ?></td>
    </tr>
<?php } ?>
</tbody>
</table>
<?php } else {?> 

<div class="alert info">
	<div>There are no contents found on the current section or category</div>
</div>
<?php }  ?> 
<script language="javascript">
var currentStatus = <?php echo ($this->statusView===null?-1:$this->statusView) ?>;

var pathUrl = window.location.href.split('?')[0];
$mediaNewsData = $('#articleListTable');

function _status(a, id){
	var el = $(a);
	var s =  el.data('status');
	data_table_row_status(a, id,  pathUrl, s, function(obj)
	{
		
		if(currentStatus==-1)
		{
			if(s==1){
				el.data('status',0);
				el.html('<span class="status unactive"><i class="fa fa-close"></i></span>');
			}else{
				el.data('status',1);
				el.html('<span class="status active"><i class="fa fa-check"></i></span>');
			}
		}else
		{
			$(a.parentNode.parentNode).remove(); 
		}
	});
}

function _featured(a, id){
	var el = $(a);
	var s =  el.data('featured');
	
	el.removeClass("fa-star");
	el.addClass("fa-spin fa-spinner");
	data_table_row_action(a, id,  pathUrl, 'featured',{"status": s}, function(obj)
	{
		if(s==1){
			el.data('featured',0);
			el.removeClass('featured');
		}else{
			el.data('featured',1);
			el.addClass('featured');
		}
			el.removeClass("fa-spin fa-spinner");
		el.addClass("fa-star");
		
	});
}

	function _trash(a, id)
		{
			data_table_row_action(a, id,  pathUrl, 'trash', {},
			function(){
				$(a.parentNode.parentNode).remove();
			});
		}

</script>











