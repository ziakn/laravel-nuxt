<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Category\CategoryInterface as CategoryInterface;

class CategoryController extends Controller
{

     public function __construct(CategoryInterface $category)
    {
        $this->category = $category;
    }

    public function index(Request $request)
    {
        $data= $this->category->index($request);
        return $data;
    }

    
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        $data = $this->category->store($request);
        return $data;
    }

   
    public function show($id)
    {
       
    }

    
    public function edit(Request $request, $id)
    {
        $data=$this->category->edit($request, $id);
        return $data;
    }

    
    public function update(Request $request, $id)
    {
        $data=$this->category->update($request, $id);
        return $data;
    }

   
    public function destroy($id)
    {
        $data=$this->category->destroy($id);
        return $data;
    }
}
