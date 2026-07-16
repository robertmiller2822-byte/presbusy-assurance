@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="text-muted">Total Messages</h5>
                <h2 class="fw-bold">{{ $totalMessages }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm" style="border-left: 4px solid var(--gold);">
            <div class="card-body">
                <h5 class="text-muted">Unread</h5>
                <h2 class="fw-bold" style="color: var(--gold);">{{ $unreadMessages }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white fw-bold">Contact Messages</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($messages as $msg)
                        <tr>
                            <td>{{ $msg->name }}</td>
                            <td>{{ $msg->email }}</td>
                            <td>{{ $msg->subject }}</td>
                            <td>
                                @if ($msg->status === 'unread')
                                    <span class="badge bg-warning text-dark">Unread</span>
                                @else
                                    <span class="badge bg-success">Read</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.message.read', $msg->id) }}" class="btn btn-sm btn-outline-success">Read</a>
                                <a href="{{ route('admin.message.delete', $msg->id) }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')">Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-4">No messages yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection