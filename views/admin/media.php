
<div class="grid cols-2">
	<div>
    	<h1><?php echo $this->title  ?></h1>
    </div>
    <div>

        <div class="input-group float-right" style="width:60%;">
          <input placeholder="Search..." class="form-element" />
          <span class="input-group-button">
            <button type="button" class="button primary">Go!</button>
          </span>
        </div>
        <div id="btnAddFiles" type="button" style="margin-right:10px" class="button default float-right"><i class="fa fa-upload"></i>
        	<input type="file" id="inputFile" multiple="multiple" />
        </div>
    </div>
</div>

<br />
<table id="mediaTableData" class="datatable table border-outer xborder-cell-h table-striped">
<thead>
	<tr>
    	<th></th>
        <th class="full-width">Title</th>
        <th class="text-center"></th>
        <th>Type</th>
        <th>Poster</th>
        <th class="text-right">Published</th>
    </tr>
</thead>
<tfoot>
    <tr>
        <td colspan="10" class="pagination">
            <ul>
                <?php
                if(!empty($this->items))
                {
                	echo $this->dataview->pagination->getHtml(6,"p");
                }
                //echo $this->dataview->pagination->getHtml(6,"p");
                ?>
            </ul>
            Page <?php echo $this->pageIndex;?>  of <?php echo $this->dataview->pageLength ?>
        </td>
    </tr>
</tfoot>
<?php foreach( $this->items as $item) {
		$ext = $item->extension;
		$attr = '';
		$isImage = true;
		if($ext=='jpg' || $ext=='png'){
			$attr = 'class="media-thumb" style="background-image:url(' .  $item->thumbnailUrl . ')"';
		}else{
			$isImage=false;
			$attr = 'class="media-thumb ' . $item->extension . '"';
		}
?>
	<tr id="mediaItem<?php echo $item->id ?>" data-file='<?php echo json_encode($row) ?>'>
    	<td><img src="<?php echo $this->templateUrl ?>/images/media_thumb.png" <?php echo $attr ?> /></td>
        <td class="main">
        <div  id="mediaTitle<?php echo $item->id ?>"><?php echo $item->title ?></div>
        <div class="text-gray"><?php echo ($item->fileSize/1000) ?> KB</div>
        </td>
        <td class="text-center">

        <?php if($isImage){ ?>
        <span class="relative">
        	<a data-dock="br" data-role="dropdown" href="javascript:;" class="fa fa-pencil"></a>
            <div class="popup">
            	<div class="wrapper" style="min-width:320px; width:400px">
                    <label class="text-gray">Title / Alt</label>
                    <div class="input-group">
                      <input class="form-element" value="<?php echo htmlentities($item->title) ?>" />
                      <span class="input-group-button">
                        <button onclick="media_save_title(this,<?php echo $item->id ?>)" type="button" class="button default"><i class="fa fa-floppy-o"></i></button>
                      </span>
                    </div>
                	<label class="text-gray"l>Credit Title</label>
                    <div class="input-group">
                      <input value="<?php echo htmlentities(@ $item->metaData["credit"] )?>" class="form-element" />
                      <span class="input-group-button">
                        <button onclick="media_save_credit(this,<?php echo $item->id ?>)" type="button" class="button default"><i class="fa fa-floppy-o"></i></button>
                      </span>
                    </div>
                </div>
            </div>
        </span>
        <?php } else { ?>
        	<i class="fa fa-pencil2 text-gray"></i>
        <?php }  ?>

        <span class="spacer"></span>
        <a title="Delete permanently" onclick="_delete(this,<?php echo $item->id ?>)" href="javascript:;"><i class="fa fa-close"></i></a>
        </td>
        <td class="nowrap"><?php echo strtoupper($item->extension) ?> File</td>
        <td><?php echo $item->posterName ?></td>
        <td class="nowrap text-right"><?php echo $item->datePosted ?></td>
    </tr>
<?php } ?>
</table>


<script language="javascript" src="/tpl/admin/js/scripts.js"></script>

<script language="javascript" src="/tpl/admin/js/media.js"></script>











