<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Repositories\BlogReply\BlogReplyInterface as BlogReplyInterface;

class BlogReplyController extends Controller
{
    
    public function __construct(BlogReplyInterface $blogreply)
    {
        $this->blogreply = $blogreply;
    }

    public function index(Request $request)
    {
        $data= $this->blogreply->index($request);
        return $data;
    }

    
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        $data = $this->blogreply->store($request);
        return $data;
    }

   
    public function show($id)
    {
       
    }

    
    public function edit($id)
    {
         $data=$this->blogreply->edit($request, $id);
        return $data;
    }

    
    public function update(Request $request, $id)
    {
        $data=$this->blogreply->update($request, $id);
        return $data;
    }

   
    public function destroy($id)
    {
        $data=$this->blogreply->destroy($id);
        return $data;
    }
}
