<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookEase • Notifications</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <!-- Header -->
 <header class="user-header-light">
        <div class="nav-inner">
            <a href="{{ url('/user/home') }}" class="brand">BookEase</a>

            <nav>
                 <a href="#" class="settings-icon" title="Settings">⚙️</a>
        </div>
    </header> 

  <!-- Dashboard Layout -->
  <div class="dashboard-layout">
    <!-- Sidebar -->
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

    <!-- Main Content -->
    <main class="dashboard-main">
      <div class="panel">
        <h2>Notifications</h2>

        <div class="list" id="notifList">
          <div class="list-item">
            <button class="icon-btn" data-notif-delete>🗑️</button>
            Linoel returned Harry Potter <span class="muted">10m</span>
          </div>
          <div class="list-item">
            <button class="icon-btn" data-notif-delete>🗑️</button>
            Nikko borrowed Hunger Games <span class="muted">20m</span>
          </div>
          <div class="list-item">
            <button class="icon-btn" data-notif-delete>🗑️</button>
            Cyril borrowed The Great Gatsby <span class="muted">30m</span>
          </div>
          <div class="list-item">
            <button class="icon-btn" data-notif-delete>🗑️</button>
            Zildjian borrowed Sapiens <span class="muted">50m</span>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script src="js/script.js"></script>
</body>
</html>
