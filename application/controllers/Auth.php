<?php
class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('User_model');
        $this->load->library('session');
    }
  
    public function login()
    {
        $this->load->model('User_model');
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->User_model->check_login($this->input->post('username'), $this->input->post('password'));
            
            if ($user) {
                $this->session->set_userdata([
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'role' => $user->role, 
                    'logged_in' => true
                ]);
                if ($user->role === 'admin') {
                    redirect('tasks/admin'); 
                } else {
                    redirect('tasks');
                }
            } else {
                $error = 'Invalid credentials';
            }
        }
    
        $this->load->view('auth/login', ['error' => $error]);
    }

    public function logout() {
        $this->session->unset_userdata('user_id');
        redirect('auth/login');
    }
    
}

?>