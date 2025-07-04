<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(User::class, 'user'); // use Laravel's built-in authorization middleware to restrict access to this controller methods'
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('User.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('User.update', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, User $user): \Illuminate\Http\RedirectResponse
{
    $request->validate([
        'name' => 'required',
        'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
    ]);

    $user->name = $request->input('name');

    if ($request->hasFile('avatar')) {
        $file = $request->file('avatar');
        $filePath = $file->storeAs('avatars', $user->id . '.' . $file->guessExtension());
        if ($user->image) {

            Storage::disk()->delete($user->image->path);
            $user->image->path = $filePath;
//            dd($user->image);

        } else {
            $fileUrl = Storage::disk('local')->url($filePath);
            $user->image()->create(['path' => $fileUrl]);
        }
    }

    $user->save();
//    dd($user->image);
    $request->session()->flash('status', 'The resource was updated successfully');
    return redirect()->route('users.show', ['user' => $user]);
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
