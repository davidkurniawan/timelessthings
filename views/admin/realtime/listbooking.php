<?php foreach($this->patients as $index => $item){ ?> 
                        <tr>
                            <td>
                                <div>
                                    <?php echo $item->name; ?>
                                </div>
                            </td>

                            <td>
                                <div>
                                    <?php echo date("d-m-Y", strtotime($item->bookingDate)); ?>
                                </div>
                            </td>

                            <td>
                                <div>
                                   <?php $branch = Adm_Branch::getSingleBranch($item->branchId); echo $branch->title; ?>
                                </div>
                            </td>

                            <td>
                                 <div>
                                   <?php $category =  app::$database->getObject("SELECT item.title FROM #__rs_doctor_category  as item WHERE id =  ".$item->drCategory ); echo $category->title; ?>
                                </div>    
                            </td>
                            
                            <td>
                                <?php $insurance =  app::$database->getObject("SELECT * FROM #__rs_insurance WHERE id = ".$item->insuranceId); 

                                    if($item->insuranceId > 0){
                                        echo $insurance->name;
                                    }else{
                                        echo "Tidak Menggunakan Asuransi";
                                    }
                                     
                                
                                ?>
                            </td>
                            <td>
                                <div class="status-booking booking<?php echo $item->status; ?>">
									<strong><?php echo $this->statusBooking[$item->status]; ?></strong>
								</div>                  
                            </td>
                            <td class="text-center">
                                <?php echo CustomHelper::time2str($item->bookingCreated);?> 
                            </td>
                            <td class="text-center">
                                <div class="book-action">
                                    <a href="javascript:;" class="approve"><i class="fa fa-pencil-square-o"></i></a>
                                    <!--<a href="javascript:;" id="cancel"><i class="fa fa-close"></i> Cancel</a>-->
                                </div>
                            </td>
                        </tr>
                    <?php } ?>