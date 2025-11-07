<?php

namespace ACME\Reels\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use ACME\Reels\Models\EventBanner;
use ACME\Reels\DataGrids\Admin\EventBannerDataGrid;

class EventBannerController extends Controller
{
    /**
     * Display a listing of the event banners.
     */
    public function index()
    {
        if (request()->ajax()) {
            $grid = app(\ACME\Reels\DataGrids\Admin\EventBannerDataGrid::class);
            // The following line is not strictly necessary as `toJson` calls it,
            // but it's harmless.
            $grid->prepareQueryBuilder();
            return $grid->toJson();
        }

        return view('reels::admin.events.index');
    }

    /**
     * Show the form for creating a new event banner.
     */
    public function create()
    {
        return view('reels::admin.events.create');
    }

    /**
     * Store a newly created event banner.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'nullable|string|max:255',
            'image.*'  => 'required|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'link'     => 'nullable|url',
            'status'   => 'required|boolean',
        ]);

        $path = $request->file('image')[0]->store('event_banners');

        EventBanner::create([
            'title'  => $request->title,
            'path'   => $path,
            'link'   => $request->link,
            'status' => $request->status,
        ]);

        session()->flash('success', 'Event Banner created successfully.');

        return redirect()->route('admin.event_banners.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Find the banner by its ID
        $banner = EventBanner::find($id);

        if (!$banner) {
            return response()->json([
                'message' => 'Banner not found.'
            ], 404);
        }

        try {
            // Step 1: Delete the image file from storage
            if (Storage::exists($banner->path)) {
                Storage::delete($banner->path);
            }

            // Step 2: Delete the database record
            $banner->delete();

            // Return a success response for the DataGrid
            return response()->json([
                'message' => 'Banner deleted successfully.',
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Illuminate\Support\Facades\Log::error('Error deleting banner: ' . $e->getMessage());
            
            // Return an error response
            return response()->json([
                'message' => 'An error occurred while deleting the banner. Please try again.'
            ], 500);
        }
    }
}