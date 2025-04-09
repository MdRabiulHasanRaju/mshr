<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .badge-low { background-color: #8c7b30; }
        .badge-medium { background-color: orange; }
        .badge-high { background-color: tomato; }
        .badge-pending { background-color: red; }
        .badge-progress { background-color: #cd8546; }
        .badge-done { background-color: green; }
    </style>
</head>
<body>
<div class="container my-5">
    <h2 class="text-center mb-4">Task Manager</h2>
    <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-success" onclick="$('#taskModal').modal('show')">+ Add Task</button>
        <a href="<?= base_url('auth/logout') ?>" class="btn btn-outline-danger">Logout</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-light">
            <tr>
                <th>Title</th>
                <th>Priority</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($tasks as $task): ?>
                <tr>
                    <td><?= $task->title ?></td>
                    <td>
                        <span class="badge 
                            <?= $task->priority === 'high' ? 'badge-high' : '' ?>
                            <?= $task->priority === 'medium' ? 'badge-medium' : '' ?>
                            <?= $task->priority === 'low' ? 'badge-low' : '' ?>">
                            <?= ucfirst($task->priority) ?>
                        </span>
                    </td>
                    <td><?= $task->due_date ?></td>
                    <td>
                        <span class="badge 
                            <?= $task->status === 'pending' ? 'badge-pending' : '' ?>
                            <?= $task->status === 'inprogress' ? 'badge-progress' : '' ?>
                            <?= $task->status === 'done' ? 'badge-done' : '' ?>">
                            <?php
                                if($task->status === 'inprogress'){
                                echo ucfirst(substr($task->status,0,2))." ";
                                echo ucfirst(substr($task->status,2));
                                }else{
                                echo ucfirst($task->status);
                                }
                            ?>
                        </span>
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-info" onclick="viewTask(<?= $task->id ?>)">View</button>
                            
                            <button class="btn btn-sm btn-primary" onclick="editTask(<?= $task->id ?>, '<?= $task->title ?>', '<?= $task->description ?>', '<?= $task->priority ?>', '<?= $task->due_date ?>', '<?= $task->status ?>')">Edit</button>

                            <?php if ($this->session->userdata('role') === 'admin'): ?>
                                <button class="btn btn-sm btn-danger" onclick="deleteTask(<?= $task->id ?>)">Delete</button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Task Modal -->
<div class="modal fade" id="taskModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="taskForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add/Edit Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="task_id" id="task_id">
        <input type="text" name="title" id="title" class="form-control mb-2" placeholder="Title" required>
        <textarea name="description" id="description" class="form-control mb-2" placeholder="Description"></textarea>
        <select name="priority" id="priority" class="form-select mb-2">
          <option value="low">Low</option>
          <option value="medium">Medium</option>
          <option value="high">High</option>
        </select>
        <input type="date" name="due_date" id="due_date" class="form-control mb-2">
        <select name="status" id="status" class="form-select">
          <option value="pending">Pending</option>
          <option value="inprogress">In Progress</option>
          <option value="done">Done</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </form>
  </div>
</div>

<!-- View Task Modal -->
<div class="modal fade" id="viewTaskModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">View Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h6><strong>Title:</strong> <span id="view-title"></span></h6>
        <p><strong>Description:</strong> <span id="view-description"></span></p>
        <p><strong>Priority:</strong> <span id="view-priority"></span></p>
        <p><strong>Due Date:</strong> <span id="view-due-date"></span></p>
        <p><strong>Status:</strong> <span id="view-status"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function viewTask(id) {
    $.ajax({
        url: '<?= base_url("tasks/view/") ?>' + id,
        method: 'GET',
        dataType: 'json',
        success: function(res) {
            if (res.status === 'success') {
                $('#view-title').text(res.task.title);
                $('#view-description').text(res.task.description);
                $('#view-priority').text(res.task.priority);
                $('#view-due-date').text(res.task.due_date);
                $('#view-status').text(res.task.status);
                new bootstrap.Modal(document.getElementById('viewTaskModal')).show();
            } else {
                alert('Error fetching task details');
            }
        },
        error: function() {
            alert('Error fetching task details');
        }
    });
}

function editTask(id, title, desc, priority, due, status) {
    $('#task_id').val(id);
    $('#title').val(title);
    $('#description').val(desc);
    $('#priority').val(priority);
    $('#due_date').val(due);
    $('#status').val(status);
    new bootstrap.Modal(document.getElementById('taskModal')).show();
}

$('#taskForm').submit(function(e){
    e.preventDefault();
    let id = $('#task_id').val();
    let url = id ? '<?= base_url("tasks/update/") ?>'+id : '<?= base_url("tasks/store") ?>';
    $.post(url, $(this).serialize(), function(res){
        if (res.status === 'success' || res.status === 'updated') {
            location.reload();
        }
    }, 'json');
});

function deleteTask(id) {
    if (confirm("Are you sure?")) {
        $.get('<?= base_url("tasks/delete/") ?>' + id, function(res) {
            if (res.status === 'deleted') location.reload();
        }, 'json');
    }
}
</script>
</body>
</html>
