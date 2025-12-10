<x-layout title="BookEase • Notifications" bodyClass="user-page admin-page">
    <x-admin-header />
    
    <div class="dashboard-layout">
        <x-admin-sidebar />

        <main class="dashboard-main">
            <div class="panel">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                    <h2 style="margin: 0;"><i class="fa-solid fa-bell"></i> Notifications 
                        @if($unreadCount > 0)
                            <span class="badge danger" style="margin-left: 10px;">{{ $unreadCount }} unread</span>
                        @endif
                    </h2>
                    <div style="display: flex; gap: 10px;">
                        <form action="{{ route('notifications.read-all') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn" style="background: #6c757d; color: #fff;">
                                <i class="fa-solid fa-check-double"></i> Mark All as Read
                            </button>
                        </form>
                        <form action="{{ route('notifications.delete-read') }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete all read notifications?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn danger">
                                <i class="fa-solid fa-trash"></i> Delete Read
                            </button>
                        </form>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert success"><i class="fa-solid fa-check-circle"></i> {{ session('success') }}</div>
                @endif

                <!-- Search -->
                <div class="table-toolbar" style="margin-bottom: 20px;">
                    <x-admin-search 
                        id="notificationSearch" 
                        placeholder="Search by Title or Message"
                        listId="notifList"
                        :searchFields="['title', 'message']"
                    />
                </div>

                <!-- Filter Tabs -->
                <div style="display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px;">
                    <a href="{{ route('notifications', ['filter' => 'all']) }}" 
                       class="btn {{ $filter === 'all' ? 'primary' : '' }}" 
                       style="text-decoration: none; {{ $filter === 'all' ? '' : 'background: #f8f9fa; color: #666;' }}">
                        <i class="fa-solid fa-list"></i> All
                    </a>
                    <a href="{{ route('notifications', ['filter' => 'unread']) }}" 
                       class="btn {{ $filter === 'unread' ? 'primary' : '' }}" 
                       style="text-decoration: none; {{ $filter === 'unread' ? '' : 'background: #f8f9fa; color: #666;' }}">
                        <i class="fa-solid fa-envelope"></i> Unread
                        @if($unreadCount > 0)
                            <span class="badge danger" style="margin-left: 5px;">{{ $unreadCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('notifications', ['filter' => 'read']) }}" 
                       class="btn {{ $filter === 'read' ? 'primary' : '' }}" 
                       style="text-decoration: none; {{ $filter === 'read' ? '' : 'background: #f8f9fa; color: #666;' }}">
                        <i class="fa-solid fa-envelope-open"></i> Read
                    </a>
                </div>

                <!-- Notifications List -->
                <div class="list" id="notifList">
                    @forelse($notifications as $notification)
                    <div class="list-item {{ $notification->is_read ? 'read' : 'unread' }}" 
                         data-notification-id="{{ $notification->id }}"
                         data-title="{{ strtolower($notification->title) }}"
                         data-message="{{ strtolower($notification->message) }}"
                         style="padding: 15px; margin-bottom: 10px; border-radius: 8px; background: {{ $notification->is_read ? '#f8f9fa' : '#fff' }}; border-left: 4px solid {{ $notification->is_read ? '#e0e0e0' : '#2e7d32' }}; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <div style="display: flex; align-items: flex-start; gap: 15px;">
                            <div style="flex-shrink: 0; width: 40px; height: 40px; border-radius: 50%; background: {{ $notification->is_read ? '#e0e0e0' : '#e8f5e9' }}; display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid {{ $notification->icon }}" style="color: {{ $notification->is_read ? '#999' : '#2e7d32' }}; font-size: 18px;"></i>
                            </div>
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 5px;">
                                    <h4 style="margin: 0; font-size: 16px; color: #333; font-weight: {{ $notification->is_read ? '400' : '600' }};">
                                        {{ $notification->title }}
                                    </h4>
                                    <div style="display: flex; gap: 5px;">
                                        @if(!$notification->is_read)
                                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST" style="display: inline;" class="mark-read-form">
                                            @csrf
                                            <button type="submit" class="icon-btn" title="Mark as read" style="background: transparent; border: none; cursor: pointer; color: #666; padding: 5px;">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </form>
                                        @endif
                                        <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this notification?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="icon-btn" title="Delete" style="background: transparent; border: none; cursor: pointer; color: #dc3545; padding: 5px;">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <p style="margin: 0; color: #666; font-size: 14px; line-height: 1.5;">
                                    {{ $notification->message }}
                                </p>
                                <div style="margin-top: 8px; display: flex; align-items: center; gap: 15px; font-size: 12px; color: #999;">
                                    <span><i class="fa-solid fa-clock"></i> {{ $notification->created_at->diffForHumans() }}</span>
                                    @if($notification->book)
                                        <span><i class="fa-solid fa-book"></i> {{ $notification->book->title }}</span>
                                    @endif
                                    @if($notification->user)
                                        <span><i class="fa-solid fa-user"></i> {{ $notification->user->name }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div style="text-align: center; padding: 60px 20px; color: #666;">
                        <i class="fa-solid fa-bell-slash" style="font-size: 64px; margin-bottom: 20px; display: block; color: #ccc;"></i>
                        <h3 style="margin: 0 0 10px 0; color: #999;">No notifications found</h3>
                        <p style="margin: 0; color: #999;">You're all caught up! No notifications to display.</p>
                    </div>
                    @endforelse
                </div>

                @if($notifications->hasPages())
                    <div style="margin-top: 20px;">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mark as read on click (if unread)
            document.querySelectorAll('.mark-read-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const form = this;
                    const notificationItem = form.closest('.list-item');
                    
                    const token = form.querySelector('input[name="_token"]')?.value || 
                                  document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                                  '{{ csrf_token() }}';
                    
                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            notificationItem.classList.remove('unread');
                            notificationItem.classList.add('read');
                            notificationItem.style.background = '#f8f9fa';
                            notificationItem.style.borderLeftColor = '#e0e0e0';
                            form.remove();
                            
                            // Update unread count
                            const unreadBadge = document.querySelector('.badge.danger');
                            if (unreadBadge) {
                                const count = parseInt(unreadBadge.textContent) - 1;
                                if (count > 0) {
                                    unreadBadge.textContent = count + ' unread';
                                } else {
                                    unreadBadge.remove();
                                }
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        form.submit(); // Fallback to normal form submission
                    });
                });
            });
        });
    </script>
</x-layout>
