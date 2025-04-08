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

    public function insert($data) {
        return $this->db->insert('tasks', $data);
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update('tasks', $data);
    }

    public function delete($id) {
        return $this->db->delete('tasks', ['id' => $id]);
    }
}
?>