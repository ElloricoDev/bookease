<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookEase • Admin Dashboard</title>
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
        <h2>Dashboard</h2>

        <div class="stats">
          <div class="stat">
            <div class="stat-title">📑 Total Books</div>
            <div class="stat-value">500</div>
          </div>
          <div class="stat">
            <div class="stat-title">🟢 Borrowed Books</div>
            <div class="stat-value">125</div>
          </div>
          <div class="stat">
            <div class="stat-title">🧑 Registered Users</div>
            <div class="stat-value">400</div>
          </div>
          <div class="stat">
            <div class="stat-title">🔴 Overdue Books</div>
            <div class="stat-value">12</div>
          </div>
        </div>

        <div class="charts">
          <div class="chart-card">
            <div class="chart-title">Books Borrowed per Month</div>
            <svg id="barChart" viewBox="0 0 320 180" aria-label="Borrowed per month"></svg>
          </div>
          <div class="chart-card">
            <div class="chart-title">Books by Category</div>
            <svg id="pieChart" viewBox="0 0 220 180" aria-label="Books by Category"></svg>
            <ul class="legend">
              <li><span class="lg lg-fic"></span>Fiction</li>
              <li><span class="lg lg-nfic"></span>Non-Fiction</li>
              <li><span class="lg lg-sci"></span>Science</li>
              <li><span class="lg lg-his"></span>History</li>
            </ul>
          </div>
        </div>

        <div class="recent">
          <div class="recent-title">Recent Activity</div>
          <div class="recent-grid">
            <div>Nikko Rey Arguelles borrowed Crime and Punishment</div>
            <div>Linool Salvador Dugenio returned El Filibusterismo</div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
