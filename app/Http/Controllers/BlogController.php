<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Blog\BlogInterface as BlogInterface;

class BlogController extends Controller
{
  
    public function __construct(BlogInterface $blog)
    {
        $this->blog = $blog;
    }

    public function index(Request $request)
    {
        $data= $this->blog->index($request);
        return $data;
    }

    
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        $data = $this->blog->store($request);
        return $data;
    }

   
    public function show($id)
    {
       
    }

    
    public function edit(Request $request, $id)
    {
         $data=$this->blog->edit($request, $id);
        return $data;
    }

    
    public function update(Request $request, $id)
    {
        $data=$this->blog->update($request, $id);
        return $data;
    }

   
    public function destroy($id)
    {
        $data=$this->blog->destroy($id);
        return $data;
    }
}
