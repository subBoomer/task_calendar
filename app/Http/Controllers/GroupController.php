<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalendarGroup;

class GroupController extends Controller
{
    public function index()
    {
        // Logic to show all groups

        // Retrieve all groups from the Group model
        $groups = CalendarGroup::all();

        // Pass the groups data to the 'groups.index' view to render
        return view('groups.index', ['groups' => $groups]);
    }

    public function show($id)
    {
        // Logic to show a specific group by $id

        // Find the group by its ID using the Group model
        $group = CalendarGroup::find($id);

        // If the group is not found, return a 404 error
        if (!$group) {
            return abort(404, 'Group not found');
        }

        // Pass the found group data to the 'groups.show' view to render
        return view('groups.show', ['group' => $group]);
    }

    // Other actions related to groups

    public function create(Request $request)
    {
        // Logic to handle creating a new group (e.g., form submission)

        // Example: Create a new group using request data
        $group = new CalendarGroup();
        $group->name = $request->input('name');
        $group->description = $request->input('description');
        $group->save();

        return redirect()->route('groups.index')->with('success', 'Group created successfully');
    }

    public function update(Request $request, $id)
    {
        // Logic to handle updating an existing group

        // Example: Find the group by ID and update its details
        $group = CalendarGroup::find($id);
        if (!$group) {
            return abort(404, 'Group not found');
        }

        $group->name = $request->input('name');
        $group->description = $request->input('description');
        $group->save();

        return redirect()->route('groups.show', ['group' => $group])->with('success', 'Group updated successfully');
    }

    public function destroy($id)
    {
        // Logic to handle deleting an existing group

        // Example: Find the group by ID and delete it
        $group = CalendarGroup::find($id);
        if (!$group) {
            return abort(404, 'Group not found');
        }

        $group->delete();

        return redirect()->route('groups.index')->with('success', 'Group deleted successfully');
    }

}
