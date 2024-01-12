<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserGroup;

class GroupController extends Controller
{
    public function index()
    {
        // Logic to show all groups

        // Retrieve all groups from the Group model
        $groups = UserGroup::all();

        // Pass the groups data to the 'groups.index' view to render
        return view('groups.index', ['groups' => $groups]);
    }

    public function show($id = null)
    {
        if ($id) {
            // Logic to show a specific group by $id
            // Find the group by its ID using the Group model
            $group = UserGroup::with('members')->find($id);
    
            // If the group is not found, return a 404 error
            if (!$group) {
                return abort(404, 'Group not found');
            }
    
            // Pass the found group data to the 'groups.show' view to render
            return view('groups.groups', ['group' => $group]);
        } else {
            // Logic to show a message when no specific group is selected
            return view('no-group');
        }
    }

    // Other actions related to groups

    public function create(Request $request)
    {
        // Logic to handle creating a new group (e.g., form submission)

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'member_count' => 'required|integer',
            'member_emails' => 'array', // Adjust validation as needed
            // Add more validation rules for other columns
        ]);

        // Create a new group with the validated data
        $group = UserGroup::create([
            'name' => $request->input('name'),
            'member_count' => $request->input('member_count'),
            'member_emails' => $request->input('member_emails'),
            // Add more columns as needed
        ]);

        return redirect()->route('groups.index')->with('success', 'Group created successfully');
    }

    public function showCreateForm()
    {
        return view('groups.create');
    }

    public function update(Request $request, $id)
    {
        // Logic to handle updating an existing group

        // Example: Find the group by ID and update its details
        $group = UserGroup::find($id);
        if (!$group) {
            return abort(404, 'Group not found');
        }

        $group->name = $request->input('name');
        $group->description = $request->input('description');
        $group->save();

        return redirect()->route('groups.groups', ['group' => $group])->with('success', 'Group updated successfully');
    }

    public function destroy($id)
    {
        // Logic to handle deleting an existing group

        // Example: Find the group by ID and delete it
        $group = UserGroup::find($id);
        if (!$group) {
            return abort(404, 'Group not found');
        }

        $group->delete();

        return redirect()->route('groups.index')->with('success', 'Group deleted successfully');
    }

}
