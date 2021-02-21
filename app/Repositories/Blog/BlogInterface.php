<?php
namespace App\Repositories\Blog;


interface BlogInterface {


    public function index($request);

     
    public function create();

   
    public function store($request);

   
    public function show($id);

    
    public function edit($request, $id);

    
    public function update($request, $id);

   
    public function destroy($id);

    
}