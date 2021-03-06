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
use Illuminate\Support\Facades\Input;

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

      $query = Input::get('query');

      if($query != '')
      {

        $user = User::where('name', 'LIKE', '%' . $query . '%')->orWhere('email', 'LIKE', '%' . $query . '%')->get();

        if(count($user) > 0)
        {

          return view('admin.users.index', compact('users'))->withDetails($user)->withQuery($query);

        }

        return view('admin.users.index', compact('users'))->withMessage('No user found!');
      }

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
        // else
        // {
        //
        //   $input['photo_id'] = Photo::id_of_no_photo;
        //
        // }

        $input['password'] = bcrypt($request->password);

        User::create($input);

        Session::flash('created_user', 'The user '.$request->name.' has been created!');

        return redirect('/admin/users');

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

        if($user->photo)
        {

          unlink(public_path() . $user->photo->file);

          $user->photo->delete();

        }

        $name = time() . $file->getClientOriginalName();

        $file->move('images', $name);

        $photo = Photo::create(['file' => $name]);

        $input['photo_id'] = $photo->id;

      }
      else
      {

        $input['photo_id'] = $user->photo ? $user->photo->id : 0;

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

        if($user->photo)
        {

          unlink(public_path() . $user->photo->file);

          $user->photo->delete();

        }

        $user->delete();

        Session::flash('deleted_user', 'The user '.$user->name.' has been deleted!');

        return redirect('admin/users');
    }
}
