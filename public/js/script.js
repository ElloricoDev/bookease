document.addEventListener('DOMContentLoaded', () => {
  // Header Search Functionality
  const headerSearch = document.getElementById('headerSearch');
  const headerSearchIcon = document.getElementById('headerSearchIcon');
  const headerSearchForm = document.querySelector('.header-search-form');
  const searchSuggestions = document.getElementById('searchSuggestions');
  let searchTimeout;
  let currentSuggestions = [];

  if (headerSearch && headerSearchForm) {
    // Get CSRF token for AJAX requests
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    // Handle search form submission
    const performSearch = (query) => {
      const booksRoute = window.booksRoute || '/user/books';
      if (query && query.trim().length > 0) {
        window.location.href = `${booksRoute}?q=${encodeURIComponent(query.trim())}`;
      } else {
        window.location.href = booksRoute;
      }
    };

    // Submit on Enter key
    headerSearch.addEventListener('keydown', function(e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        searchSuggestions.style.display = 'none';
        performSearch(this.value);
      } else if (e.key === 'ArrowDown' && currentSuggestions.length > 0) {
        e.preventDefault();
        const firstSuggestion = searchSuggestions.querySelector('.suggestion-item');
        if (firstSuggestion) {
          firstSuggestion.focus();
          firstSuggestion.style.backgroundColor = '#f0f0f0';
        }
      }
    });

    // Submit on search icon click
    if (headerSearchIcon) {
      headerSearchIcon.addEventListener('click', function() {
        searchSuggestions.style.display = 'none';
        performSearch(headerSearch.value);
      });
    }

    // Live search suggestions with AJAX
    if (headerSearch && searchSuggestions) {
      headerSearch.addEventListener('input', function() {
        const query = this.value.trim();
        
        // Clear previous timeout
        clearTimeout(searchTimeout);
        
        // Hide suggestions if query is empty
        if (query.length === 0) {
          searchSuggestions.style.display = 'none';
          currentSuggestions = [];
          return;
        }

        // Show suggestions after a short delay (debounce)
        searchTimeout = setTimeout(() => {
          if (query.length >= 2) {
            // Fetch suggestions via AJAX
            fetch(`/search/suggestions?q=${encodeURIComponent(query)}`, {
              method: 'GET',
              headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
              }
            })
            .then(response => response.json())
            .then(data => {
              currentSuggestions = data.suggestions || [];
              displaySuggestions(currentSuggestions, query);
            })
            .catch(error => {
              console.error('Search error:', error);
              // Fallback: show simple search suggestion
              searchSuggestions.innerHTML = `
                <div class="suggestion-item" onclick="performQuickSearch('${query.replace(/'/g, "\\'")}');">
                  <i class="fa-solid fa-magnifying-glass"></i>
                  Search for "${query}"
                </div>
              `;
              searchSuggestions.style.display = 'block';
            });
          } else {
            searchSuggestions.style.display = 'none';
            currentSuggestions = [];
          }
        }, 300);
      });

      // Function to display suggestions
      function displaySuggestions(suggestions, query) {
        if (suggestions.length === 0) {
          searchSuggestions.innerHTML = `
            <div class="suggestion-item" onclick="performQuickSearch('${query.replace(/'/g, "\\'")}');">
              <i class="fa-solid fa-magnifying-glass"></i>
              Search for "${query}"
            </div>
          `;
        } else {
          let html = '';
          suggestions.forEach((suggestion, index) => {
            if (suggestion.type === 'book') {
              html += `
                <div class="suggestion-item" onclick="performQuickSearch('${suggestion.title.replace(/'/g, "\\'")}');" tabindex="0">
                  <i class="fa-solid fa-book" style="color: #2e7d32;"></i>
                  <div style="flex: 1;">
                    <strong>${escapeHtml(suggestion.title)}</strong>
                    <div style="font-size: 12px; color: #666; margin-top: 2px;">
                      ${escapeHtml(suggestion.author)}${suggestion.category ? ' • ' + escapeHtml(suggestion.category) : ''}
                    </div>
                  </div>
                </div>
              `;
            } else if (suggestion.type === 'category') {
              const booksRoute = window.booksRoute || '/user/books';
              html += `
                <div class="suggestion-item" onclick="window.location.href='${booksRoute}?category=${encodeURIComponent(suggestion.title)}';" tabindex="0">
                  <i class="fa-solid fa-tag" style="color: #17a2b8;"></i>
                  <div style="flex: 1;">
                    <strong>${escapeHtml(suggestion.title)}</strong>
                    <div style="font-size: 12px; color: #666; margin-top: 2px;">
                      ${suggestion.count} book(s)
                    </div>
                  </div>
                </div>
              `;
            }
          });
          
          // Add "Search for..." option at the end
          html += `
            <div class="suggestion-item" onclick="performQuickSearch('${query.replace(/'/g, "\\'")}');" style="border-top: 2px solid #e0e0e0; font-weight: 600;">
              <i class="fa-solid fa-magnifying-glass" style="color: #2e7d32;"></i>
              Search for "${escapeHtml(query)}"
            </div>
          `;
          
          searchSuggestions.innerHTML = html;
        }
        searchSuggestions.style.display = 'block';
      }

      // Helper function to escape HTML
      function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
      }

      // Hide suggestions when clicking outside
      document.addEventListener('click', function(e) {
        if (!headerSearch.contains(e.target) && !searchSuggestions.contains(e.target)) {
          searchSuggestions.style.display = 'none';
        }
      });

      // Global function for quick search
      window.performQuickSearch = function(query) {
        const booksRoute = window.booksRoute || '/user/books';
        searchSuggestions.style.display = 'none';
        if (query && query.trim().length > 0) {
          window.location.href = `${booksRoute}?q=${encodeURIComponent(query.trim())}`;
        }
      };
    }
  }

  // Password Toggle Functionality
  document.querySelectorAll('.toggle-pass').forEach(button => {
    button.addEventListener('click', function() {
      const passwordField = this.closest('.password-field').querySelector('input[type="password"], input[type="text"]');
      const icon = this.querySelector('i');
      
      if (passwordField.type === 'password') {
        passwordField.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
        this.innerHTML = '<i class="fa-solid fa-eye-slash"></i> Hide';
      } else {
        passwordField.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
        this.innerHTML = '<i class="fa-solid fa-eye"></i> Show';
      }
    });
  });

  // Add User Modal
  const addUserBtn = document.getElementById('addUserBtn');
  const addUserModal = document.getElementById('addUserModal');
  if (addUserBtn && addUserModal) {
    const addClose = addUserModal.querySelector('.modal-close');
    addUserBtn.addEventListener('click', () => addUserModal.classList.add('show'));
    if (addClose) {
      addClose.addEventListener('click', () => addUserModal.classList.remove('show'));
    }
  }

  // Edit User Modal
  const editModal = document.getElementById('editUserModal');
  const editForm = document.getElementById('editUserForm');
  if (editModal && editForm) {
    const editClose = editModal.querySelector('.modal-close');
    document.querySelectorAll('.edit-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const tr = e.target.closest('tr');
        const id = tr.dataset.id;
        document.getElementById('editName').value = tr.dataset.name;
        document.getElementById('editEmail').value = tr.dataset.email;
        document.getElementById('editRole').value = tr.dataset.role;
        editForm.action = `/users/${id}`;
        editModal.classList.add('show');
      });
    });
    if (editClose) {
      editClose.addEventListener('click', () => editModal.classList.remove('show'));
    }
  }
});