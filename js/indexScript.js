var products, navigation, cur_top_nav; // top_nav is an html element while cur_top_nav is currently selected nav
var orders;
$(function () {
    var ordersString = sessionStorage.getItem('cart');
    if (ordersString != null){
        orders = JSON.parse(ordersString);
    } else 
        orders = [];

    var jsonData;
    navigation = $("#navigation");
    products = $("#products");
    
    cur_top_nav = "";


    $.ajax({
        url: '../json/grand_categories.json',
        type: 'post',
        success: function (result) {
            console.log('grand', result);
            var categories = result['grand_categories'];
            var topNav = $("#top_nav");
            categories.forEach(function (element) {
                topNav.append('<a style="margin-left:5%;" onclick=\"onTopNavClick(this.innerText)\">' + element + '</a>');
            }, this);
        }
    });
    loadMenu("");
    loadContent("", "");

});


function loadMenu (curMenu) {
     
    if (curMenu.length <= 0){
        //navigation.slideUp('fast');
        return;
    }
    navigation.slideUp('fast');

    navigation.slideDown('slow');
    $.ajax({
        // loading navigation menu from json file
        url: '../json/' + curMenu + '.json',
        type: 'post',
        success: function (result) {
            console.log('ajax response: ', result);
            jsonData = result;
            var categories = jsonData["categories"];
            // navigation.append("<ul>");
            var navMenu = $("#nav_menu_list");
            navMenu.empty();
            categories.forEach(function (category) {
                navMenu.append("<li><b onclick=\"onCategoryClick(this.innerText)\">" + category + "</b></li>");
                var sub_categories = jsonData.sub_categories[category];
                navMenu.append("<ul id='" + category + "'>");
                var subNavMenu = $("#" + category);
                sub_categories.forEach(function (sub_category) {
                    subNavMenu.append("<li><b onclick=\"onSubCategoryClick('" + category + "',this.innerText)\">" + sub_category + "</b></li>");
                }, this);


            }, this);

        }
    });

}
function onTopNavClick(menuItem) {
    cur_top_nav = menuItem;
    loadMenu(cur_top_nav);
    loadContent("", "");
}

function onCategoryClick(category) {
    console.log("category selected " + category);
    loadContent(category, "");
}

function onSubCategoryClick(category, sub_category) {
    console.log("sub category clicked " + category + sub_category);
    loadContent(category, sub_category);

}

function loadContent(category, sub_category) {
     console.log('cur top nav', cur_top_nav);
    products.empty();
    $.ajax({
        url: '../php/getIndex.php',
        type: 'post',
        data: {"top_nav": cur_top_nav, "category": category, "sub-category": sub_category },
        success: function (result) {
            var productsArary = JSON.parse(result);
            console.log('getIndex result: ', productsArary);

            productsArary.forEach(function (product) {
                products.append("<div class='col-sm-4 text-center'><img src='" + product.image_path + "'><br>" +
                    "<b>" + + product.price + "</b>" +
                    "<div id='shopcart'><i class='fa fa-shopping-cart fa-lg' aria-hidden='true'></i><b onclick=addtocart_onclick(" + JSON.stringify(product) + ")>Add to Cart</b></div>",
                    "</div>");
            }, this);
        }
    });
}

function addtocart_onclick(product) {
    console.log('orders', product);
    product["quantity"] = 1;
    var isOldProduct = false;
    for(var i = 0; i < orders.length; i++) {
        if (product.id == orders[i].id) {
            orders[i].quantity += 1;
            isOldProduct = true;
        }
    }
    if (!isOldProduct){
        orders.push(product);
    }
    var orderString = JSON.stringify(orders);
    sessionStorage.setItem('cart', orderString);

    var j = JSON.parse(sessionStorage.getItem('cart'));
    console.log('cart object', j);
}
