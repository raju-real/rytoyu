<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /** AJAX fetch paginated notifications for logged-in admin */
    public function fetch(Request $request)
    {
        $adminId  = authAdmin()->id;
        $perPage  = 10;
        $page     = max(1, (int) $request->get('page', 1));
        $countOnly = $request->boolean('count_only');

        $baseQuery = AdminNotification::forAdmin($adminId)->latest();

        $unreadCount = (clone $baseQuery)->unread()->count();

        if ($countOnly) {
            return response()->json(['total_unread' => $unreadCount]);
        }

        $total = $baseQuery->count();
        $items = $baseQuery->skip(($page - 1) * $perPage)->take($perPage)->get();

        return response()->json([
            'data'         => $items->map(fn($n) => [
                'id'       => $n->id,
                'type'     => $n->type,
                'message'  => $n->message,
                'url'      => $n->url,
                'is_read'  => $n->is_read,
                'time_ago' => $n->time_ago,
            ]),
            'total_unread' => $unreadCount,
            'has_more'     => ($page * $perPage) < $total,
        ]);
    }

    /** Mark one or all as read */
    public function markRead(Request $request)
    {
        $adminId = authAdmin()->id;

        if ($request->has('id')) {
            AdminNotification::forAdmin($adminId)->where('id', $request->id)->update(['is_read' => true]);
        } else {
            AdminNotification::forAdmin($adminId)->unread()->update(['is_read' => true]);
        }

        return response()->json(['success' => true]);
    }

    /** Full notifications page */
    public function index(Request $request)
    {
        $adminId = authAdmin()->id;
        $filter  = $request->get('filter', 'all'); // all, unread

        $query = AdminNotification::forAdmin($adminId)->latest();
        if ($filter === 'unread') {
            $query->unread();
        }

        $notifications = $query->paginate(20);
        // Mark shown ones as read
        AdminNotification::forAdmin($adminId)
            ->whereIn('id', $notifications->pluck('id'))
            ->update(['is_read' => true]);

        return view('admin.notifications.index', compact('notifications', 'filter'));
    }
}
