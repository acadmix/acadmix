<?php include("templates/header.php");?>

<script>
    jQuery(document).ready(function(){
       jQuery("#emp_position").change(function(){
            window.location.href = "<?php echo base_url('/payroll/employee');?>"+"/?p="+$("#emp_position option:selected").val();
        }); 
    });
    
    jQuery(document).on("click",".benefit_remove",function(){
        if(confirm("Are you sure you want to delete this benefit?"))
        {
            var index = $(".benefit_remove").index(this);
            $(".benefits_tr").eq(index).remove();
        }
    });
    
    jQuery(document).on("click",".deduction_remove",function(){
        if(confirm("Are you sure you want to delete this deduction?"))
        {
            var index = $(".deduction_remove").index(this);
            $(".deductions_tr").eq(index).remove();
        }
    });
    
    jQuery(document).on("click","#submit_details",function(){
        var i;
        var err_flag = 0;
        var benefits_id=[];
        var benefits_name=[];
        var benefits_amt=[];
        var deductions_id=[];
        var deductions_name=[];
        var deductions_amt=[];
        
        if($("#emp_name option:selected").val()==0)
        {
            $(".err_slip").text('Please select employee');
            return false;
        }
        if($("#basic_pay").val().trim()=="")
        {
            $(".succ_basicpay").text("");
            $(".err_basicpay").text("Field Required");
            return false;
        }
        if(!(!/^\s*$/.test($("#basic_pay").val()) && !isNaN($("#basic_pay").val())))
        {
            $(".succ_basicpay").text("");
            $(".err_basicpay").text("Invalid input");
            return false;
        }
        for(i = 0; i<$(".benefit_name").length; i++)
        {   
            if($(".benefit_name").eq(i).val().trim()=="" || $(".benefit_amt").eq(i).val().trim()=="")
            {
                $(".err_benefits").eq(i).text('Empty fields not allowed');
                err_flag = 1;
            }
            else if(/^\s*$/.test($(".benefit_amt").eq(i).val()) || isNaN($(".benefit_amt").eq(i).val()))
            {
                $(".err_benefits").eq(i).text('Invalid benefit amount value');
                err_flag = 1;
            }
            else
            {
                benefits_id.push($(".benefit_id").eq(i).val());
                benefits_name.push($(".benefit_name").eq(i).val());
                benefits_amt.push($(".benefit_amt").eq(i).val());
            }
        }
        for(i = 0; i<$(".deduction_name").length; i++)
        {   
            if($(".deduction_name").eq(i).val().trim()=="" || $(".deduction_amt").eq(i).val().trim()=="")
            {
                $(".err_deductions").eq(i).text('Empty fields not allowed');
                err_flag = 1;
            }
            else if(/^\s*$/.test($(".deduction_amt").eq(i).val()) || isNaN($(".deduction_amt").eq(i).val()))
            {
                $(".err_deductions").eq(i).text('Invalid deduction amount value');
                err_flag = 1;
            }
            else
            {
                deductions_id.push($(".deduction_id").eq(i).val());
                deductions_name.push($(".deduction_name").eq(i).val());
                deductions_amt.push($(".deduction_amt").eq(i).val());
            }
        }
        if(err_flag == 1)
            return false;
        else
        {
            $(".loader_slip").css({'display':'inline'});
            var dataString = 'position_id='+$("#emp_position option:selected").val()+'&employee_id='+$("#emp_name option:selected").val()+'&basic_pay='+$("#basic_pay").val()+'&benefits_id='+JSON.stringify(benefits_id)+'&benefits_name='+JSON.stringify(benefits_name)+'&benefits_amt='+JSON.stringify(benefits_amt)+'&deductions_id='+JSON.stringify(deductions_id)+'&deductions_name='+JSON.stringify(deductions_name)+'&deductions_amt='+JSON.stringify(deductions_amt);
            var url = "<?php echo base_url('/payroll/generate_slip');?>";
            $.ajax({
                type: "POST",
                url: url,
                data: dataString, // serializes the form's elements.
                success: function(data)
                {
                    $(".loader_slip").css({'display':'none'});
                    //alert(data);
                    //window.location.href = "< ?php echo base_url('/payroll/position');?>"+"/?p="+$("#emp_position option:selected").val();
                }
              });
            return false;
        }
    });
</script>
<td valign="top">
                                    <div class="cont_right formWrapper">
                                        <div class="formCon">
                                            <h2>Calculate salary of employees on the basis of positions</h2>
                                            <div class="formConInner">
                                                <p class="note">Fields with <span class="required">*</span> are required.</p>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tbody>
                                                        <tr>
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
                                                        <tr>
                                                            <td style="width:220px;"><label>Select Employee Name </label></td>
                                                            <td>
                                                                <select id="emp_name" style="width: 220px;">
                                                                    <?php if(count($employees)==0):?>
                                                                      <option value="0">No Employee Present</option>
                                                                    <?php else: ?>
                                                                      <?php foreach($employees as $e):?>
                                                                          <option value="<?php echo $e->id;?>"><?php echo ucfirst($e->first_name)." ".ucfirst($e->middle_name)." ".ucfirst($e->last_name);?></option>
                                                                      <?php endforeach;?>
                                                                    <?php endif;?>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                  </tbody>
                                                </table>
                                           <?php if(count($positions)!=0):?>
                                                <h3>Basic pay</h3>
                                                <table border="0" cellspacing="0" cellpadding="0">
                                                    <tbody><tr>
                                                      <td style="width:150px;"><label for="basic_pay" class="required">Basic Pay </label></td>
                                                      <td style="width:420px;"><input type="text" id="basic_pay" value="<?php if(count($payroll_basicpay)!=0) echo $payroll_basicpay->basic_pay;?>" />&nbsp;&nbsp;&nbsp;INR&nbsp;&nbsp;&nbsp;<span class="err err_basicpay"></span></td>
                                                      
                                                    </tr></tbody>
                                                </table>
                                                <h3>Benefits</h3>
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
                                                

                                                <h3>Deductions</h3>
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
                                                <input style="height:28px; margin: 20px 0 20px 20px;" id="submit_details" class="formbut" type="submit" value="Generate Salary Slip">&nbsp;&nbsp;&nbsp;<span class="err err_slip"></span><img class="loader_slip" style="vertical-align:middle; display:none;" src="<?php echo base_url('../images/loader.gif');?>" /><span class="succ succ_slip"><?php echo $this->session->flashdata('succ_slip');?></span>
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