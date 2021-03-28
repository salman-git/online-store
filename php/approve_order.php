<?php
    include('connection.php');
    $order_id = $_POST['id'];
    $order_type = $_POST['type'];
    $status = 'PENDING';
    if ($order_type == 0)
        $status = 'APPROVED';
    else
        $status = 'DELIVERED';
    $query = "update orders set status='$status' where order_id='$order_id'";
    mysqli_query($con, $query);

?>