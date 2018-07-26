
    <div class="topHeader">
        <div class="grid cols-2 spacing-15">
            <div>
            <a href="<?php echo Request::$baseUrl.'/admin/patient'; ?>" class="button btn-outline" > <i class="fa fa-undo"></i> Dashboard</a>
                      &nbsp;
            <h1 class="inline-block">Booking Online</h1>
          
                 
            </div>
            <div class="text-right">
                <div id="account">
						<!-- User Menu -->
						 <div>
		                	<button  data-role="dropdown" class="button btn-outline"><i class="fa fa-user"></i>
		                		&nbsp; <span class="hide-md"><?php echo $this->currentUser->name ?></span>
		                    <span class="caret"></span>
		                    </button>
		                    <ul class="popup">
		                    <li><a class="" href="/admin/users/edit?id=<?php echo $this->currentUser->id ?>"><i class="fa fa-pencil-square-o"></i> Edit Account</a></li>
		                    <li><a class="bold" href="/admin/logout"><i class="fa fa-power-off"></i> Log out</a></li>
		                    </ul>
		                </div>
					</div>

            </div>
        </div>
    </div>

        <div class="mainContent">
            <table id="realtime" class="datatable table border-outer xborder-cell-h table-striped">
                <thead>
                        <th>Pasien</th>
                        <th class="text-center">Rekam Medis</th>
                        <th>Tanggal Booking</th>
                        <th>Cabang</th>
                        <th>Poliklinik</th>
                        <th>Dokter</th>
                        <th>Asuransi</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Tanggal Daftar</th>
                        <th class="text-center">Action</th>
                </thead>
                <tbody>
                    
                  

                </tbody>
            </table>
        </div>

          <div class="loading-realtime"><i class="fa fa-spinner fa-spin"></i></div>

    <div class="footer">

    </div>


    <div id="modalFeedback" data-role="modal" data-title="Approve/Cancel Booking" data-width="550" data-height="470" >
    
        <div class="form-wrapper">
            <form class="form">
               
                <label>
                    Status Booking
                    <select name="statusBooking" id="statusBooking" class="form-element block">
                        <option value="0">Pending</option>
                        <option value="1">Approve</option>
                        <option value="2">Cancel</option>
                    </select>
                </label>
                 <label>
                    No. Antrian
					<input type="number" placeholder="" min="0" id="bookingNumber" name="bookingNumber" value="0" class="form-element block"/>
                </label>
                <label>
                    Pesan Untuk Pasien
                    <textarea name="bookingMessage" id="bookingMessage" class="no-resize form-element block" cols="30" rows="10"></textarea>
                </label>
                <div class="text-center">
                    <button style="max-width:250px; width:100%;" type="button" id="btnSend" class="button success large"> Kirim  <i class="fa fa-send"></i></button>
                </div>
                    
                
            </form>
        </div>
    </div>

    <div id="modalDetail" data-role="modal" data-title="Status Pasien" data-width="550" data-height="370" >
        <div class="detailWrapper">
            
        </div>
    </div>


    <script>
        var pathUrl = window.location.href.split('?')[0];
        var $tbody = $('#realtime tbody');
        var lastId = 0;
        var $loadingRealtime = $(".loading-realtime");
        

        function load_data()
        {
            
            $.post( pathUrl, {"task":"refresh", "currentLastId" : lastId} ,
                function(ret)
                {
                      //  console.log(ret.items);
                        if(ret.items.length)
                        {
                            renderHtml(ret);
                            
                        }
                        $loadingRealtime.hide();
                        lastId = ret.id;
                        setTimeout(load_data,1000);
                }
            ,"json").error(function(ret){
                console.log(ret.responseText);
            });

        }

        load_data();

        function modalFeedback(el){
              var dataId = $(el).data("bookingid");
              var dataOldStatus = $(el).data("oldstatus");

              var $modalFeedback = $("#modalFeedback");
              var $formFeedback = $("#formFeedbak");
              var $btnSend = $("#btnSend");

              $modalFeedback.modal("show");
              disableForm();

              $btnSend.on("click", function(){

                 $postData = {
                     'bookingId':dataId,
                     'oldStatus': dataOldStatus,
                     'statusBooking':$("#statusBooking").val().trim(),
                     'bookingNumber':$("#bookingNumber").val(),
                     'bookingMessage':$("#bookingMessage").val().trim(),
                     'task':'feedback'
                };
                sendFeedback(el, $postData);
            });
        }

        function sendFeedback(el, $postData){
            disableForm();
            $("#modalFeedback button#btnSend").html('Sedang Mengirim <i class="fa fa-spinner fa-spin"></i>');
                      
            setTimeout(function(){
                
                $.post(pathUrl, $postData, function(ret){
                  $("#modalFeedback button#btnSend").html(' Kirim  <i class="fa fa-send"></i>');
                    $(".modal-close-button").trigger( "click" );
                    console.log(ret.status);
                    
                    if(ret.status > 0){
                        //   $(el).remove();
                        $('.sBookingId'+$postData.bookingId).removeClass("booking"+$postData.oldStatus).addClass("booking"+ret.status).text(ret.statusText);
                        //  fa-file-text-o
                        $('#btn-'+$postData.bookingId).html("<a href='javascript:;' onClick='detailRecord(this);' data-bookingid='"+$postData.bookingId+"'><i class='fa fa-file-text-o'></i> Detil</a>");


                    }
                    
                    enableForm();
                },"json").error(function(ret){
                    console.log(ret.responseText);
                    
                }).done(function(ret){

                    $("#book-"+$postData.bookingId).appendTo($tbody);

                });

            }, 500);
           
        }

        function renderHtml(ret)
        {
            lastId = ret.id;
            for(var i =0;i<ret.items.length;i++)
            {
                prependNode(ret.items[i]);
            }
        }
       
        function prependNode(item)
        {
            
            if(item.status == 0){
                $tbody.prepend(
                    '<tr id="book-'+item.id+'">\
                    <td class="rowName"><div><i class="fa fa-user"></i> '+ item.name + '</div> <div> <i class="fa fa-birthday-cake"></i> '+ item.birthDate +'</div>' + '<div> <i class="fa fa-envelope"></i> '+ item.email +'</div>' + '<div> <i class="fa fa-phone"></i> '+ item.phoneNumber1 +'</div>'+ '<div> <i class="fa fa-map-marker"></i> '+ item.address +'</div>'  +'</td>\
                    <td class="text-center">'+ item.medicalRecord +'</td>\
                    <td>'+ item.bookingDate + " " + item.bookingTime  +'</td>\
                    <td>'+ item.branch +'</td>\
                    <td>'+ item.department +'</td>\
                    <td>'+ item.doctorName +'</td>\
                    <td>'+ item.insurance +'</td>\
                    <td>\
                        <div class="status-booking booking'+item.status+' sBookingId'+item.id+'">\
                        <strong>'+item.statusBook+'</strong>\
                        </div>\
                    </td>\
                    <td class="text-center">'+ item.bookingCreated +'</td>\
                    <td class="text-center">\
                        <div id="btn-'+item.id+'" class="book-action">\
                        <a href="javascript:;" class="btnAproval" onclick="modalFeedback(this);" data-oldstatus="'+item.status+'" data-bookingid ="'+item.id+'"><i class="fa fa-pencil-square-o"></i></a>\
                        </div>\
                    </td>\
                    </tr>'

                );
            }else{
                $tbody.prepend(
                    '<tr id="book-'+item.id+'">\
                    <td class="rowName"><div><i class="fa fa-user"></i> '+ item.name + '</div> <div> <i class="fa fa-birthday-cake"></i> '+ item.birthDate +'</div>' + '<div> <i class="fa fa-envelope"></i> '+ item.email +'</div>' + '<div> <i class="fa fa-phone"></i> '+ item.phoneNumber1 +'</div>' +'</td>\
                    <td class="text-center">'+ item.medicalRecord +'</td>\
                    <td>'+ item.bookingDate + " " + item.bookingTime  +'</td>\
                    <td>'+ item.branch +'</td>\
                    <td>'+ item.department +'</td>\
                    <td>'+ item.doctorName +'</td>\
                    <td>'+ item.insurance +'</td>\
                    <td>\
                        <div class="status-booking booking'+item.status+' sBookingId'+item.id+'">\
                        <strong>'+item.statusBook+'</strong>\
                        </div>\
                    </td>\
                    <td class="text-center">'+ item.bookingCreated +'</td>\
                    <td class="text-center">\
                        <div id="btn-'+item.id+'" class="book-action">\
                        <a href="javascript:;" onClick="detailRecord(this);" data-bookingid="'+item.id+'"><i class="fa fa-file-text-o"></i> Detil</a>\
                        </div>\
                    </td>\
                    </tr>'

                );
            }
        }
        
        function disableForm(){

            $("#modalFeedback .form  input, #modalFeedback .form textarea, #modalFeedback .form button ").attr("disabled", "disabled");
            
        }

        function enableForm(){
            $("#modalFeedback .form  input, #modalFeedback .form  textarea, #modalFeedback .form button ").attr("disabled", false);
            $("#statusBooking").val(0);
            $("#bookingNumber").val(0);
            $("#bookingMessage").val('');

        }

        $("#statusBooking").on("change", function(){
                var status = $(this).val();
                // console.log(status);
                if(status == 1){

                   $("#modalFeedback .form  input, #modalFeedback .form  textarea, #modalFeedback .form button ").attr("disabled", false);
                   $("#bookingNumber").val(0);
                    $("#bookingMessage").val('');
                }else if(status == 2){

                    disableForm();
                    $("#statusBooking, #bookingMessage, #btnSend").attr("disabled", false);

                }else{
                    disableForm();
                    $("#bookingNumber").val(0);
                     $("#bookingMessage").val('');
                }
        });

        var bookingId = 0;  
        var $modalDetail = $("#modalDetail");

        function detailRecord(el){
            bookingId = $(el).data("bookingid");
            
            $.post(pathUrl, {'bookingId': bookingId, "task":"record"}, function(item){
                console.log(item);
                renderDetail(item);
                  
            },"json");
            setTimeout(function(){$modalDetail.modal("show")}, 100);

        }
        var $detailWrapper = $("#modalDetail .detailWrapper");

        function renderDetail(item){            
            $detailWrapper.html('');
            
            if(item.status == 2){
                $detailWrapper.append(
                    '<ul class="detailRecord">\
                        <li><span>Nama Pasien :</span><span>'+ item.name +'</span></li>\
                        <li><span>Nomor Antrian :</span><span>'+ item.simNumber +'</span></li>\
                        <li><span>Tanggal Lahir :</span><span>'+ item.birthDate +'</span></li>\
                        <li><span>Phone :</span><span>'+ item.phoneNumber1 +'</span></li>\
                        <li><span>Email :</span><span>'+ item.email +'</span></li>\
                        <li><span>Status Booking :</span><span>'+ item.statusBook +'</span></li></ul>\
                    <div class="alert danger"><i class="fa fa-info"></i> Pesan Untuk Pasien : <br> <span>'+ item.message +'</span>\
                    '
                );
            }else{
                $detailWrapper.append(
                    '<ul class="detailRecord">\
                        <li><span>Nama Pasien :</span><span>'+ item.name +'</span></li>\
                        <li><span>Nomor Antrian :</span><span>'+ item.simNumber +'</span></li>\
                        <li><span>Tanggal Lahir :</span><span>'+ item.birthDate +'</span></li>\
                        <li><span>Phone :</span><span>'+ item.phoneNumber1 +'</span></li>\
                        <li><span>Email :</span><span>'+ item.email +'</span></li>\
                        <li><span>Status Booking :</span><span>'+ item.statusBook +'</span></li></ul>\
                    <div class="alert info"><i class="fa fa-info"></i> Pesan Untuk Pasien : <br> <span>'+ item.message +'</span>\
                    '
                );
            }
            
        }

    </script>
