<?php
class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('User_model');
        $this->load->library('session');
    }
  
    public function login() {
        if ($_POST) {
            $user = $this->User_model->check_login($this->input->post('username'), $this->input->post('password'));
            if ($user) {
                $this->session->set_userdata('user_id', $user->id);
                redirect('tasks');
            } else {
                $data['error'] = 'Invalid username or password';
            }
        }
        $this->load->view('auth/login', $data ?? []);
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}

?>