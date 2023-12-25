<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupJoinRequestRequest;
use App\Models\Group;
use App\Models\GroupJoinRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class GroupJoinRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groupJoinRequests = GroupJoinRequest::query()->whereHas('group.members', function ($q) {
            $q
                ->where('user_id', auth()->id())
                ->where('is_admin', true);
        })->get();

        return  $groupJoinRequests;
    }

    public function getAllJoinRequests(Group $group)
    {
        $group_admin_user_id = $group->members()->wherePivot('is_admin', true)->first()->id;
        if ($group_admin_user_id !== auth()->id()) return response()->json(['message' => 'Unauthorized'], 401);
        return $group->joinRequests()->get();
    }

    public function getAllJoinRequestsOfUser()
    {
        return auth()->user()->groupRequests()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GroupJoinRequestRequest $request)
    {
        $group_to_join = Group::query()->where('id', $request->group_id)->firstOrFail();
        $member_ids = $group_to_join->members()->get()->pluck('id')->toArray();
        $already_a_member = in_array(auth()->id(), $member_ids);

        if ($already_a_member) return response()->json(['message' => 'Already a member'], 403);

        $existing_group_request = auth()->user()->groupRequests()->where('group_id', $group_to_join->id)->first();

        if ($existing_group_request) return response()->json(['message' => 'Request already exists'], 403);


        GroupJoinRequest::create([
            'group_id' => $group_to_join->id,
            'requester_id' => auth()->id(),
            'is_approved' => false
        ]);

        return response()->json(['message' => 'Group request submitted successfully'], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(GroupJoinRequest $join_request)
    {
        return $join_request;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GroupJoinRequest $join_request)
    {
        $join_request->delete();
        return response()->json(['message' => 'Group request has been cancelled'], Response::HTTP_OK);
    }
}
