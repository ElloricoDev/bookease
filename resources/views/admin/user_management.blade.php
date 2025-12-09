<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookEase • User Management</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    .modal { display: none; position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); justify-content:center; align-items:center; }
    .modal-content { background:#fff; padding:20px; border-radius:5px; width:400px; max-width:90%; }
    .modal-header { display:flex; justify-content:space-between; align-items:center; }
    .modal-close { cursor:pointer; font-size:1.2rem; }
    .modal.show { display:flex; }
    .form-group { margin-bottom:15px; }
    .form-group label { display:block; margin-bottom:5px; }
    .form-group input, .form-group select { width:100%; padding:8px; box-sizing:border-box; }
  </style>
</head>
<body class="user-page">

<header class="user-header-light">
  <div class="nav-inner">
    <a href="{{ url('/user/home') }}" class="brand">BookEase</a>
    <nav>
      <a href="#" class="settings-icon" title="Settings">⚙️</a>
    </nav>
  </div>
</header> 

<div class="dashboard-layout">
  <aside class="sidebar">
    <a class="side-link" href="{{ route ('dashboard')}}">Dashboard</a>
    <a class="side-link" href="{{ route ('user_management')}}">User Management</a>
    <a class="side-link" href="{{ route ('book_management')}}">Book Management</a>
    <a class="side-link" href="{{ route ('borrow_return')}}">Borrow and return</a>
    <a class="side-link" href="{{ route ('fines')}}">Fine Management</a>
    <a class="side-link" href="{{ route ('reports')}}">Reports</a>
    <a class="side-link" href="{{ route ('notifications')}}">Notifications</a>
    <a class="side-link side-logout" href="{{ route ('login')}}">Sign out</a>
  </aside>

  <main class="dashboard-main">
    <div class="panel">
      <h2>User Management</h2>

      <div class="table-toolbar">
        <div class="search-wrap">
          <input type="search" id="userSearch" placeholder="Search by Name, Email, or ID">
          <button class="btn small" id="filterBtn">Filter</button>
        </div>
        <button class="btn primary" id="addUserBtn">+ Add User</button>
      </div>

      <div class="table-wrap">
        @if(session('success'))
          <div class="alert success">{{ session('success') }}</div>
        @endif

        <table class="table" id="usersTable">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
            <tr 
              data-id="{{ $user->id }}" 
              data-name="{{ $user->name }}" 
              data-email="{{ $user->email }}" 
              data-role="{{ $user->role }}"
            >
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ ucfirst($user->role) }}</td>
              <td>{{ $user->role === 'admin' ? 'Admin' : 'Active' }}</td>
              <td>
                <button class="btn small edit-btn">✏️ Edit</button>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button class="icon-btn" type="submit">🗑️ Delete</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </main>
</div>

<!-- Add User Modal -->
<div class="modal" id="addUserModal">
  <div class="modal-content">
    <div class="modal-header">
      <h3>Add User</h3>
      <span class="modal-close">&times;</span>
    </div>
    <form action="{{ route('users.store') }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="addName">Name</label>
        <input type="text" id="addName" name="name" required>
      </div>
      <div class="form-group">
        <label for="addEmail">Email</label>
        <input type="email" id="addEmail" name="email" required>
      </div>
      <div class="form-group">
        <label for="addRole">Role</label>
        <select id="addRole" name="role" required>
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>
      </div>
      <div class="form-group">
        <label for="addPassword">Password</label>
        <input type="password" id="addPassword" name="password" required>
      </div>
      <div class="form-group">
        <label for="addPasswordConfirmation">Confirm Password</label>
        <input type="password" id="addPasswordConfirmation" name="password_confirmation" required>
      </div>
      <button class="btn primary" type="submit">Add User</button>
    </form>
  </div>
</div>

<!-- Edit User Modal -->
<div class="modal" id="editUserModal">
  <div class="modal-content">
    <div class="modal-header">
      <h3>Edit User</h3>
      <span class="modal-close">&times;</span>
    </div>
    <form id="editUserForm" method="POST">
      @csrf
      @method('PUT')
      <div class="form-group">
        <label for="editName">Name</label>
        <input type="text" id="editName" name="name" required>
      </div>
      <div class="form-group">
        <label for="editEmail">Email</label>
        <input type="email" id="editEmail" name="email" required>
      </div>
      <div class="form-group">
        <label for="editRole">Role</label>
        <select id="editRole" name="role" required>
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>
      </div>
      <button class="btn primary" type="submit">Save Changes</button>
    </form>
  </div>
</div>

<script src="{{ asset('js/script.js') }}"></script>

</body>
</html>
