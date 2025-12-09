<x-layout title="BookEase • Contact Message" bodyClass="user-page admin-page">
    <x-admin-header />
    
    <div class="dashboard-layout">
        <x-admin-sidebar />

        <main class="dashboard-main">
            <div class="panel">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                    <h2 style="margin: 0;"><i class="fa-solid fa-envelope"></i> Contact Message</h2>
                    <a href="{{ route('admin.contact_messages') }}" class="btn" style="background: #6c757d; color: #fff; text-decoration: none;">
                        <i class="fa-solid fa-arrow-left"></i> Back to Messages
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert success"><i class="fa-solid fa-check-circle"></i> {{ session('success') }}</div>
                @endif

                <!-- Message Details -->
                <div style="background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 30px;">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px solid #e0e0e0;">
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #666; font-size: 14px;">From</label>
                            <div style="font-size: 18px; color: #333;">
                                <i class="fa-solid fa-user" style="color: #2e7d32; margin-right: 8px;"></i>
                                <strong>{{ $message->name }}</strong>
                                @if($message->user)
                                    <span class="badge" style="background: #17a2b8; margin-left: 8px;">Registered User</span>
                                @else
                                    <span class="badge" style="background: #6c757d; margin-left: 8px;">Guest</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #666; font-size: 14px;">Email</label>
                            <div style="font-size: 18px; color: #333;">
                                <i class="fa-solid fa-envelope" style="color: #2e7d32; margin-right: 8px;"></i>
                                <a href="mailto:{{ $message->email }}" style="color: #2e7d32; text-decoration: none;">{{ $message->email }}</a>
                            </div>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #666; font-size: 14px;">Date</label>
                            <div style="font-size: 18px; color: #333;">
                                <i class="fa-solid fa-calendar" style="color: #2e7d32; margin-right: 8px;"></i>
                                {{ $message->created_at->format('M d, Y H:i') }}
                            </div>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #666; font-size: 14px;">Status</label>
                            <div>
                                @if($message->status === 'new')
                                    <span class="badge danger">New</span>
                                @elseif($message->status === 'read')
                                    <span class="badge warning">Read</span>
                                @elseif($message->status === 'replied')
                                    <span class="badge success">Replied</span>
                                @else
                                    <span class="badge" style="background: #6c757d;">Archived</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div style="margin-bottom: 30px;">
                        <label style="display: block; margin-bottom: 10px; font-weight: 600; color: #333; font-size: 18px;">
                            <i class="fa-solid fa-tag" style="color: #2e7d32; margin-right: 8px;"></i> Subject
                        </label>
                        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #2e7d32;">
                            <strong style="font-size: 20px; color: #333;">{{ $message->subject }}</strong>
                        </div>
                    </div>

                    <div style="margin-bottom: 30px;">
                        <label style="display: block; margin-bottom: 10px; font-weight: 600; color: #333; font-size: 18px;">
                            <i class="fa-solid fa-message" style="color: #2e7d32; margin-right: 8px;"></i> Message
                        </label>
                        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 4px solid #2e7d32; line-height: 1.8; color: #333; white-space: pre-wrap;">
                            {{ $message->message }}
                        </div>
                    </div>

                    @if($message->admin_notes)
                    <div style="margin-bottom: 30px;">
                        <label style="display: block; margin-bottom: 10px; font-weight: 600; color: #333; font-size: 18px;">
                            <i class="fa-solid fa-sticky-note" style="color: #2e7d32; margin-right: 8px;"></i> Admin Notes
                        </label>
                        <div style="background: #fff3cd; padding: 15px; border-radius: 8px; border-left: 4px solid #ffc107;">
                            {{ $message->admin_notes }}
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Update Status Form -->
                <div style="background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <h3 style="color: #2e7d32; margin-bottom: 20px;">
                        <i class="fa-solid fa-cog"></i> Update Status
                    </h3>
                    <form action="{{ route('admin.contact_messages.update_status', $message->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 20px;">
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
                                    <i class="fa-solid fa-tag"></i> Status
                                </label>
                                <select name="status" required
                                        style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px;">
                                    <option value="new" {{ $message->status === 'new' ? 'selected' : '' }}>New</option>
                                    <option value="read" {{ $message->status === 'read' ? 'selected' : '' }}>Read</option>
                                    <option value="replied" {{ $message->status === 'replied' ? 'selected' : '' }}>Replied</option>
                                    <option value="archived" {{ $message->status === 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                            </div>
                        </div>
                        
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
                                <i class="fa-solid fa-sticky-note"></i> Admin Notes (Optional)
                            </label>
                            <textarea name="admin_notes" rows="4" 
                                      placeholder="Add internal notes about this message..."
                                      style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px;">{{ old('admin_notes', $message->admin_notes) }}</textarea>
                        </div>
                        
                        <div style="display: flex; gap: 10px;">
                            <button type="submit" class="btn primary">
                                <i class="fa-solid fa-save"></i> Update Status
                            </button>
                            <form action="{{ route('admin.contact_messages.destroy', $message->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this message?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn danger">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</x-layout>

