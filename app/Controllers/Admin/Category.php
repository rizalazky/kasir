<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\ProductModel;

class Product extends BaseController
{
    public function index()
    {
        $pager = \Config\Services::pager();

        $categoryModel = new CategoryModel();
        $data['products'] = $productsModel->paginate(10);
        $data['pager'] = $productsModel->pager;

        return view('admin/categoy/index',$data);
    }

    public function store(){
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'product_name' => ['label'=>'Product Name','rules'=>'required'],
            'product_price' => ['label'=>'Product Price','rules'=>'required'],
            'product_desc' => ['label'=>'Product Description','rules'=>'required'],
            'category_id' => ['label'=>'Category','rules'=>'required'],
        ]);
        $response;
        $isDataValid = $validation->withRequest($this->request)->run();
        if($isDataValid){
            $data =[
                "product_name" =>$this->request->getPost("product_name"),
                "product_price" =>$this->request->getPost("product_price"),
                "product_desc" =>$this->request->getPost("product_desc"),
                "category_id" =>$this->request->getPost("category_id")
            ];

            $response = [
                "status" => true,
                "message" => "Succes Create Product",
                "data" => $data
            ];

            $productsModel = new ProductModel;
            $productsModel->save($data);
        }else{
            $response = [
                "status" => false,
                "message" => "Failed Create Product",
                "data" => $validation->getErrors()
            ];
        }
        
        return json_encode($response);
    }
}
