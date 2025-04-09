<?php
class Task_model extends CI_Model {
    public function get_tasks($user_id, $filters = []) {
        $this->db->where('user_id', $user_id);
        if (!empty($filters['status'])) {
            $this->db->where('status', $filters['status']);
        }
        if (!empty($filters['priority'])) {
            $this->db->where('priority', $filters['priority']);
        }
        if (!empty($filters['sort'])) {
            $this->db->order_by($filters['sort'], 'ASC');
        }
        return $this->db->get('tasks')->result();
    }
    public function get($id) {
        $query = $this->db->get_where('tasks', ['id' => $id]);
        return $query->row();  // Return the task as an object or null if not found
    }
    

    public function insert($data) {
        return $this->db->insert('tasks', $data);
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update('tasks', $data);
    }

    public function delete($id) {
        return $this->db->delete('tasks', ['id' => $id]);
    }
    public function get_all_tasks_with_users()
    {
        $this->db->select('tasks.*, users.username');
        $this->db->from('tasks');
        $this->db->join('users', 'users.id = tasks.user_id');
        return $this->db->get()->result();
    }
    public function getTasksByFilter($user_id,$status){
        $this->db->select('tasks.*, users.username');
        $this->db->from('tasks');
        $this->db->join('users', 'users.id = tasks.user_id');
        if(!empty($user_id)){
            $this->db->where('tasks.user_id', $user_id);
        }
        if(!empty($status)){
            $this->db->where('tasks.status', $status);
        }
        return $this->db->get()->result();
    }

}
?>