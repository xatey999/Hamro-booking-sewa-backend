<?php

namespace App\Http\Controllers\app;

use App\Models\HotelRooms;
use App\Models\HotelOwner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;


class hotelappController extends Controller
{
    public function applistMobile()
    {
        $roomData = HotelRooms::all();
        return response()->json($roomData);
    }

    public function appindex()
    {
        return view('app.hotelrooms.index');
    }

    public function appdisplay()
    {
        return view('app.hotelrooms.add');
    }

    public function appcreate(Request $request)
{
    $roomData = new HotelRooms();
    $roomData->fill($request->all());

    // Handling room gallery
    $newGalleryImageName = $request->file('room_gallery')->getClientOriginalName();
    $request->room_gallery->move('images/hotel/room/', $newGalleryImageName);
    $roomData->room_gallery = $newGalleryImageName;

    // Handling room thumbnail
    $newThumbnailImageName = $request->file('room_thumbnail')->getClientOriginalName();
    $request->room_thumbnail->move('images/hotel/room/', $newThumbnailImageName);
    $roomData->room_thumbnail = $newThumbnailImageName;

    // Assign user ID
    $userId = Auth::user()->id;
    $roomData->user_id = $userId;

    // Assign hotel ID
    $hotelUser = HotelOwner::where('user_id', '=', $userId)->first();
    $roomData->hotel_id = $hotelUser->id;

    // Set slug
    $roomData->slug = Str::slug($request->title);

    // Save room data
    $roomData->save();

    return redirect()->back()->with('success', 'New hotel room added successfully');
}

    public function applist()
    {
        $userId = Auth::user()->id;
        $roomData = HotelRooms::where('user_id', '=', $userId)->get();
        return view('app.hotelrooms.list', compact('roomData'));
    }
    public function appedit($id)
    {
        $roomData = HotelRooms::find($id);
        //dd($roomData);
        return view('app.hotelrooms.update', compact('roomData'));
    }
    public function appupdate(Request $request, $id)
    {
        $roomData = HotelRooms::find($id);
        $roomData->title = $request->title;
        $roomData->room_gallery = $request->room_gallery;
        $roomData->price = $request->price;
        $roomData->description = $request->description;
        $roomData->total_rooms = $request->total_rooms;
        $roomData->is_available = $request->is_available;
        $roomData->room_thumbnail = $request->room_thumbnail;
        $roomData->rating = $request->rating;

        
        if ($request->hasFile('room_gallery')) {
            $newGalleryImageName = $request->file('room_gallery')->getClientOriginalName();
            $request->room_gallery->move('images/hotel/room/', $newGalleryImageName);
            $roomData->room_gallery = $newGalleryImageName;
        }
    
        if ($request->hasFile('room_thumbnail')) {
            $newThumbnailImageName = $request->file('room_thumbnail')->getClientOriginalName();
            $request->room_thumbnail->move('images/hotel/room/', $newThumbnailImageName);
            $roomData->room_thumbnail = $newThumbnailImageName;
        }
       
        $roomData->save();
        return redirect()->route('app.listrooms')->with('success', 'Data updated successfully!!');
    }
    public function appdelete($id)
    {
        $roomData = HotelRooms::find($id);
        $roomData->delete();
        return redirect()->route('app.listrooms')->with('message', 'Data deleted successfully!!');
    }
    public function approomdetail($id)
    {
        $roomData = HotelRooms::findorFail($id);
        return view('app.hotelrooms.roomprofile', compact('roomData'));
    }
}
