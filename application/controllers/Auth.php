<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function index()
    {
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'password', 'trim|required');
        
        
        if ($this->form_validation->run() == FALSE) {
        $this->load->view('header/auth_header');
        $this->load->view('v_login');
        $this->load->view('header/auth_footer');
        } else {
        $this->_login();
        }

        
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $this->db->where('email', $email);
        $user = $this->db->get('admin')->row_array();
        if ($user) {
           if (password_verify($password,$user['password'])) {
               $data = array(
                   'email' => $user['email'],
                   'customer' => $user['customer']
                 );
                 
                 $this->session->set_userdata( $data);
                 redirect('monitoring');
           }else{
               $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">password salah</div>');
            redirect('auth');
           }
        }else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">email tidak terdaftar</div>');
            redirect('auth');
            
        }
        
    }

    public function logout()
    {
        
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('customer');
        redirect('monitoring');
        
    }

}

/* End of file Controllername.php */