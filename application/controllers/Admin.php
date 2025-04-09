<?php
class Admin extends CI_Controller {

    public function index()
    {
        if ($this->session->userdata('role') !== 'admin') {
            show_error('Unauthorized access', 403);
        }
    
        $this->load->model('Task_model');
        $data['users'] = $this->db->get('users')->result();
        $data['all_tasks'] = $this->Task_model->get_all_tasks_with_users();
        $this->load->view('admin/admin', $data);
    }

    // Function to handle the addition of a new user
    public function addUser() {
        $this->load->model('User_model');  // Load User model

        // Get form data
        $username = $this->input->post('username');
        $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);  // Hash the password
        $role = $this->input->post('role');

        // Prepare data to insert
        $userData = [
            'username' => $username,
            'password' => $password,
            'role' => $role
        ];

        // Add user to the database
        $userAdded = $this->User_model->addUser($userData);

        // Send response back to AJAX
        if ($userAdded) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function view_all_users() {
        if ($this->session->userdata('role') !== 'admin') {
            show_error('Unauthorized access', 403);
        }
        $this->load->model('User_model');
        $data['users'] = $this->User_model->get_all_users();
        $this->load->view('admin/user_list', $data);
    }
    public function updateUser() {
        $id = $this->input->post('id');
        $data = [
            'username' => $this->input->post('username'),
            'role' => $this->input->post('role')
        ];
        $this->db->where('id', $id)->update('users', $data);
        echo json_encode(['status' => 'success']);
    }
    
    public function deleteUser($id) {
        $this->db->where('id', $id)->delete('users');
        echo json_encode(['status' => 'success']);
    }
    
}

?>