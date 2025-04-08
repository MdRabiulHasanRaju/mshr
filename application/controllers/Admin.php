<?php
// Admin Controller
class Admin extends CI_Controller {

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
}

?>