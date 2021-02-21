<?php
namespace App\Repositories\User;


interface UserInterface {


    public function index($request);

     
    public function create();

   
    public function store($request);

   
    public function show($id);

    
    public function edit($request, $id);

    
    public function update($request,  $id);

   
    public function destroy($id);

    
    public function profile();


     public function session();


    public function logout();


    public function avatar($request);

    public function changePass($request);
}