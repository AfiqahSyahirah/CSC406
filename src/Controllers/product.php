<?php 
use Slim\Http\Request; //namespace 
use Slim\Http\Response; //namespace 

//include productProc.php file (new)
include __DIR__ . '/../function/productProc.php'; 

//read requestdb   //kalau localhost:8888/requestdb Just baca requestdb 
$app->get('/requestdb', function (Request $request, Response $response, array $arg)
{ 
    $data = getAllProducts($this->db);
    if (is_null($data)){
    return $this->response->withJson(array('error' => 'no data'), 404); 
    }

    return $this->response->withJson(array('data' => $data), 200); //display all the product
});

//request table product by condition (new)  //Akan amik data from table product
$app->get('/product/[{id}]', function ($request, $response, $args){
    $productId = $args['id']; 
    if (!is_numeric($productId)) { 
        return $this->response->withJson(array('error' => 'numeric paremeter required'), 422); }
        $data = getProduct($this->db,$productId); 
        if (empty($data)) { 
            return $this->response->withJson(array('error' => 'no data'), 404); 
        }
        return $this->response->withJson(array('data' => $data), 200); 
    });

//24.8.2020 Post at Postman
    $app -> post ('/InsertProduct', function (Request $request, Response $response, array $args) 
    {
        $form_data=$request->getParsedBody();
        $data = createProduct ($this->db, $form_data);
        if (empty($data)) { 
            return $this->response->withJson(array('error' => 'NO DATA INSERTED'), 404); 
        }
        return $this ->response->withJson (array('data' => 'DATA INSERT SUCCESSFULL'), 200);
    });

//Delete row  27.8.2020
$app->delete('/product/del/[{id}]', function ($request, $response, $args){ 
    $productId = $args['id']; 
    if (!is_numeric($productId)) 
    { 
        return $this->response->withJson(array('error' => 'NUMERIC PARAMETER REQUIRED'), 422); 
    } 
    
    $data = deleteProduct($this->db,$productId); 
    if (empty($data)) 
    { 
        return $this->response->withJson(array($productId=> 'IS SUCCESSFULLY DELETED'), 202);}; 
    });

//PUT Table Products
$app->put('/products/put/[{id}]', function ($request, $response, $args){
    $productId = $args['id'];
    $date = date("Y-m-j h:i:s");
   
   if (!is_numeric($productId)) 
   {
    return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
   }
    $form_dat=$request->getParsedBody();
   
   $data=updateProduct($this->db,$form_dat,$productId,$date);
   //if ($data <=0)
   return $this->response->withJson(array('data' => 'SUCCESSFULLY UPDATED'), 200);
   });
  
  


// ASSIGNMENT 1 
//DISPLAY THE CATEGORIES TABLE
$app->get('/AllCategoriesList', function (Request $request, Response $response, array $arg)
{ 
    $data = getAllCategories($this->db);
    if (is_null($data))
    {
    return $this->response->withJson(array('ERROR' => 'NO DATA'), 404); 
    }

    return $this->response->withJson(array('LIST OF CATEGORIES' => $data), 200); //display all the product
});

//DISPLAY THE CATEGORIES BY NAME
$app->get('/Category/[{name}]', function ($request, $response, $args)
{
    $categoryname = $args['name']; 
    if (is_null ($categoryname))
     { 
        return $this->response->withJson(array('ERROR' => 'NUMERIC PARAMETER REQUIRED'), 422); 
     }
        $data = getCategory($this->db, $categoryname); 
        if (empty($data)) 
        { 
            return $this->response->withJson(array('ERROR' => 'NO DATA'), 404); 
        }
        return $this->response->withJson(array('DATA BY NAME' => $data), 200); 
    });

//INSERT NEW CATEGORY DATA
$app -> post ('/InsertNewCategory', function (Request $request, Response $response, array $args) 
{
    $form_data=$request->getParsedBody();
    $data = createNewCategory ($this->db, $form_data);
    if (empty($data)) 
        { 
        return $this->response->withJson(array('ERROR' => 'NO DATA INSERTED'), 404); 
        }
        return $this ->response->withJson (array('DATA' => 'DATA INSERT SUCCESSFULL'), 200);
    });

//DELETE CATEGORY DATA BY NAME
$app->delete('/Category/del/[{name}]', function ($request, $response, $args)
{ 
    $categoryname = $args['name']; 
    if (is_null ($categoryname)) 
    { 
        return $this->response->withJson(array('ERROR' => 'NUMERIC PARAMETER REQUIRED'), 422); 
    } 
    
    $data = deleteCategory($this->db,$categoryname); 
    if (empty($data)) 
    { 
        return $this->response->withJson(array($categoryname=> 'IS SUCCESSFULLY DELETED'), 202);
    }
});

//EDIT OR UPDATE CATEGORY DATA BY NAME
$app->put('/Category/put/[{name}]', function ($request, $response, $args)
{
 
    $categoryname = $args['name'];
    $date = date("Y-m-j h:i:s");
        
    if (is_null ($categoryname)) 
    {
        return $this->response->withJson(array('ERROR' => 'NUMERIC PARAMETER REQUIRED'), 422);
    } 

    $form_dat=$request->getParsedBody();
    $data=updateCategory($this->db,$form_dat,$categoryname,$date);
    
    //  if ($data <=0)
    return $this->response->withJson(array('data' => 'SUCCESSFULLY UPDATED'), 200);
});