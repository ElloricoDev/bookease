<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookEase • Borrow and Return</title>
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
        <h2>Borrow and Return</h2>

        <div class="table-toolbar">
          <div class="search-wrap">
            <input type="search" placeholder="Search by Name, Email, or ID">
            <button class="btn small">Filter</button>
          </div>
          <a class="btn primary" href="#">+ Add</a>
        </div>

        <div class="table-wrap">
          <table class="table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Book</th>
                <th>Due Date</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Nikko Rey Arguelles</td>
                <td>Fundamentals of Programming</td>
                <td>2025-05-15</td>
                <td><button class="pill pill-blue">Borrowed</button></td>
              </tr>
              <tr>
                <td>Linool Salvador Dugenio</td>
                <td>El Filibusterismo</td>
                <td>2025-05-21</td>
                <td><button class="pill pill-green" disabled>Returned</button></td>
              </tr>
              <tr>
                <td>Cyril Josh P. Roselim</td>
                <td>Science Experiments</td>
                <td>2025-05-10</td>
                <td><button class="pill pill-blue">Borrowed</button></td>
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
