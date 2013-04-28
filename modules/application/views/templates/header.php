<!DOCTYPE html>

<html>
	<head>
		<link rel="stylesheet" href="<?php echo base_url('../css/style.css');?>" />
                <link rel="stylesheet" href="<?php echo base_url('../css/formstyle.css');?>" />
                <link rel="stylesheet" href="<?php echo base_url('../css/formelements.css');?>" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
                <script>
                    $(document).ready(function() {
                        $("#lodrop").on('click',function(){

                                        if ($(".lo_drop").is(':hidden')){
                                                $(".lo_drop").show();
                                                        }
                                        else{
                                                $(".lo_drop").hide();
                                        }
                                    return false;
                                                 });
                                                          $('.lo_drop').click(function(e) {
                                                e.stopPropagation();
                                                        });
                                                $(document).click(function() {
                                                                if (!$(".lo_drop").is(':hidden')){
                                                $('.lo_drop').hide();
                                                                }
                                                        });
                          $(".position_name").text($("#emp_position option:selected").text());
                          
                          jQuery(document).on("click","#submit_basicpay",function(){
                                if($("#basic_pay").val().trim()=="")
                                {
                                    $(".succ_basicpay").text("");
                                    $(".err_basicpay").text("Field Required");
                                    return false;
                                }
                                if(!/^\s*$/.test($("#basic_pay").val()) && !isNaN($("#basic_pay").val()))
                                {
                                    $(".loader_basic_pay").css({'display':'inline'});
                                    var dataString = 'position_id='+$("#emp_position option:selected").val()+'&basic_pay='+$("#basic_pay").val();
                                    var url = "<?php echo base_url('/payroll/save_basic_pay');?>";
                                    $.ajax({
                                        type: "POST",
                                        url: url,
                                        data: dataString, // serializes the form's elements.
                                        success: function()
                                        {
                                            $(".loader_basic_pay").css({'display':'none'});
                                            $(".err_basicpay").text("");
                                            $(".succ_basicpay").text("Saved");
                                            setTimeout(function(){$(".succ_basicpay").text("")},3000);
                                        }
                                      });
                                }
                                else
                                {
                                    $(".succ_basicpay").text("");
                                    $(".err_basicpay").text("Invalid input");
                                }

                             return false; // avoid to execute the actual submit of the form. 
                          });
                          
                          jQuery(document).on("click","#submit_benefits",function(){
                                var i;
                                var err_flag = 0;
                                var benefits_id=[];
                                var benefits_name=[];
                                var benefits_amt=[];
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
                                if(err_flag == 1)
                                    return false;
                                else
                                {
                                    $(".loader_benefits").css({'display':'inline'});
                                    var dataString = 'position_id='+$("#emp_position option:selected").val()+'&benefits_id='+JSON.stringify(benefits_id)+'&benefits_name='+JSON.stringify(benefits_name)+'&benefits_amt='+JSON.stringify(benefits_amt);
                                    var url = "<?php echo base_url('/payroll/save_benefits');?>";
                                    $.ajax({
                                        type: "POST",
                                        url: url,
                                        data: dataString, // serializes the form's elements.
                                        success: function()
                                        {
                                            window.location.href = "<?php echo base_url('/payroll/position');?>"+"/?p="+$("#emp_position option:selected").val();
                                        }
                                      });
                                    return false;
                                }
                          });
                          
                          jQuery(document).on("click","#add_benefit",function(){
                                var structure = '<tr class="benefits_tr">'+
                                                    '<td style="width:20px; text-align: center; font-weight: bold;"><a class="benefit_remove">x</a></td>'+
                                                    '<td style="width:150px;"><input type="text" class="benefit_name" value="" placeholder="Enter benefit name" /></td>'+
                                                    '<td style="width:420px;"><input type="text" class="benefit_amt" value="" placeholder="Enter benefit amount" />&nbsp;&nbsp;&nbsp;INR&nbsp;&nbsp;&nbsp;<span class="err err_benefits"></span></td>'+
                                                    '<td><input type="hidden" class="benefit_id" value="" /></td>'+
                                                '</tr>';
                                jQuery(".benefits_table").append(structure);
                                jQuery("#submit_benefits").css({'display':'inline-block'});
                          });
                          
                          
                          jQuery(document).on("click","#submit_deductions",function(){
                                var i;
                                var err_flag = 0;
                                var deductions_id=[];
                                var deductions_name=[];
                                var deductions_amt=[];
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
                                    $(".loader_deductions").css({'display':'inline'});
                                    var dataString = 'position_id='+$("#emp_position option:selected").val()+'&deductions_id='+JSON.stringify(deductions_id)+'&deductions_name='+JSON.stringify(deductions_name)+'&deductions_amt='+JSON.stringify(deductions_amt);
                                    var url = "<?php echo base_url('/payroll/save_deductions');?>";
                                    $.ajax({
                                        type: "POST",
                                        url: url,
                                        data: dataString, // serializes the form's elements.
                                        success: function()
                                        {
                                            window.location.href = "<?php echo base_url('/payroll/position');?>"+"/?p="+$("#emp_position option:selected").val();
                                        }
                                      });
                                    return false;
                                }
                          });
                          
                          jQuery(document).on("click","#add_deduction",function(){
                                var structure = '<tr class="deductions_tr">'+
                                                    '<td style="width:20px; text-align: center; font-weight: bold;"><a class="deduction_remove">x</a></td>'+
                                                    '<td style="width:150px;"><input type="text" class="deduction_name" value="" placeholder="Enter deduction name" /></td>'+
                                                    '<td style="width:420px;"><input type="text" class="deduction_amt" value="" placeholder="Enter deduction amount" />&nbsp;&nbsp;&nbsp;INR&nbsp;&nbsp;&nbsp;<span class="err err_deductions"></span></td>'+
                                                    '<td><input type="hidden" class="deduction_id" value="" /></td>'+
                                                '</tr>';
                                jQuery(".deductions_table").append(structure);
                                jQuery("#submit_deductions").css({'display':'inline-block'});
                          });
                          
                          
                        });
                </script>
        </head>
	
	<body>
        <div class="wrapper">
	<div class="header">
            <div class="lo_drop">
               <div class="lo_name">
                       Admin            <span>Administrator</span>
               </div>
                <ul>
                    <li><a href="<?php echo base_url('../?r=message');?>">My Account</a></li>
                    <li><a href="<?php echo base_url('../?r=configurations/create');?>">Preference</a></li>
                    <li> <a href="<?php echo base_url('../?r=site/logout');?>">Logout</a></li>
                </ul>
            </div>
            <div class="logo"><a href="<?php echo base_url();?>"></a> </div>
            <div class="logo_right">
                <div class="searchbx">
			<form action="<?php echo base_url('../?r=site/search');?>" name="search" method="post">
                            <ul>
                                <li>
                                    <input class="searchbar" name="char" type="text">
                                </li>
                                <li>
                                    <input src="<?php echo base_url('../images/search.png');?>" type="image" name="555" value="submit">
                                </li>
                            </ul>
                        </form>  
                </div>
                <div class="hdr_sepratr"></div>
                <div class="mssgbx">
                    <div id="status-bar">
                        <ul id="status-infos" style="list-style:none; padding:0px;">
                            <li>
                                    <a href="<?php echo base_url('../?r=message');?>" class="mssgimg" title=" Unread Message(s)"></a>
                                   <!--<div class="mssg_nmbr"><span>--><!--</span></div>-->
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="usernamebx">
                    <ul>
                    	<li>
                            <img src="<?php echo base_url('../images/user.png');?>" width="35" height="29">
                        </li>
                        <li>
                            <a href="#" id="lodrop">Admin</a>
                        </li>
                    </ul>
                </div>
               
            </div>
        </div>
            
        <div class="navigation_wrapper">
            <div class="nav">
        	<ul>
                    <li>
                        <a class="ic1" href="<?php echo base_url('../?r=message');?>">Home</a>
                    <li>
                    <li>
                        <a class="ic2" href="<?php echo base_url('../?r=students');?>">Students</a>                
                    </li>
                    <li>
                        <a class="ic3" href="<?php echo base_url('../?r=employees');?>">Employees</a>          
                    </li>
                    <li>
                        <a class="ic9" href="<?php echo base_url('../?r=courses');?>">Classes</a>                 
                    </li>
                    <li>
                        <a class="ic10" href="<?php echo base_url('../?r=financeFeeCategories');?>">Fees</a>                 
                    </li>
                    <li>
                        <a class="ic11 active" href="<?php echo base_url();?>">Payroll</a>                
                    </li>
                    <li>
                        <a class="ic8" href="<?php echo base_url('../?r=configurations');?>">Settings</a>                 
                    </li>
                    <!--<li>
                        <a class="ic12" href="< ?php echo base_url('../install.php');?>">Install</a>                        
                    </li>-->

                </ul>
            </div>
        </div>
            
        <div class="container">
            <div id="content">
                <div class="span-19">
                    <div id="content">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tbody><tr>
                                <td width="247" valign="top">
                                    <div id="othleft-sidebar">
                                        <ul id="yw0">
                                            <li id="menu_1">
                                                <a class="menu_1" href="<?php echo base_url('payroll');?>">Setup Payroll<span>Setup position based payroll</span></a>
                                            </li>
                                            <li id="menu_2">
                                                <a class="menu_2" href="<?php echo base_url('payroll/salary');?>">Calculate Salary<span>Calculate salary based on positions</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                