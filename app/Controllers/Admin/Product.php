<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\ProductModel;

class Product extends BaseController
{
    public function index()
    {
        $productsModel = new ProductModel();
        $data['products'] = $productsModel->paginate(10);
        $data['pager'] = $productsModel->pager;

        return view('admin/product/index',$data);
    }

    public function store(){
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'product_name' => ['label'=>'Product Name','rules'=>'required|is_unique[products.product_name]'],
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

    public function update(){
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'product_name' => ['label'=>'Product Name','rules'=>'required|is_unique[products.product_name]'],
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

            

            $productsModel = new ProductModel;
            $productsModel->save($data);

            $response = [
                "status" => true,
                "message" => "Succes Create Product",
                "data" => $data
            ];
        }else{
            $response = [
                "status" => false,
                "message" => "Failed Create Product",
                "data" => $validation->getErrors()
            ];
        }
        
        return json_encode($response);
    }

    public function delete($id){
        $productsModel = new ProductModel();
        $productsModel->delete($id);
        $response = [
            "status" => true,
            "message" => "Succes Delete Product"
        ];

        return json_encode($response);
    }
}
