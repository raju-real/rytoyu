@extends('admin.layouts.app')
@section('title', 'Notifications')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4><i class="bx bx-bell"></i> Notifications</h4>
                <div class="d-flex gap-2">
                    <form action="{{ route('admin.notifications.mark-read') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-soft-primary btn-sm">
                            <i class="bx bx-check-double"></i> Mark All Read
                        </button>
                    </form>
                    <a href="{{ route('admin.notifications.index', ['filter' => 'unread']) }}"
                        class="btn btn-sm {{ $filter === 'unread' ? 'btn-primary' : 'btn-soft-info' }}">
                        <i class="bx bx-envelope"></i> Unread
                    </a>
                    <a href="{{ route('admin.notifications.index') }}"
                        class="btn btn-sm {{ $filter === 'all' ? 'btn-primary' : 'btn-soft-info' }}">
                        <i class="bx bx-list-ul"></i> All
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            @forelse($notifications as $notif)
                <div class="notification-item {{ $notif->is_read ? '' : 'unread' }}"
                    onclick="window.location='{{ $notif->url ?? '#' }}'">
                    <div class="notif-icon">
                        @if ($notif->type === 'order')
                            <i class="bx bx-cart"></i>
                        @elseif($notif->type === 'seller')
                            <i class="bx bx-store"></i>
                        @elseif($notif->type === 'refund')
                            <i class="bx bx-undo"></i>
                        @else
                            <i class="bx bx-info-circle"></i>
                        @endif
                    </div>
                    <div class="notif-body flex-grow-1">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0">{{ $notif->message }}</p>
                            @if (!$notif->is_read)
                                <span class="badge badge-soft-primary ms-2">New</span>
                            @endif
                        </div>
                        <small>{{ $notif->time_ago }}</small>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    <i class="bx bx-check-circle" style="font-size:3rem;"></i>
                    <p class="mt-2">You're all caught up!</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $notifications->links() }}
    </div>
@endsection
