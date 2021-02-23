<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\User\UserInterface as UserInterface;

class UserController extends Controller
{
    
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function index(Request $request)
    {
        $data= $this->user->index($request);
        return $data;
    }

    
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        $data = $this->user->store($request);
        return $data;
    }

   
    public function show($id)
    {
        $data=$this->user->show($id);
        return $data;
    }

    
    public function edit(Request $request, $id)
    {
        $data = $this->user->edit($request, $id);
        return $data;
    }

    
    public function update(Request $request, $id)
    {
        $data=$this->user->update($request, $id);
        return $data;
    }

   
    public function destroy($id)
    {
        $data=$this->user->destroy($id);
        return $data;
    }

    public function profile()
    {
        $data=$this->user->profile();
        return $data;
    }

    public function session()
    {
        $data=$this->user->session();
        return $data;
    }

    public function logout()
    {
        $data=$this->user->logout();
        return $data;
    }


    public function avatar(Request $request)
    {
        $data=$this->user->avatar($request);
        return $data;
    }

    public function changePass(Request $request)
    {
        $data=$this->user->changePass($request);
        return $data;
    }
}
