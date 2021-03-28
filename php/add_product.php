
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Add Product</title>
        <link rel="stylesheet" href="../css/bootstrap.css">
        <script src="../js/jquery.min.js"></script>

        <script>
            $(function () {
                console.log('document loaded');     
                var selectGrandCategory = $("#grand_category");
                var selectCategory = $("#category");
                var selectSubCategory = $("#sub-category") ;
                var jsonData;

                $.ajax({
                    url: '../json/grand_categories.json',
                    type: 'post', 
                    success: function (data) {
                        var gCategories = data["grand_categories"];
                        gCategories.forEach(function (element) {
                            selectGrandCategory.append("<option>" + element + "</option");
                        }, this);
                        loadCategory();
                    }
                });

                selectGrandCategory.change(function() {
                    loadCategory();
                });

                selectCategory.change(function() {

                    loadSubCategory();
                });

                function loadCategory () {

                    $.getJSON("../json/" + selectGrandCategory.val() + ".json", function (data) {
                        console.log('json-data', data);
                        jsonData = data;
                        var categories = data.categories;
                        selectCategory.empty();                    
                        categories.forEach(function(element) {
                            selectCategory.append("<option>" + element + "</option>");
                        }, this);
                        loadSubCategory();

                    });
                }

                function loadSubCategory() {
                    var sub_categories = jsonData.sub_categories[selectCategory.val()];
                    selectSubCategory.empty();
                    sub_categories.forEach(function(element) {
                        selectSubCategory.append("<option>" + element + "</option>");
                    }, this);
                }
                // $("#product_form").submit(function(e) {
                //     console.log('form submited');
                //     $.ajax({
                //         type:"POST",
                //         url: "php/add_product.php",
                //         cache: false,
                //         contentType: false,
                //         processData: false,
                //         data: $("#product_form").serialize(),
                //         success: function(result) {
                //             console.log('form-result', result);
                //             alert(result);
                //         }
                //     })
                //     e.preventDefault();
                // });

            });
        </script>
        <style>

        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <h2 >Add Product</h2>


                    <form id="product_form" action="add_product.php" method="post" enctype="multipart/form-data">
                        <fieldset>
                            <div class="form-group">
                                Select image to upload:
                                <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
                            </div>
                            <div class="form-group">
                                select grand category:
                                <select name="grand_category" class="form-control" id="grand_category"></select>
                            </div>
                            <div class="form-group">
                                Select category:
                                <select name="category" class="form-control" id="category">
                                </select>
                            </div>
                            <div class="form-group">
                                Select sub-category:
                                <select name="sub_category" class="form-control" id="sub-category">
                                </select>
                            </div>
                            <div class="form-group">
                                Price:
                                <input type="number" class="form-control" name="price" id="price">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-block btn-primary" value="Add">
                            </div>
                        </fieldset>
                    </form>
                    <?php 

                    // Check if image file is a actual image or fake image
                    if(isset($_POST["submit"])) {
                        $target_dir = "../img/";
                        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                        $uploadOk = 1;
                        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

                        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                        if($check !== false) {
                            echo "File is an image - " . $check["mime"] . ".";
                            $uploadOk = 1;
                        } else {
                            echo "File is not an image.";
                            $uploadOk = 0;
                        }
                        // Check if file already exists
                        if (file_exists($target_file)) {
                            echo "Sorry, file already exists.";
                            $uploadOk = 0;
                        }
                        // Check file size
                        if ($_FILES["fileToUpload"]["size"] > 500000) {
                            echo "Sorry, your file is too large.";
                            $uploadOk = 0;
                        }
                        // Allow certain file formats
                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                           && $imageFileType != "gif" && $imageFileType != "jfif" ) {
                            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $uploadOk = 0;
                        }
                        // Check if $uploadOk is set to 0 by an error
                        if ($uploadOk == 0) {
                            echo "Sorry, your file was not uploaded.";
                            // if everything is ok, try to upload file
                        } else {
                            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                                echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                                $grand_category = $_POST["grand_category"];
                                $category = $_POST["category"];
                                $sub_category = $_POST["sub_category"];
                                $price = $_POST["price"];
                                include("connection.php");

                                $query = "insert into products values('','$grand_category','$category', '$sub_category', '$price', '$target_file')";
                                mysqli_query($con, $query);

                            } else {
                                echo "Sorry, there was an error uploading your file.";
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>