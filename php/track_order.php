<?php
    include('connection.php');
    $order_id = $_POST['id'];
    $query = "SELECT order_details.quantity, products.price, products.image_path, orders.customer_name, orders.status, orders.delivery_address, orders.total_bill from order_details INNER JOIN products ON order_details.product_id = products.id INNER JOIN orders on orders.order_id where orders.order_id=$order_id";
    $result = mysqli_query($con, $query);
    $records = array();
    while($row = mysqli_fetch_assoc($result)) {
        array_push($records, $row);
    }
    echo json_encode($records);
?>