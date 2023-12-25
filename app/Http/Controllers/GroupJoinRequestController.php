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
        $groupJoinRequests = GroupJoinRequest::query()->whereHas('group.members', function($q) {
            $q
            ->where('user_id', auth()->id())
            ->where('is_admin', true);
        })->get();

        return  $groupJoinRequests;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GroupJoinRequestRequest $request)
    {
        $group_to_join = Group::query()->where('id', $request->group_id)->firstOrFail();

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
