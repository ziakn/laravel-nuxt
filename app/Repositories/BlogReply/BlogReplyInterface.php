<?php
namespace App\Repositories\BlogReply;


interface BlogReplyInterface {


    public function index($request);

     
    public function create();

   
    public function store($request);

   
    public function show($id);

    
    public function edit($request, $id);

    
    public function update($request, $id);

   
    public function destroy($id);

    
}