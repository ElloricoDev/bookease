<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookEase • Account Information</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="user-page">
  <header class="user-header-light">
    <div class="nav-inner">
      <a href="#" class="brand">BookEase</a>
      <div class="header-search">
        <input type="search" placeholder="Search" id="headerSearch">
        <a href="#" class="settings-icon" title="Settings">⚙️</a>
      </div>
    </div>
  </header>

  <div class="user-dashboard-layout">
    <aside class="user-sidebar">
      <a class="user-side-link active" href="#">Account Information</a>
      <a class="user-side-link" href="#">My Borrowed Books</a>
      <a class="user-side-link" href="#">Settings</a>
      <a class="user-side-link user-side-logout" href="#">Sign out</a>
    </aside>

    <main class="user-dashboard-main">
      <div class="user-panel">
        <h1 class="user-panel-title">User Information</h1>
        
        <div class="user-profile-header">
          <div class="user-avatar">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="12" cy="8" r="4" stroke="#1b1f1b" stroke-width="2"/>
              <path d="M4 20c1.8-3.5 5-5 8-5s6.2 1.5 8 5" stroke="#1b1f1b" stroke-width="2" stroke-linecap="round"/>
            </svg>
          </div>
          <div class="user-profile-info">
            <h2>Zildjian C. Eder</h2>
            <p>zeder@ssct.edu.ph</p>
          </div>
        </div>

        <div class="user-info-section">
          <h2 class="section-title">Personal Information</h2>
          <form class="user-info-form" id="userInfoForm">
            <div class="form-row">
              <div class="form-group">
                <input type="text" name="firstName" value="Zildjian" placeholder="First Name" required>
              </div>
              <div class="form-group">
                <input type="text" name="lastName" value="Eder" placeholder="Last Name" required>
              </div>
            </div>
            <div class="form-group">
              <input type="email" name="email" value="zeder@ssct.edu.ph" placeholder="Email" required>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn primary">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </main>
  </div>

  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
