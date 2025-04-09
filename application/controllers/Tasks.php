<?php
class Tasks extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Task_model');
        $this->load->library('session');
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $filters = $this->input->get();
        $data['tasks'] = $this->Task_model->get_tasks($this->session->userdata('user_id'), $filters);
        $this->load->view('tasks/index', $data);
    }

    public function view($id) {
        // Ensure the ID is valid
        if (empty($id) || !is_numeric($id)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid task ID']);
            return;
        }

        // Fetch the task details
        $task = $this->Task_model->get($id);
        
        if ($task) {
            // Return task data as JSON
            echo json_encode(['status' => 'success', 'task' => $task]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Task not found']);
        }
    }
    

    public function store() {
        if($this->input->post('user_id')){
            $userId = $this->input->post('user_id');
        }else{
            $userId = $this->session->userdata('user_id');
        }
        $this->Task_model->insert([
            'user_id' => $userId,
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'priority' => $this->input->post('priority'),
            'due_date' => $this->input->post('due_date')
        ]);
        echo json_encode(['status' => 'success']);
    }

    public function update($id) {
        if($this->input->post('user_id')){
            $userId = $this->input->post('user_id');
        }else{
            $userId = $this->session->userdata('user_id');
        }
        $this->Task_model->update($id, [
            'user_id' => $userId,
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'priority' => $this->input->post('priority'),
            'due_date' => $this->input->post('due_date'),
            'status' => $this->input->post('status')
        ]);
        echo json_encode(['status' => 'success']);
    }

    // public function delete($id) {
    //     $this->Task_model->delete($id);
    //     echo json_encode(['status' => 'deleted']);
    // }

    public function delete($id)
    {
        if ($this->session->userdata('role') !== 'admin') {
            echo json_encode(['status' => 'unauthorized']);
            return;
        }

        $this->Task_model->delete($id);
        echo json_encode(['status' => 'deleted']);
    }


    

}
?>