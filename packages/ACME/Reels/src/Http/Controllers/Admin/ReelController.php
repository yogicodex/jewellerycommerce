<?php

namespace ACME\Reels\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use ACME\Reels\Models\Reel;
use Webkul\Admin\Http\Controllers\Controller;

class ReelController extends Controller
{
    /**
     * Fetches all reels and shows the index page.
     */
    public function index()
    {
        $reels = Reel::query()->orderBy('sort_order', 'asc')->get();

        return view('reels::admin.index', compact('reels'));
    }

    /**
     * Shows the form to create a new reel.
     */
    public function create()
    {
        return view('reels::admin.create');
    }

    /**
     * Stores the new reel in the database.
     */
    public function store()
    {
        // START: Updated Validation
        //   dd(request()->all());
        $this->validate(request(), [
            'title'         => 'string',
            'placement_key' => 'nullable|string|unique:reels,placement_key', // Validates the new key
            'video'         => 'required|file|mimetypes:video/mp4,video/webm,video/quicktime|max:50000',
            'sort_order'    => 'required|integer',
            'status'        => 'required|boolean',
        ]);
        // END: Updated Validation

        // START: Updated Create Logic
        Reel::create([
            'title'         => request()->input('title'),
            'placement_key' => request()->input('placement_key'), // Saves the new key
            'sort_order'    => request()->input('sort_order'),
            'status'        => request()->input('status'),
            'video_path'    => request()->file('video')->store('reels'),
        ]);
        // END: Updated Create Logic

        session()->flash('success', 'Reel created successfully.');
        return redirect()->route('admin.reels.index');
    }

    /**
     * Shows the form to edit an existing reel.
     */
    public function edit(int $id)
    {
        $reel = Reel::findOrFail($id);
        return view('reels::admin.edit', compact('reel'));
    }

    /**
     * Updates the reel in the database.
     */
    public function update(int $id)
    {
        $reel = Reel::findOrFail($id);
        
        // START: Updated Validation
        $this->validate(request(), [
            'title'         => 'string',
            'placement_key' => 'nullable|string|unique:reels,placement_key,' . $reel->id, // Validates key but ignores itself
            'video'         => 'nullable|file|mimetypes:video/mp4,video/webm,video/quicktime|max:50000',
            'sort_order'    => 'required|integer',
            'status'        => 'required|boolean',
        ]);
        // END: Updated Validation

        // START: Updated Data Array
        // We add 'placement_key' to the list of fields to be updated.
        $data = request()->only(['title', 'sort_order', 'status', 'placement_key']);
        // END: Updated Data Array

        if (request()->hasFile('video')) {
            Storage::delete($reel->video_path);
            $data['video_path'] = request()->file('video')->store('reels');
        }

        $reel->update($data);
        session()->flash('success', 'Reel updated successfully.');
        return redirect()->route('admin.reels.index');
    }

    /**
     * Deletes the reel from the database.
     */
    public function destroy(int $id)
    {
        $reel = Reel::findOrFail($id);
        Storage::delete($reel->video_path);
        $reel->delete();
        
        session()->flash('success', 'Reel deleted successfully.');
        return redirect()->back();
    }
}