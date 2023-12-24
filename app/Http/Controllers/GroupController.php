<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Models\Group;
use App\Models\GroupMembers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GroupController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(GroupRequest $request)
    {
        $newly_created_group = Group::create([
            'name' => $request->name,
        ]);

        GroupMembers::create([
            'user_id' => auth()->id(),
            'group_id' => $newly_created_group->id,
            'is_admin' => true,
        ]);

        return response()->json(['message' => 'New group created'], Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GroupRequest $request, Group $group)
    {
        $group_admin_user = $group->members()->wherePivot('is_admin', true)->first();

        if ($group_admin_user->id !== auth()->id())
            return response()->json(['message' => 'Unauthorized']);

        $group->update([
            'name' => $request->name
        ]);

        return response()->json(['message' => 'group name updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Group $group)
    {
        $group_admin_user = $group->members()->wherePivot('is_admin', true)->first();

        if ($group_admin_user?->id !== auth()->id())
            return response()->json(['message' => 'Unauthorized']);

        $group->delete();

        return response()->json(['message' => 'group deleted']);
    }
}
