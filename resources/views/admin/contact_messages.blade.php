<x-layout title="BookEase • Contact Messages" bodyClass="user-page admin-page">
    <x-admin-header />
    
    <div class="dashboard-layout">
        <x-admin-sidebar />

        <main class="dashboard-main">
            <div class="panel">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                    <h2 style="margin: 0;"><i class="fa-solid fa-envelope"></i> Contact Messages</h2>
                    @if($newCount > 0)
                        <span class="badge danger" style="font-size: 16px; padding: 8px 16px;">
                            <i class="fa-solid fa-bell"></i> {{ $newCount }} New Messages
                        </span>
                    @endif
                </div>

                @if(session('success'))
                    <div class="alert success"><i class="fa-solid fa-check-circle"></i> {{ session('success') }}</div>
                @endif

                <!-- Search -->
                <div class="table-toolbar" style="margin-bottom: 20px;">
                    <x-admin-search 
                        id="messageSearch" 
                        placeholder="Search by Name, Email, or Subject"
                        tableId="messagesTable"
                        :searchFields="['name', 'email', 'subject']"
                    />
                </div>

                <!-- Filter Tabs -->
                <div style="display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px;">
                    <a href="{{ route('admin.contact_messages', ['filter' => 'all']) }}" 
                       class="btn {{ $filter === 'all' ? 'primary' : '' }}" 
                       style="text-decoration: none; {{ $filter === 'all' ? '' : 'background: #f8f9fa; color: #666;' }}">
                        <i class="fa-solid fa-list"></i> All
                    </a>
                    <a href="{{ route('admin.contact_messages', ['filter' => 'new']) }}" 
                       class="btn {{ $filter === 'new' ? 'primary' : '' }}" 
                       style="text-decoration: none; {{ $filter === 'new' ? '' : 'background: #f8f9fa; color: #666;' }}">
                        <i class="fa-solid fa-envelope"></i> New
                        @if($newCount > 0)
                            <span class="badge danger" style="margin-left: 5px;">{{ $newCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.contact_messages', ['filter' => 'read']) }}" 
                       class="btn {{ $filter === 'read' ? 'primary' : '' }}" 
                       style="text-decoration: none; {{ $filter === 'read' ? '' : 'background: #f8f9fa; color: #666;' }}">
                        <i class="fa-solid fa-envelope-open"></i> Read
                    </a>
                    <a href="{{ route('admin.contact_messages', ['filter' => 'replied']) }}" 
                       class="btn {{ $filter === 'replied' ? 'primary' : '' }}" 
                       style="text-decoration: none; {{ $filter === 'replied' ? '' : 'background: #f8f9fa; color: #666;' }}">
                        <i class="fa-solid fa-reply"></i> Replied
                    </a>
                    <a href="{{ route('admin.contact_messages', ['filter' => 'archived']) }}" 
                       class="btn {{ $filter === 'archived' ? 'primary' : '' }}" 
                       style="text-decoration: none; {{ $filter === 'archived' ? '' : 'background: #f8f9fa; color: #666;' }}">
                        <i class="fa-solid fa-archive"></i> Archived
                    </a>
                </div>

                <!-- Messages List -->
                <div class="table-wrap">
                    <table class="table" id="messagesTable">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($messages as $message)
                            <tr 
                                style="{{ $message->status === 'new' ? 'background: #fff3cd;' : '' }}"
                                data-name="{{ strtolower($message->name) }}"
                                data-email="{{ strtolower($message->email) }}"
                                data-subject="{{ strtolower($message->subject) }}"
                            >
                                <td>
                                    @if($message->status === 'new')
                                        <span class="badge danger">New</span>
                                    @elseif($message->status === 'read')
                                        <span class="badge warning">Read</span>
                                    @elseif($message->status === 'replied')
                                        <span class="badge success">Replied</span>
                                    @else
                                        <span class="badge" style="background: #6c757d;">Archived</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $message->name }}</strong>
                                    @if($message->user)
                                        <span class="badge" style="background: #17a2b8; margin-left: 5px;">User</span>
                                    @endif
                                </td>
                                <td>{{ $message->email }}</td>
                                <td>
                                    <strong>{{ Str::limit($message->subject, 50) }}</strong>
                                </td>
                                <td>{{ $message->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.contact_messages.show', $message->id) }}" class="btn small">
                                        <i class="fa-solid fa-eye"></i> View
                                    </a>
                                    <form action="{{ route('admin.contact_messages.destroy', $message->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this message?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn small danger">
                                            <i class="fa-solid fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 40px; color: #666;">
                                    <i class="fa-solid fa-inbox" style="font-size: 48px; margin-bottom: 15px; display: block; color: #ccc;"></i>
                                    No messages found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($messages->hasPages())
                    <div style="margin-top: 20px;">
                        {{ $messages->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</x-layout>

