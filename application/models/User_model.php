<?php
class User_model extends CI_Model {
    public function check_login($username, $password) {
        $user = $this->db->get_where('users', ['username' => $username])->row();
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return false;
    }
    public function addUser($data) {
        $this->db->insert('users', $data);
        return true;
    }
    public function get_all_users() {
        return $this->db->get('users')->result(); 
    }
    
}
?>