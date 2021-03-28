<?php

    include('connection.php');

    $name=$_POST['name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $address=$_POST['address'];
    $orderDetails=json_decode($_POST['orderDetails'], true); // orderDetails is array
    $bill = 0;
   for($i = 0; $i < sizeof($orderDetails); $i++) {
        $quantity = $orderDetails[$i]['quantity'];
        $price = $orderDetails[$i]['price'];
        $bill += $price * $quantity;
    }

    $query = "insert into orders values('','$name','$address','$phone','$address', 'PENDING', '$bill')";
    mysqli_query($con, $query);
    $lastRecordId =  mysqli_insert_id($con);
    echo $lastRecordId;
    for($i = 0; $i < sizeof($orderDetails); $i++) {
        $id = $orderDetails[$i]['id'];
        $quantity = $orderDetails[$i]['quantity'];
         $price = $orderDetails[$i]['price'];
        $q = "insert into order_details values ('','$lastRecordId','$id','$quantity');";
        mysqli_query($con, $q);
        echo $price * $quantity;
    }
    
    
?>