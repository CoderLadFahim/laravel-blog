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
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
