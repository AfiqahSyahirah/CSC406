<?php 

//get all products 
function getAllProducts($db) 
{

    $sql = 'Select p.name, p.description, p.price, c.name as category from products p '; 
    $sql .='Inner Join categories c on p.category_id = c.id'; 
    $stmt = $db->prepare ($sql); 
    $stmt ->execute(); 
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}

//get product by id 
function getProduct($db, $productId) 
{
     $sql = 'Select p.name, p.description, p.price, c.name as category from products p '; 
     $sql .= 'Inner Join categories c on p.category_id = c.id '; 
     $sql .= 'Where p.id = :id'; 
     $stmt = $db->prepare ($sql); 
     $id = (int) $productId; $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
     $stmt->execute(); 
     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    }

//insert new product (24.8.2020)
function createProduct($db,$form_data)
{
    $sql = 'Insert into products (name, description, price, category_id, created)';
    $sql .= 'values (:name, :description, :price, :category_id, :created)';
    $stmt = $db -> prepare ($sql);
    $stmt -> bindParam(':name', $form_data['name']);
    $stmt -> bindParam(':description', $form_data['description']);
    $stmt -> bindParam(':price', floatval( $form_data['price']));
    $stmt -> bindParam(':category_id',intval( $form_data['category_id']));
    $stmt -> bindParam(':created', $form_data['created']);
    $stmt->execute();
    return $db ->lastInsertID(); //insert last number.. continue
};

//Delete Product by id  27.8.2020
function deleteProduct($db,$productId) 
{ 
    $sql = ' Delete from products where id = :id'; 
    $stmt = $db->prepare($sql); 
    $id = (int)$productId; 
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
    $stmt->execute(); 
}

//Update Product by id (PUT)
function updateProduct($db,$form_dat,$productId,$date)
{
    $sql = 'UPDATE products SET name = :name , description = :description , price = :price , category_id = :category_id , modified = :modified ';
    $sql .=' WHERE id = :id';

    $stmt = $db->prepare ($sql);
    $id = (int)$productId;
    $mod = $date;

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $form_dat['name']);
    $stmt->bindParam(':description', $form_dat['description']);
    $stmt->bindParam(':price', ($form_dat['price']));
    $stmt->bindParam(':category_id', ($form_dat['category_id']));
    $stmt->bindParam(':modified', $mod , PDO::PARAM_STR);
    $stmt->execute();
  
    $sql1 = 'Select p.name, p.description, p.price, c.name as category from products as p ';
    $sql1 .= 'Inner Join categories c on p.category_id = c.id ';
    $sql1 .= 'Where p.id = :id'; 
    $stmt1 = $db->prepare ($sql1);
    $stmt1->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt1->execute();
    return $stmt1->fetchAll(PDO::FETCH_ASSOC);
    
}

// ASSIGNMENT 1 
//DISPLAY ALL THE CATEGORIES
function getAllCategories($db) 
{

    $sql = 'Select c.ID, c.NAME, c.DESCRIPTION, c.CREATED as CREATED from categories c'; 
    $stmt = $db->prepare ($sql); 
    $stmt ->execute(); 
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}

//DISPLAY THE CATEGORIES BY NAME
function getCategory($db, $categoryname) 
{
     $sql = 'Select c.NAME, c.ID, c.DESCRIPTION, c.CREATED as CREATED from categories c '; 
     $sql .= ' WHERE name = :name';
     $stmt = $db->prepare ($sql); 
     $name = $categoryname; $stmt->bindParam (':name', $name, PDO::PARAM_STR); 
     $stmt->execute(); 
     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
}

//INSERT NEW CATEGORY DATA
function createNewCategory($db,$form_data)
{
    $sql = 'Insert into categories (id, name, description, created)';
    $sql .= 'values (:id, :name, :description, :created)';
    $stmt = $db -> prepare ($sql);
    $stmt -> bindParam(':id', $form_data['id']);
    $stmt -> bindParam(':name', $form_data['name']);
    $stmt -> bindParam(':description', $form_data['description']);
    $stmt -> bindParam(':created', $form_data['created']);
    $stmt->execute();
    return $db ->lastInsertID(); //insert last number.. continue
};

//DELETE CATEGORY DATA BY NAME
function deleteCategory($db,$categoryname) 
{ 
    $sql = ' Delete from categories where name = :name'; 
    $stmt = $db->prepare($sql); 
    $name = $categoryname; 
    $stmt->bindParam(':name', $name, PDO::PARAM_STR); 
    $stmt->execute(); 
};

//EDIT OR UPDATE CATEGORY DATA BY NAME
function updateCategory($db,$form_dat,$categoryname,$date)
    {
        $sql = 'UPDATE categories SET name = :name, id = :id, description = :description , created = :created';
        $sql .=' WHERE name = :name';
    
        $stmt = $db->prepare ($sql);
        $name = $categoryname;
        $mod = $date;
    
        //$stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':name', $form_dat['name']);
        $stmt->bindParam(':id', $form_dat['id']);
        $stmt->bindParam(':description', $form_dat['description']);
        $stmt->bindParam(':created', ($form_dat['created']));
        $stmt->bindParam(':modified', $mod , PDO::PARAM_STR);
        $stmt->execute();
      
        $sql1 = 'Select c.NAME, c.ID, c.DESCRIPTION, c.CREATED as CREATED from categories c '; 
        $sql1 .= 'Where c.NAME = :name'; 
        $stmt1 = $db->prepare ($sql1);
        $stmt1->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt1->execute();
        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
        
    };
