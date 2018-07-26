


<span style="display:none">
    <div id="mediaDialog" data-title="Insert Media" xclass="mediaDialog-loading">
        <div class="modal-content">
        	<div id="mediaDialogList" class="mediaDialog-thumbs grid cols-6 cols-lg-4  cols-md-3  cols-sm-1 spacing-5"></div>
            <div id="mediaDialogSearchList" class="mediaDialog-thumbs grid cols-6 cols-lg-4  cols-md-3  cols-sm-1 spacing-5"></div>
            <div id="mediaDialogParam">
            	<div id="dlgParamThumb"></div>
            	<div id="dlgParamName" class="ellipsis bold">bumn-insight-december-2015.jpg</div>
                <div id="dlgParamDate" class="ellipsis text-gray">13 Dec 2014 21:42</div>
                <div id="dlgParamSize" class="ellipsis text-gray">345 KB</div>
                <div id="dlgParamImage">
                
                	<label class="text-gray">Title / Alt</label>
                    <div class="input-group">
                      <input id="dlgParamAlt" class="form-element" />
                      <span class="input-group-button">
                        <button onclick="dlg_media_save_title(this)" type="button" class="button default"><i class="fa fa-floppy-o"></i></button>
                      </span>
                    </div>
                	<label class="text-gray"l>Credit Title</label>
                    <div class="input-group">
                      <input id="dlgParamCredit" class="form-element" />
                      <span class="input-group-button">
                        <button onclick="dlg_media_save_credit(this)" type="button" class="button default"><i class="fa fa-floppy-o"></i></button>
                      </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div id="mediaDialog_btnUploadFiles" class="button default float-left"><i class="fa fa-upload"></i> Upload Files
                <input type="file" id="mediaDialog_btnUploadInput" multiple="multiple" />
            </div>
            <!--button style="margin-left:5px" id="" class="button default float-left"><i class="icon icon-refresh"></i></button-->
            <form onsubmit="$.mediaDialog._search(); return false"><input id="mediaDialog_searchInput" style="margin-left:5px" placeholder="Search" class="form-element  float-left" /></form>
            <button id="mediaDialog_BtnInsert" class="button success">Insert Selected To Page</button>
        </div>
        <div class="spinner-wrapper"><span class="spinner"></span></div>
    </div>
</span>

<script language="javascript" src="<?php echo $this->templateUrl . "/js/media-dialog.js" ?>"></script>
<script language="javascript">
<?php //require $this->templatePath . "/js/media-dialog.js"  ?>
</script>

