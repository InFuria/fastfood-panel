<?php

namespace App\Http\Controllers\Admin;

use App\StoreCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

    public function index()
    {
        $cat = StoreCategory::all();

        return View('admin.category.index',['data' => $cat,'link' => env('admin').'/category/']);
    }


    public function create()
    {
        return View('admin.category.add',['data' => new StoreCategory,'form_url' => env('admin').'/category']);

    }


    public function store(Request $request)
    {
        $category = new StoreCategory;
        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();

        return redirect()->to('admin/category')->with('message','Nuevo registro agregado con éxito.');
    }


    public function show($id)
    {
        //
    }


    public function edit(StoreCategory $category)
    {
        return View('admin.category.edit',['data' => $category,'form_url' => env('admin').'/category/'.$category->id]);
    }


    public function update(Request $request, StoreCategory $category)
    {
        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();

        return redirect()->to('admin/category')->with('message','Se ha actualizado el registro con éxito.');
    }

    public function delete(StoreCategory $id)
    {
        $id->delete();

        return redirect()->to('admin/category')->with('message','Se ha eliminado el registro con éxito.');
    }

    public function status(StoreCategory $id)
    {
        $id->status = !$id->status;
        $id->save();

        return redirect()->to('admin/category')->with('message','Se ha actualizado el estado con éxito.');
    }
}
