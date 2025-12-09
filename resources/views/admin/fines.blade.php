<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookEase • Fine Management</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
  <header class="user-header-light">
        <div class="nav-inner">
            <a href="{{ url('/user/home') }}" class="brand">BookEase</a>

            <nav>
                 <a href="#" class="settings-icon" title="Settings">⚙️</a>
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
        <h2>Fine Management</h2>

        <div class="table-toolbar">
          <div class="search-wrap">
            <input type="search" placeholder="Search by User or Book">
          </div>
          <a href="#" class="btn primary">+ Add Fine</a>
        </div>

        <div class="table-wrap">
          <table class="table">
            <thead>
              <tr>
                <th>User</th>
                <th>Book Title</th>
                <th>Due Date</th>
                <th>Return</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Nikko</td>
                <td>Hunger Games</td>
                <td>2025-02-08</td>
                <td>2025-02-12</td>
                <td>Unpaid</td>
                <td><button class="icon-btn">🗑️</button></td>
              </tr>
              <tr>
                <td>Linoel</td>
                <td>Harry Potter</td>
                <td>2025-08-01</td>
                <td>2025-08-08</td>
                <td>Paid</td>
                <td><button class="icon-btn">🗑️</button></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>

  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
