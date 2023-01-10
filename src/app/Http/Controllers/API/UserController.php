<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListUserRequest;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Pagination\Paginator;

class UserController extends Controller
{
    public function record($user_id)
    {
        if (!is_numeric($user_id)) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'The user_id must be an integer.',
            ], 400));
        }

        if ($user = User::query()->with('position')->find($user_id)) {

            $response = [
                'success' => true,
                'user' => $user,
            ];

            return response()->json($response, 200);
        }

        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'The user with the requested identifier does not exist',
        ], 404));
    }

    public function list(ListUserRequest $request)
    {
        if ($offset = $request->offset) {
            $currentPage = ($offset / $request->count);

            Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });
        }

        $users = User::query()
            ->with('position')
            ->orderBy('id', 'asc')
            ->paginate($request->count);

        if ($request->page > $users->lastPage()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Page not found',
            ], 404));
        }

        $custom = collect(['success' => true]);

        $response = $custom->merge($users);

        return response()->json($response, 200);
    }

    public function positions()
    {
        $positions = Position::query()->get();

        if (!$positions || !$positions->count()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Positions not found',
            ], 422));
        }

        $response = [
            'success' => true,
            'positions' => $positions,
        ];

        return response()->json($response, 200);
    }
}