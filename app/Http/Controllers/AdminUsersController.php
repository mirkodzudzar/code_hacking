<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Role;
use App\Http\Requests\UsersRequest;
use App\Http\Requests\UsersEditRequest;
use App\Photo;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $users = User::all();

      return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id')->all();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        if(trim($request->password) == '')
        {

          $input = $request->except('password');

        }
        else
        {

          $input = $request->all();
          $input['password'] = bcrypt($request->password);

        }

        if($file = $request->file('photo_id'))
        {

          $name = time() . $file->getClientOriginalName();

          $file->move('images', $name);

          $photo = Photo::create(['file' => $name]);

          $input['photo_id'] = $photo->id;

        }
        else
        {

          $input['photo_id'] = Photo::id_of_no_photo;

        }

        $input['password'] = bcrypt($request->password);

        User::create($input);

        Session::flash('created_user', 'The user '.$request->name.' has been created!');

        //Using the global helper shortcut
        return redirect('/admin/users');

        //Same redirections

        //Method that's pointing to a aparticular route name
        // return redirect()->route('admin.users.index');
        //
        //Using the global helper to generate a redirect response
        // return redirect()->to('/admin/users');
        //
        //Using the facade to generate a redirect response
        // return Redirect::to('/admin/users');


        //Aborting the request

        //Showing a page with proper message
        //abort(403, 'You cannot do that!');
        //
        //It's going to abort and show 403 page, unless we entered a password
        //abort_unless($request->has('password'), 403);
        //
        //Abort when user is admin
        //abort_if($request->user()->isAdmin(), 403);


        //Custom responses

        //It'll return a mesasge - Hello world
        //return response()->make('Hello world');
        //
        //Returns all users in arrays
        //return response()->json(User::all());
        //
        //Returns a file that is going to be downloaded
        //return response()->download('somefilefordownloading.pdf','myfile.pdf');
        //
        //Returns a file in a browser
        //return response()->file('Mirko.jpg','myfile.jpg');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('admin/users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        $roles = Role::pluck('name', 'id')->all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersEditRequest $request, $id)
    {
      $user = User::findOrFail($id);

      if(trim($request->password) == '')
      {

        $input = $request->except('password');

      }
      else
      {

        $input = $request->all();
        $input['password'] = bcrypt($request->password);

      }

      if($file = $request->file('photo_id'))
      {

        $name = time() . $file->getClientOriginalName();

        $file->move('images', $name);

        $photo = Photo::create(['file' => $name]);

        $input['photo_id'] = $photo->id;

      }
      else
      {

        $input['photo_id'] = $user->photo->id;

      }

      $user->update($input);

      Session::flash('updated_user', 'The user '.$request->name.' has been updated!');

      return redirect('/admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if($user->photo->id !== 1)
        {

          unlink(public_path() . $user->photo->file);

        }

        $user->delete();

        Session::flash('deleted_user', 'The user '.$user->name.' has been deleted!');

        return redirect('admin/users');
    }
}
