<!DOCTYPE html>
<html>
<head>
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Custom colors for task priority */
        .badge-low { background-color: #8c7b30; }
        .badge-medium { background-color: orange; }
        .badge-high { background-color: tomato; }

        /* Custom colors for task status */
        .badge-pending { background-color: red; }
        .badge-done { background-color: green; }
    </style>
</head>
<body class="container mt-5">
<h2>Task Manager</h2>
<button class="btn btn-success mb-3" onclick="$('#taskModal').modal('show')">+ Add Task</button>
<table class="table table-bordered">
<thead>
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
        <!-- Priority Badge -->
        <span class="badge 
            <?= $task->priority === 'high' ? 'badge-high' : '' ?>
            <?= $task->priority === 'medium' ? 'badge-medium' : '' ?>
            <?= $task->priority === 'low' ? 'badge-low' : '' ?>">
            <?= ucfirst($task->priority) ?>
        </span>
    </td>
    <td><?= $task->due_date ?></td>
    <td>
        <!-- Status Badge -->
        <span class="badge 
            <?= $task->status === 'pending' ? 'badge-pending' : '' ?>
            <?= $task->status === 'done' ? 'badge-done' : '' ?>">
            <?= ucfirst($task->status) ?>
        </span>
    </td>
    <td>
        <button class="btn btn-sm btn-info" onclick="viewTask(<?= $task->id ?>)">View</button>
        <button class="btn btn-sm btn-primary" onclick="editTask(<?= $task->id ?>, '<?= $task->title ?>', '<?= $task->description ?>', '<?= $task->priority ?>', '<?= $task->due_date ?>', '<?= $task->status ?>')">Edit</button>
        <button class="btn btn-sm btn-danger" onclick="deleteTask(<?= $task->id ?>)">Delete</button>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<!-- Modal -->
<div class="modal" id="taskModal">
  <div class="modal-dialog">
    <form id="taskForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add/Edit Task</h5>
      </div>
      <div class="modal-body">
        <input type="hidden" name="task_id" id="task_id">
        <input type="text" name="title" id="title" class="form-control mb-2" placeholder="Title">
        <textarea name="description" id="description" class="form-control mb-2" placeholder="Description"></textarea>
        <select name="priority" id="priority" class="form-select mb-2">
          <option value="low">Low</option>
          <option value="medium">Medium</option>
          <option value="high">High</option>
        </select>
        <input type="date" name="due_date" id="due_date" class="form-control mb-2">
        <select name="status" id="status" class="form-select">
          <option value="pending">Pending</option>
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

<!-- Modal for Viewing Task -->
<div class="modal" id="viewTaskModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">View Task</h5>
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
        url: '<?= base_url("tasks/view/") ?>' + id,  // Send a GET request to view the task details
        method: 'GET',
        dataType: 'json',
        success: function(res) {
            if (res.status === 'success') {
                // Set the task details in the modal
                $('#view-title').text(res.task.title);
                $('#view-description').text(res.task.description);
                $('#view-priority').text(res.task.priority);
                $('#view-due-date').text(res.task.due_date);
                $('#view-status').text(res.task.status);
                
                // Show the modal
                $('#viewTaskModal').modal('show');
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
    $('#taskModal').modal('show');
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
