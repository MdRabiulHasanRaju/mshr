<!DOCTYPE html>
<html>
<head>
    <title>Admin - Manage All Tasks</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
<body class="container mt-5">
<h2>Admin Panel - All Tasks</h2>
<div class="d-flex justify-content-between align-items-center my-3 gap-3">
    <div class="d-flex gap-1">
      <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-success">Users List</a>

      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">+ Add New User</button>
    </div>
    <div class="d-flex gap-1">
      <button class="btn btn-success" onclick="$('#taskModal').modal('show')">+ Add Task</button>
      <a href="<?= base_url('auth/logout') ?>" class="btn btn-outline-danger">Logout</a>
    </div>
</div>

<div class="table-responsive">
<form method="get" class="mb-3">
  <div class="row">
    <div class="col-md-6">
    <label for="user_filter" class="form-label">Filter by User:</label>
    <select name="user_id" id="user_filter" class="form-select" onchange="this.form.submit()">
      <option value="">All Users</option>
      <?php foreach($users as $user): ?>
        <option value="<?= $user->id ?>" <?= isset($_GET['user_id']) && $_GET['user_id'] == $user->id ? 'selected' : '' ?>>
          <?= ucfirst($user->username) ?>
        </option>
      <?php endforeach; ?>
    </select>
    </div>

    <div class="col-md-6">
        <label for="status_filter" class="form-label">Filter by Status:</label>
        <select name="status" id="status_filter" class="form-select" onchange="this.form.submit()">
          <option value="">All Status</option>
          <option value="pending" <?= isset($_GET['status']) && $_GET['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
          <option value="inprogress" <?= isset($_GET['status']) && $_GET['status'] == 'inprogress' ? 'selected' : '' ?>>In Progress</option>
          <option value="done" <?= isset($_GET['status']) && $_GET['status'] == 'done' ? 'selected' : '' ?>>Done</option>
        </select>
      </div>
  </div>
</form>

<table class="table table-bordered table-striped align-middle">
<thead class="table-dark">
    <tr>
        <th>User</th>
        <th>Title</th>
        <th>Priority</th>
        <th>Assign Date</th>
        <th>Deadline</th>
        <th>Status</th>
        <th>Last Update</th>
        <th>Actions</th>
    </tr>
</thead>
<tbody>
<?php foreach($all_tasks as $task): ?>
<tr>
    <td><?= ucfirst($task->username ?? 'Unknown') ?></td>
    <td><?= $task->title ?></td>
    <td>
        <span class="badge 
            <?= $task->priority === 'high' ? 'badge-high' : '' ?>
            <?= $task->priority === 'medium' ? 'badge-medium' : '' ?>
            <?= $task->priority === 'low' ? 'badge-low' : '' ?>">
            <?= ucfirst($task->priority) ?>
        </span>
    </td>
    <td><?= date("F j, Y, g:i a",strtotime($task->created_at)); ?></td>
    <td><?= date("F j, Y, g:i a",strtotime($task->due_date)); ?></td>
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
    <td><?= date("F j, Y, g:i a",strtotime($task->updated_at)); ?></td>
    <td>
        <button class="btn btn-sm btn-info" onclick="viewTask(<?= $task->id ?>)">View</button>

        <button class="btn btn-sm btn-primary"
        onclick="editTask(<?= $task->id ?>, '<?= $task->title ?>', '<?= $task->description ?>', '<?= $task->priority ?>', '<?= $task->due_date ?>', '<?= $task->status ?>', <?= $task->user_id ?>)">Edit</button>


        <button class="btn btn-sm btn-danger" onclick="deleteTask(<?= $task->id ?>)">Delete</button>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
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

        <div class="mb-2">
          <label for="assign_user" class="form-label">Assign to User</label>
          <select name="user_id" id="assign_user" class="form-select" required>
            <option value="">-- Select User --</option>
            <?php foreach($users as $user): ?>
              <option value="<?= $user->id ?>"><?= $user->username ?></option>
            <?php endforeach; ?>
          </select>
        </div>

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
        <h6><strong>Topic:</strong> <span id="view-title"></span></h6>
        <p><strong>Description:</strong> <span id="view-description"></span></p>
        <p><strong>Priority:</strong> <span id="view-priority"></span></p>
        <p><strong>Deadline:</strong> <span id="view-due-date"></span></p>
        <p><strong>Status:</strong> <span id="view-status"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Adding New User -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addUserForm">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" id="role" name="role" required>
              <option value="user">User</option>
              <option value="admin">Admin</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Add User</button>
        </form>
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

function editTask(id, title, desc, priority, due, status, user_id) {
    $('#task_id').val(id);
    $('#title').val(title);
    $('#description').val(desc);
    $('#priority').val(priority);
    $('#due_date').val(due);
    $('#status').val(status);
    $('#assign_user').val(user_id);
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

$('#addUserForm').submit(function(e) {
      e.preventDefault();  

      // Get form data
      var formData = $(this).serialize();

      $.ajax({
        url: '<?= base_url("admin/addUser") ?>',  
        type: 'POST',
        data: formData,
        success: function(response) {
          response = JSON.parse(response)
          if (response.status === 'success') {
            alert('User added successfully!');
            location.reload();  
          } else {
            alert(response);
          }
        },
        error: function() {
          alert('Something went wrong. Please try again.');
        }
      });
    });
</script>
</body>
</html>
