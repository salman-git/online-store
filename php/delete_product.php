<html>
    <head>
        <script src="../js/jquery.min.js"></script>
        <style>
           
        </style>
        <script>
            var products
            $(function() {
              products = $("#products");
              loadContent();
            });

            function loadContent() {
                products.empty();
                $.ajax({
                    url: 'getIndex.php',
                    type: 'post',
                    data: { "category": "", "sub-category": "" },
                    success: function (result) {
                        var productsArary = JSON.parse(result);
                        console.log('getIndex result: ', productsArary);

                        productsArary.forEach(function (product) {
                            products.append("<div><img src='" + product.image_path + "'><br>" +
                                "<b>" + + product.price + "</b>" +
                                "<button onclick=\"deleteProduct(" + product.id + ")\">delete</button>",
                                "</div>");
                        }, this);
                    }
                });
            }

            function deleteProduct(id){
                console.log('deleting ...', id);
                $.ajax({
                    url: 'delete_product.php',
                    type: 'post',
                    data: {'id': id},
                    success: function (response) {
                        console.log(response);
                        loadContent();
                    }
                });
            }

            
        </script>
    </head>
    <body>
        <div id='products'></div>

        <?php
            include ('connection.php');
           

            $id = $_POST['id'];

            $query = "delete from products where id = $id";
            mysqli_query($con, $query);
        ?>
    </body>

</html>