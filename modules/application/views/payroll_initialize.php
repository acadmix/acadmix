<?php include("templates/header.php");?>

<script>
    jQuery(document).ready(function(){
       jQuery("#emp_position").change(function(){
            window.location.href = "<?php echo base_url('/payroll/position');?>"+"/?p="+$("#emp_position option:selected").val();
        }); 
    });
    
    jQuery(document).on("click",".benefit_remove",function(){
        if(confirm("Are you sure you want to delete this benefit?"))
        {
            var index = $(".benefit_remove").index(this);
            var benefit_id = $(".benefit_id").eq(index).val();
            $(".benefits_tr").eq(index).remove();
            var dataString = 'position_id='+$("#emp_position option:selected").val()+'&benefit_id='+benefit_id;
            var url = "<?php echo base_url('/payroll/remove_benefit');?>";
            $.ajax({
                type: "POST",
                url: url,
                data: dataString, // serializes the form's elements.
                success: function()
                {
                    if($(".benefit_id").length==0)
                        {
                            $("#submit_benefits").css({'display':'none'});
                        }
                }
              });
            return false;
        }
  });
  
  jQuery(document).on("click",".deduction_remove",function(){
        if(confirm("Are you sure you want to delete this deduction?"))
        {
            var index = $(".deduction_remove").index(this);
            var deduction_id = $(".deduction_id").eq(index).val();
            $(".deductions_tr").eq(index).remove();
            var dataString = 'position_id='+$("#emp_position option:selected").val()+'&deduction_id='+deduction_id;
            var url = "<?php echo base_url('/payroll/remove_deduction');?>";
            $.ajax({
                type: "POST",
                url: url,
                data: dataString, // serializes the form's elements.
                success: function()
                {
                    if($(".deduction_id").length==0)
                        {
                            $("#submit_deductions").css({'display':'none'});
                        }
                }
              });
            return false;
        }
  });

</script>
<td valign="top">
                                    <div class="cont_right formWrapper">
                                        <div class="formCon">
                                            <h2>Setup payroll on the basis of employee positions</h2>
                                            <div class="formConInner">
                                                <p class="note">Fields with <span class="required">*</span> are required.</p>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tbody><tr>
                                                      <td style="width:220px;"><label for="emp_position" class="required">Select Employee Position </label></td>
                                                      <td>
                                                          <select id="emp_position" style="width: 220px;">
                                                              <?php if(count($positions)==0):?>
                                                                <option>No Employee Positions Present</option>
                                                              <?php else: ?>
                                                                <?php foreach($positions as $p):?>
                                                                    <option <?php if(isset($_GET['p']) && $_GET['p']==$p->id) echo "selected";?> value="<?php echo $p->id;?>"><?php echo $p->name;?></option>
                                                                <?php endforeach;?>
                                                              <?php endif;?>
                                                          </select>
                                                      </td>
                                                    </tr>
                                                  </tbody>
                                                </table>
                                           <?php if(count($positions)!=0):?>
                                                <h3>Basic pay for position <span class="position_name"></span></h3>
                                                <table border="0" cellspacing="0" cellpadding="0">
                                                    <tbody><tr>
                                                      <td style="width:150px;"><label for="basic_pay" class="required">Basic Pay </label></td>
                                                      <td style="width:220px;"><input type="text" id="basic_pay" value="<?php if(count($payroll_basicpay)!=0) echo $payroll_basicpay->basic_pay;?>" />&nbsp;&nbsp;&nbsp;INR</td>
                                                      <td><input style="height:28px;" id="submit_basicpay" class="formbut" type="submit" value="Save">&nbsp;&nbsp;&nbsp;<img class="loader_basic_pay" style="vertical-align:middle; display:none;" src="<?php echo base_url('../images/loader.gif');?>" /><span class="err err_basicpay"></span><span class="succ succ_basicpay"></span></td>
                                                    </tr></tbody>
                                                </table>
                                                <h3>Benefits for position <span class="position_name"></span></h3>
                                                <div id="add_benefit" style="display:inline-block; cursor:pointer;">
                                                    <img style="float:left;" src="<?php echo base_url('../images/plus_yellow.png');?>" />
                                                    <p style="float:left; margin-top: 15px; font-size: 14px; font-weight: bold;"> Add a benefit field</p>
                                                    <div style="clear:both; float:none;"></div>
                                                </div>
                                                
                                                <table class="benefits_table" style=" margin-top: 20px;" border="0" cellspacing="0" cellpadding="0">
                                                    <tbody>
                                                        <?php if(count($payroll_benefits)>0):?>
                                                            <tr style="text-align: left;">
                                                                <th style="width:40px; text-align:center;"></th>
                                                                <th style="width:150px;">BENEFIT NAME</th>
                                                                <th style="width:220px;">BENEFIT AMOUNT</th>
                                                            </tr>
                                                            <?php foreach($payroll_benefits as $b):?>
                                                            <tr class="benefits_tr">
                                                                <td style="width:40px; text-align: center; font-weight: bold;"><a class="benefit_remove">x</a></td>
                                                                <td style="width:150px;"><input type="text" class="benefit_name" value="<?php echo $b->benefit_name;?>" /></td>
                                                                <td style="width:420px;"><input type="text" class="benefit_amt" value="<?php echo $b->benefit_amt;?>" />&nbsp;&nbsp;&nbsp;INR&nbsp;&nbsp;&nbsp;<span class="err err_benefits"></span></td>
                                                                <td><input type="hidden" class="benefit_id" value="<?php echo $b->id;?>" /></td>
                                                            </tr>
                                                            <?php endforeach;?>
                                                        <?php endif;?>
                                                    </tbody>
                                                </table>
                                                <?php if(count($payroll_benefits)==0):?>
                                                    <input style="height:28px; margin: 20px 0 20px 20px; display: none;" id="submit_benefits" class="formbut" type="submit" value="Save">&nbsp;&nbsp;&nbsp;<img class="loader_benefits" style="vertical-align:middle; display:none;" src="<?php echo base_url('../images/loader.gif');?>" /><span class="succ succ_benefits"><?php echo $this->session->flashdata('succ_benefits');?></span>
                                                <?php else:?>
                                                    <input style="height:28px; margin: 20px 0 20px 20px;" id="submit_benefits" class="formbut" type="submit" value="Save">&nbsp;&nbsp;&nbsp;<img class="loader_benefits" style="vertical-align:middle; display:none;" src="<?php echo base_url('../images/loader.gif');?>" /><span class="succ succ_benefits"><?php echo $this->session->flashdata('succ_benefits');?></span>
                                                <?php endif;?>

                                                <h3>Deductions for position <span class="position_name"></span></h3>
                                                <div id="add_deduction" style="display:inline-block; cursor:pointer;">
                                                    <img style="float:left;" src="<?php echo base_url('../images/plus_yellow.png');?>" />
                                                    <p style="float:left; margin-top: 15px; font-size: 14px; font-weight: bold;"> Add a deduction field</p>
                                                    <div style="clear:both; float:none;"></div>
                                                </div>
                                                
                                                <table class="deductions_table" style=" margin-top: 20px;" border="0" cellspacing="0" cellpadding="0">
                                                    <tbody>
                                                        <?php if(count($payroll_deductions)>0):?>
                                                            <tr style="text-align: left;">
                                                                <th style="width:40px; text-align:center;"></th>
                                                                <th style="width:150px;">DEDUCTION NAME</th>
                                                                <th style="width:220px;">DEDUCTION AMOUNT</th>
                                                            </tr>
                                                            <?php foreach($payroll_deductions as $d):?>
                                                            <tr class="deductions_tr">
                                                                <td style="width:40px; text-align: center; font-weight: bold;"><a class="deduction_remove">x</a></td>
                                                                <td style="width:150px;"><input type="text" class="deduction_name" value="<?php echo $d->deduction_name;?>" /></td>
                                                                <td style="width:420px;"><input type="text" class="deduction_amt" value="<?php echo $d->deduction_amt;?>" />&nbsp;&nbsp;&nbsp;INR&nbsp;&nbsp;&nbsp;<span class="err err_deductions"></span></td>
                                                                <td><input type="hidden" class="deduction_id" value="<?php echo $d->id;?>" /></td>
                                                            </tr>
                                                            <?php endforeach;?>
                                                        <?php endif;?>
                                                    </tbody>
                                                </table>
                                                <?php if(count($payroll_deductions)==0):?>
                                                    <input style="height:28px; margin: 20px 0 20px 20px; display: none;" id="submit_deductions" class="formbut" type="submit" value="Save">&nbsp;&nbsp;&nbsp;<img class="loader_deductions" style="vertical-align:middle; display:none;" src="<?php echo base_url('../images/loader.gif');?>" /><span class="succ succ_deductions"><?php echo $this->session->flashdata('succ_deductions');?></span>
                                                <?php else:?>
                                                    <input style="height:28px; margin: 20px 0 20px 20px;" id="submit_deductions" class="formbut" type="submit" value="Save">&nbsp;&nbsp;&nbsp;<img class="loader_deductions" style="vertical-align:middle; display:none;" src="<?php echo base_url('../images/loader.gif');?>" /><span class="succ succ_deductions"><?php echo $this->session->flashdata('succ_deductions');?></span>
                                                <?php endif;?>
                                          <?php else:?>
                                                <div>
                                                    <a href="<?php echo base_url('../index.php?r=employees/employeePositions/create');?>">Click here to go to employee positions section</a>
                                                </div>
                                          <?php endif;?>
                                                    
                                            </div>
                                        </div>
                                    </div>
                                </td>

                            </tr></tbody>
                        </table>
                    </div>
                </div>
                
                <div class="span-5 last">
                        
                </div>
            </div>
        </div>

    </div>

</body>
</html>