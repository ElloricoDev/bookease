<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookEase • Book Management</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="user-page">

<header class="user-header-light">
    <div class="nav-inner">
        <a href="{{ url('/user/home') }}" class="brand">BookEase</a>
        <nav>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ url('/user/books') }}">Books</a></li>
                <li><a href="#">About us</a></li>
                <li><a href="#">Contact us</a></li>
                <li><a href="{{ route('info') }}" class="profile-link">👤</a></li>
                <li><a href="{{ url('/logout') }}">Sign out</a></li>
            </ul>
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
        <h2>Book Management</h2>

        <div class="table-toolbar">
          <div class="search-wrap">
            
            <input type="search" id="bookSearch" placeholder="Search by Title, Author, or Category">
            <button class="btn small" id="bookFilterBtn">Filter</button>
          </div>
          <a class="btn primary" href="#">+ Add Book</a>
        </div>

        <div class="table-wrap">
          <table class="table" id="booksTable">
            <thead>
              <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>The Great Gatsby</td>
                <td>N. Arguelles</td>
                <td>Fiction</td>
                <td>Available</td>
                <td><button class="icon-btn">🗑️</button></td>
              </tr>
              <tr>
                <td>1984</td>
                <td>George Orwell</td>
                <td>Science Fiction</td>
                <td>Available</td>
                <td><button class="icon-btn">🗑️</button></td>
              </tr>
              <tr>
                <td>Sapiens</td>
                <td>C.J. Roselim</td>
                <td>History</td>
                <td>Available</td>
                <td><button class="icon-btn">🗑️</button></td>
              </tr>
              <tr>
                <td>Hunger Games</td>
                <td>J. Alsgao</td>
                <td>Science Fiction</td>
                <td>Borrowed</td>
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
