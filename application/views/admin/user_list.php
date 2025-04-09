<!DOCTYPE html>
<html>
<head>
    <title>All Registered Users</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="container mt-5">
    <h2>All Registered Users</h2>
    <a href="<?= base_url('admin') ?>" class="btn btn-secondary mb-3">← Back to Admin Panel</a>
<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Actions</th> 
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user->username) ?></td>
                <td><?= $user->email?$user->email:"Null" ?></td>
                <td><?= ucfirst($user->role) ?></td>
                <td><?= date("d-m-Y",strtotime($user->created_at)) ?></td>
                <td>
                    <button class="btn btn-sm btn-primary" onclick="editUser(<?= $user->id ?>, '<?= $user->username ?>','<?= $user->email ?>', '<?= $user->role ?>')">Edit</button>
                    <button class="btn btn-sm btn-danger" onclick="deleteUser(<?= $user->id ?>)">Delete</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
      <div class="modal-dialog">
        <form id="editUserForm" class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="edit_user_id" name="id">
            <div class="mb-3">
              <label for="edit_username" class="form-label">Username</label>
              <input type="text" class="form-control" id="edit_username" name="username" required>
            </div>
            <div class="mb-3">
              <label for="edit_email" class="form-label">Email</label>
              <input type="text" class="form-control" id="edit_email" name="email" required>
            </div>
            <div class="mb-3">
              <label for="edit_role" class="form-label">Role</label>
              <select class="form-select" id="edit_role" name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Update</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editUser(id, username, email, role) {
            $('#edit_user_id').val(id);
            $('#edit_username').val(username);
            $('#edit_email').val(email);
            $('#edit_role').val(role);
            new bootstrap.Modal(document.getElementById('editUserModal')).show();
        }

        $('#editUserForm').submit(function(e) {
            e.preventDefault();
            $.post('<?= base_url("admin/updateUser") ?>', $(this).serialize(), function(response) {
                response = JSON.parse(response);
                if (response.status === 'success') {
                    alert('User updated successfully.');
                    location.reload();
                } else {
                    alert('Failed to update user.');
                }
            });
        });

        function deleteUser(id) {
            if (confirm("Are you sure you want to delete this user?")) {
                $.get('<?= base_url("admin/deleteUser/") ?>' + id, function(response) {
                    response = JSON.parse(response);
                    if (response.status === 'success') {
                        alert('User deleted.');
                        location.reload();
                    } else {
                        alert('Failed to delete user.');
                    }
                });
            }
        }
    </script>
</body>
</html>
