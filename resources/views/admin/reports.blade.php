<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookEase • Reports</title>
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
      <<a class="side-link side-logout" href="{{ route ('login')}}">Sign out</a>
    </aside>

    <main class="dashboard-main">
      <div class="panel">
        <h2>Reports</h2>

        <div class="table-toolbar">
          <div class="search-wrap">
            <input type="search" placeholder="Search reports">
          </div>
        </div>

        <div class="charts">
          <div class="chart-card">
            <div class="chart-title">Books Borrowed Reports</div>
            <svg id="reportsChart1" viewBox="0 0 320 160"></svg>
          </div>
          <div class="chart-card">
            <div class="chart-title">Overdue Books Reports</div>
            <svg id="reportsChart2" viewBox="0 0 320 160"></svg>
          </div>
          <div class="chart-card">
            <div class="chart-title">User Activity Reports</div>
            <svg id="reportsChart3" viewBox="0 0 320 160"></svg>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
