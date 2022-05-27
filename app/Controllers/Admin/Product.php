<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use CodeIgniter\Files\File;

class Product extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $productsModel = new ProductModel();
        $categoryModel = new CategoryModel();
        $pager=service('pager');
        $page=(($this->request->getVar('page') !==null ) ? $this->request->getVar('page') : 1) - 1; 
        $perPage =  10; //offset
        $offset = $page * $perPage;
        
        $builder = $db->table('products');
        $builder->select('
                products.id,
                products.product_name,
                products.category_id,
                products.product_price,
                products.product_desc,
                products.product_image,
                categories.category_name,
        ');
        $builder->join('categories', 'categories.id = products.category_id');
        $data['products'] = $builder->get($perPage,$offset)->getResult();

        $total = count($productsModel->findAll());
       
        $pager->makeLinks($page+1,$perPage,$total);

        $data['pager'] = $pager;

        $data['categories'] = $categoryModel->findAll();
        $data['pageTitle'] = 'Products';

        return view('admin/product/index',$data);
    }

    public function upload($img)
    {
        
        // $img = $this->request->getFile('product_image');

        if (!$img->hasMoved()) {
            $newName = $img->getRandomName();
            $img->move(ROOTPATH . 'public/img/products/',$newName);
            // $filepath = WRITEPATH . 'uploads/images/products/' . $img->store();

            $data = [
                'status'=> true,
                'name_file' => $newName
            ];

            return  $data;
        } else {
            $data = [
                'status'=> false,
                'data' => ['errors'=>'The file has already been moved.']
            ];

            return  $data;
        }
    }

    public function store(){
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'product_name' => ['label'=>'Product Name','rules'=>'required|is_unique[products.product_name]'],
            'product_price' => ['label'=>'Product Price','rules'=>'required'],
            'product_desc' => ['label'=>'Product Description','rules'=>'required'],
            'category_id' => ['label'=>'Category','rules'=>'required'],
            'product_image' => [
                'label' => 'Product Image',
                'rules' => 'uploaded[product_image]'
                    . '|is_image[product_image]'
            ],
        ]);
        $response;
        $isDataValid = $validation->withRequest($this->request)->run();
        if($isDataValid){

            $uploadImage = $this->upload($this->request->getFile('product_image'));
            if(!$uploadImage){
                return json_encode($uploadImage);
            }

            // return json_encode($uploadImage['name_file']);
            $data =[
                "product_name" =>$this->request->getPost("product_name"),
                "product_price" =>$this->request->getPost("product_price"),
                "product_desc" =>$this->request->getPost("product_desc"),
                "category_id" =>$this->request->getPost("category_id"),
                "category_id" =>$this->request->getPost("category_id"),
                "product_image" =>$uploadImage['name_file']
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

    public function edit($id){
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
                "category_id" =>$this->request->getPost("category_id"),
            ];

            if($this->request->getFile('product_image')){
                $uploadImage = $this->upload($this->request->getFile('product_image'));

                if(!$uploadImage){
                    return json_encode($uploadImage);
                }
                $data['product_image'] = $uploadImage['name_file'];
            }
            

            $response = [
                "status" => true,
                "message" => "Succes Update Product",
                "data" => $data
            ];

            $productsModel = new ProductModel;
            try {
                
                $productsModel->update($id,$data);
            } catch (\Throwable $th) {
                //throw $th;
                
                $response = [
                    "status" => false,
                    "message" => "Failed Update Product",
                    "data" => $productsModel->errors()
                ];
                
            }

        }else{
            $response = [
                "status" => false,
                "message" => "Failed Update Product",
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
