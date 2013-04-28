<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Payroll_model extends CI_Model
{
    public function getPositions()
    {
        return $this->db->get('employee_positions')->result();
    }
    
    public function getBasicpay($pid)
    {
        return $this->db->get_where('payroll_position_basicpay',array('position_id'=>$pid))->row();
    }
    
    public function getBenefits($pid)
    {
        return $this->db->get_where('payroll_position_benefits',array('position_id'=>$pid))->result();
    }

    public function getDeductions($pid)
    {
        return $this->db->get_where('payroll_position_deductions',array('position_id'=>$pid))->result();
    }
    
    public function save_basic_pay($position_id,$basic_pay)
    {
        $this->db->get_where('payroll_position_basicpay',array('position_id'=>$position_id))->row();
        if($this->db->affected_rows()==0)
            $this->db->insert('payroll_position_basicpay',array('position_id'=>$position_id,'basic_pay'=>$basic_pay));
        else
        {
            $this->db->where('position_id', $position_id);
            $this->db->update('payroll_position_basicpay',array('basic_pay'=>$basic_pay));
        }
            
    }
    
    public function save_benefits($position_id,$benefits_id,$benefits_name,$benefits_amt)
    {
        $benefits_id = json_decode($benefits_id);
        $benefits_name = json_decode($benefits_name);
        $benefits_amt = json_decode($benefits_amt);

        $i = 0;
        foreach($benefits_name as $benefit)
        {
            $this->db->get_where('payroll_position_benefits',array('position_id'=>$position_id,'id'=>$benefits_id[$i]))->row();
            if($this->db->affected_rows()==0)
                $this->db->insert('payroll_position_benefits',array('position_id'=>$position_id,'benefit_name'=>$benefits_name[$i],'benefit_amt'=>$benefits_amt[$i]));
            else
            {
                $this->db->where(array('position_id'=>$position_id,'id'=>$benefits_id[$i]));
                $this->db->update('payroll_position_benefits',array('benefit_name'=>$benefits_name[$i],'benefit_amt'=>$benefits_amt[$i]));
            }
            $i++;
        }
    }
    
    public function remove_benefit($position_id,$benefit_id)
    {
        $this->db->where(array('position_id'=>$position_id,'id'=>$benefit_id));
        $this->db->delete('payroll_position_benefits');
    }
    
    public function save_deductions($position_id,$deductions_id,$deductions_name,$deductions_amt)
    {
        $deductions_id = json_decode($deductions_id);
        $deductions_name = json_decode($deductions_name);
        $deductions_amt = json_decode($deductions_amt);

        $i = 0;
        foreach($deductions_name as $deduction)
        {
            $this->db->get_where('payroll_position_deductions',array('position_id'=>$position_id,'id'=>$deductions_id[$i]))->row();
            if($this->db->affected_rows()==0)
                $this->db->insert('payroll_position_deductions',array('position_id'=>$position_id,'deduction_name'=>$deductions_name[$i],'deduction_amt'=>$deductions_amt[$i]));
            else
            {
                $this->db->where(array('position_id'=>$position_id,'id'=>$deductions_id[$i]));
                $this->db->update('payroll_position_deductions',array('deduction_name'=>$deductions_name[$i],'deduction_amt'=>$deductions_amt[$i]));
            }
            $i++;
        }
    }
    
    public function remove_deduction($position_id,$deduction_id)
    {
        $this->db->where(array('position_id'=>$position_id,'id'=>$deduction_id));
        $this->db->delete('payroll_position_deductions');
    }
    
    public function getEmployees($pid)
    {
        return $this->db->get_where('employees',array('employee_position_id'=>$pid))->result();
    }
    
    public function savePayslip($pid,$employee_id,$net)
    {
        $result = $this->db->get_where('employees',array('employee_position_id'=>$pid,'id'=>$employee_id))->row();
        $name = ucfirst($result->first_name)." ".ucfirst($result->middle_name)." ".ucfirst($result->last_name);
        $this->db->insert('individual_payslip_categories',array('employee_id'=>$employee_id,'name'=>$name,'salary_date'=>date('Y-m-d'),'amount'=>$net));
    }
    
    public function getEmployeeDetails($position_id,$employee_id)
    {
        return $this->db->query('select * from employee_positions, employees where employee_positions.id = employees.employee_position_id')->row();
    }
            
}


?>
