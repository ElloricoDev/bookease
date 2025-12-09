document.addEventListener('DOMContentLoaded', () => {
  // Add User Modal
  const addUserBtn = document.getElementById('addUserBtn');
  const addUserModal = document.getElementById('addUserModal');
  const addClose = addUserModal.querySelector('.modal-close');
  addUserBtn.addEventListener('click', () => addUserModal.classList.add('show'));
  addClose.addEventListener('click', () => addUserModal.classList.remove('show'));

  // Edit User Modal
  const editModal = document.getElementById('editUserModal');
  const editForm = document.getElementById('editUserForm');
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
  editClose.addEventListener('click', () => editModal.classList.remove('show'));
});