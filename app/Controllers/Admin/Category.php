<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\CategoryModel;

class Category extends BaseController
{
    public function index()
    {
        $pager = \Config\Services::pager();

        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->paginate(10);
        $data['pager'] = $categoryModel->pager;
        $data['pageTitle'] = 'Categories';

        return view('admin/category/index',$data);
    }

    public function store(){
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'category_name' => ['label'=>'Category Name','rules'=>'required|is_unique[categories.category_name]']
        ]);
        $response;
        $isDataValid = $validation->withRequest($this->request)->run();
        if($isDataValid){
            $data =[
                "category_name" =>$this->request->getPost("category_name")
            ];

            $response = [
                "status" => true,
                "message" => "Succes Create Category",
                "data" => $data
            ];

            $productsModel = new CategoryModel;
            $productsModel->save($data);
        }else{
            $response = [
                "status" => false,
                "message" => "Failed Create Category",
                "data" => $validation->getErrors()
            ];
        }
        
        return json_encode($response);
    }

    public function edit($id){
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'category_name' => ['label'=>'Category Name','rules'=>'required']
        ]);
        $response;
        $isDataValid = $validation->withRequest($this->request)->run();
        if($isDataValid){
            $data =[
                "category_name" =>$this->request->getPost("category_name")
            ];

            $response = [
                "status" => true,
                "message" => "Succes Update Category",
                "data" => $data
            ];

            $productsModel = new CategoryModel;
            try {
                //code...
                $productsModel->update($id,$data);
            } catch (\Throwable $th) {
                //throw $th;
                
                $response = [
                    "status" => false,
                    "message" => "Failed Update Category",
                    "data" => $productsModel->errors()
                ];
                
            }
        }else{
            $response = [
                "status" => false,
                "message" => "Failed Update Category",
                "data" => $validation->getErrors()
            ];
        }
        
        return json_encode($response);
    }

    public function delete($id){
        $categoryModel = new CategoryModel();
        $categoryModel->delete($id);
        $response = [
            "status" => true,
            "message" => "Succes Delete Category"
        ];

        return json_encode($response);
    }
}
