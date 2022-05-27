<?php

namespace App\Controllers;
use App\Models\ProductModel;
use App\Models\CategoryModel;


class Home extends BaseController
{
    public function index()
    {
        $productsModel = new ProductModel();
        $data['products']= $productsModel->findAll();
        return view('welcome_message',$data);
    }
}
