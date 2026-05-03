<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /** GET /api/admin/notifications/count — untuk polling dropdown */
    public function count(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $recent = $user->notifications()->take(5)->get()
            ->map(fn($n) => [
                'id'               => $n->id,
                'body'             => $n->body,
                'icon'             => $n->icon,
                'color'            => $n->color,
                'url'              => $n->url,
                'read_at'          => $n->read_at,
                'created_at_human' => $n->created_at->diffForHumans(),
            ]);

        return response()->json([
            'success'      => true,
            'unread_count' => $user->unreadNotifications()->count(),
            'recent'       => $recent,
        ]);
    }

    /** GET /api/admin/notifications — halaman semua notif */
    public function index(Request $request): JsonResponse
    {
        /** @var User $user */
        $user  = Auth::user();
        $query = $user->notifications();

        if ($request->filter === 'unread') {
            $query->whereNull('read_at');
        }

        $paginated = $query->paginate(20);

        $items = collect($paginated->items())->map(fn($n) => [
            'id'               => $n->id,
            'body'             => $n->body,
            'icon'             => $n->icon,
            'color'            => $n->color,
            'url'              => $n->url,
            'read_at'          => $n->read_at,
            'created_at_human' => $n->created_at->diffForHumans(),
        ]);

        return response()->json([
            'success'      => true,
            'data'         => $items,
            'unread_count' => $user->unreadNotifications()->count(),
            'pagination'   => [
                'current_page' => $paginated->currentPage(),
                'last_page'    => $paginated->lastPage(),
                'total'        => $paginated->total(),
            ],
        ]);
    }

    /** POST /api/admin/notifications/{id}/read */
    public function markRead(int $id): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $notif = $user->notifications()->findOrFail($id);
        $notif->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    /** POST /api/admin/notifications/read-all */
    public function markAllRead(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $user->unreadNotifications()->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }
}