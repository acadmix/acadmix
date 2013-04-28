<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payroll extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url','security'));
        $this->load->library('session');
        $this->load->database();
        $this->load->model('Payroll_model');
        
        if(!isset($_COOKIE['payroll_school_id']))
		header("Location: ".base_url("../"));
    }
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
            $data['positions'] = $this->Payroll_model->getPositions();
            if(count($data['positions'])==0)
            {
                $data['payroll_basicpay'] = null;
                $data['payroll_benefits'] = null;
                $data['payroll_deductions'] = null;
            }
            else
            {
                $data['payroll_basicpay'] = $this->Payroll_model->getBasicpay($data['positions'][0]->id);
                $data['payroll_benefits'] = $this->Payroll_model->getBenefits($data['positions'][0]->id);
                $data['payroll_deductions'] = $this->Payroll_model->getDeductions($data['positions'][0]->id);
            }
            
            $this->load->view('payroll_initialize',$data);
	}
        
        public function position()
	{
            if(isset($_GET['p']))
                $position_id = $_GET['p'];
            else
                $position_id = 0;
            $data['positions'] = $this->Payroll_model->getPositions();
            if(count($data['positions'])==0)
            {
                $data['payroll_basicpay'] = null;
                $data['payroll_benefits'] = null;
                $data['payroll_deductions'] = null;
            }
            else
            {
                $data['payroll_basicpay'] = $this->Payroll_model->getBasicpay($position_id);
                $data['payroll_benefits'] = $this->Payroll_model->getBenefits($position_id);
                $data['payroll_deductions'] = $this->Payroll_model->getDeductions($position_id);
            }
            
            $this->load->view('payroll_initialize',$data);
	}
        
        public function save_basic_pay()
        {
            $position_id = $this->input->post('position_id');
            $basic_pay = $this->input->post('basic_pay');
            $this->Payroll_model->save_basic_pay($position_id,$basic_pay);
        }
        
        public function save_benefits()
        {
            $position_id = $this->input->post('position_id');
            $benefits_id = $this->input->post('benefits_id');
            $benefits_name = $this->input->post('benefits_name');
            $benefits_amt = $this->input->post('benefits_amt');
            $this->Payroll_model->save_benefits($position_id,$benefits_id,$benefits_name,$benefits_amt);
            $this->session->set_flashdata('succ_benefits',"Successfully Saved");
        }
        
        public function remove_benefit()
        {
            $position_id = $this->input->post('position_id');
            $benefit_id = $this->input->post('benefit_id');
            $this->Payroll_model->remove_benefit($position_id,$benefit_id);
        }
        
        public function save_deductions()
        {
            $position_id = $this->input->post('position_id');
            $deductions_id = $this->input->post('deductions_id');
            $deductions_name = $this->input->post('deductions_name');
            $deductions_amt = $this->input->post('deductions_amt');
            $this->Payroll_model->save_deductions($position_id,$deductions_id,$deductions_name,$deductions_amt);
            $this->session->set_flashdata('succ_deductions',"Successfully Saved");
        }
        
        public function remove_deduction()
        {
            $position_id = $this->input->post('position_id');
            $deduction_id = $this->input->post('deduction_id');
            $this->Payroll_model->remove_deduction($position_id,$deduction_id);
        }
        
        public function salary()
        {
            $data['positions'] = $this->Payroll_model->getPositions();
            if(count($data['positions'])==0)
            {
                $data['payroll_basicpay'] = null;
                $data['payroll_benefits'] = null;
                $data['payroll_deductions'] = null;
            }
            else
            {
                $data['employees'] = $this->Payroll_model->getEmployees($data['positions'][0]->id);
                $data['payroll_basicpay'] = $this->Payroll_model->getBasicpay($data['positions'][0]->id);
                $data['payroll_benefits'] = $this->Payroll_model->getBenefits($data['positions'][0]->id);
                $data['payroll_deductions'] = $this->Payroll_model->getDeductions($data['positions'][0]->id);
            }
            
            $this->load->view('calculate_salary',$data);
        }
        
        public function employee()
        {
            if(isset($_GET['p']))
                $position_id = $_GET['p'];
            else
                $position_id = 0;
            $data['positions'] = $this->Payroll_model->getPositions();
            if(count($data['positions'])==0)
            {
                $data['payroll_basicpay'] = null;
                $data['payroll_benefits'] = null;
                $data['payroll_deductions'] = null;
            }
            else
            {
                $data['employees'] = $this->Payroll_model->getEmployees($position_id);
                $data['payroll_basicpay'] = $this->Payroll_model->getBasicpay($position_id);
                $data['payroll_benefits'] = $this->Payroll_model->getBenefits($position_id);
                $data['payroll_deductions'] = $this->Payroll_model->getDeductions($position_id);
            }
            $this->load->view('calculate_salary',$data);
            
        }
        
        public function generate_slip()
        {
            $position_id = $this->input->post('position_id');
            $employee_id = $this->input->post('employee_id');
            $basic_pay = $this->input->post('basic_pay');
            $benefits_id = json_decode($this->input->post('benefits_id'));
            $benefits_name = json_decode($this->input->post('benefits_name'));
            $benefits_amt = json_decode($this->input->post('benefits_amt'));
            $deductions_id = json_decode($this->input->post('deductions_id'));
            $deductions_name = json_decode($this->input->post('deductions_name'));
            $deductions_amt = json_decode($this->input->post('deductions_amt'));
            $net = $basic_pay;
            
            $emp_details = $this->Payroll_model->getEmployeeDetails($position_id,$employee_id);
            
            
            $i = 0;
            foreach($benefits_name as $benefit)
            {
                $net += $benefits_amt[$i]; 
                $i++;
            }
            $i = 0;
            foreach($deductions_name as $deduction)
            {
                $net -= $deductions_amt[$i]; 
                $i++;
            }
            $this->Payroll_model->savePayslip($position_id,$employee_id,$net);
 
            
        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */