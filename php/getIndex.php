<?php
    include('connection.php');

    $category = $_POST["category"];
    $sub_category = $_POST["sub-category"];
    $top_nav = $_POST["top_nav"];

    $catLen = strlen($category);
    $subCatLen = strlen($sub_category);
    $query = "select * from products; ";
    
    if (strlen($top_nav) > 0) {
        $query = "select * from products where grand_category='$top_nav'; ";
    }
    if ($catLen > 0 && $subCatLen == 0) {
        $query = "select * from products where grand_category='$top_nav' and category='$category';";
    } else if ($catLen > 0 && $subCatLen > 0) {
        $query = "select * from products where grand_category='$top_nav' and category='$category' and sub_category='$sub_category';";
    }
    
    $result = mysqli_query($con, $query);
    
    $products = array();
    while ($row = mysqli_fetch_assoc($result)){ 
        $product = array('category'=>$row['category'],
        'sub_category' => $row['sub_category'],
        'price' => $row['price'],
        'image_path' => $row['image_path'],
        'id' => $row['id']
        );
        //echo $product;
        array_push($products, $product);
    }
    
    echo json_encode($products);
?>