<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Sharks</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="http://ajax.cdnjs.com/ajax/libs/underscore.js/1.3.3/underscore-min.js"></script>
    <script src="http://ajax.cdnjs.com/ajax/libs/backbone.js/0.9.2/backbone-min.js"></script>
    <script src=<?php echo base_url() . "assets/js/App.js" ?>></script>
    <script src=<?php echo base_url() . "assets/js/models/User.js" ?>></script>
    <script src=<?php echo base_url() . "assets/js/models/WishListItem.js" ?>></script>

</head>

<body>
<div class="container" id="main-container"></div>
    <div id="tank"></div>
    <!-- And here is the template -->
    <script type="text/template" id="tank-template">
        <p>Swim Away {{name}}</p>
    </script>

    <script type="text/template" id="login-template">       
            <form>
                <label for="user_email"><b>Email</b></label>
                <input type="text" placeholder="hello@goo.com" name="user_email" id="login_user_email" value="{{user_email}}">

                <label for="user_password"><b>Password</b></label>
                <input type="password"  name="user_password" id="login_user_password" value ="{{user_password}}">
                    
                <button type="submit">Login</button>
                <button type="reset">Reset</button>
            </form>
    </script>
    <script type="text/template" id="register-template">
            <form>
                <label for="user_fname"><b>First Name</b></label>
                <input type="text" placeholder="John" name="user_fname" id="register_user_fname">

                <label for="user_lname"><b>Last Name</b></label>
                <input type="text" placeholder="Paul" name="user_lname" id="register_user_lname">

                <label for="wishlist_name"><b>Wishlist Name</b></label>
                <input type="text" placeholder="Christmas List 2021" name="wishlist_name" id="register_wishlist_name">

                <label for="wishlist_description"><b>Wishlist Description</b></label>
                <input type="text" placeholder="Christmas List 2021 for the Children" name="wishlist_description" id="register_wishlist_description">

                <label for="wishlist_occasion"><b>Wishlist Occasion</b></label>
                <input type="text" placeholder="Christmas List 2021 for the Children" name="wishlist_occasion" id="register_wishlist_occasion">

                <label for="user_email"><b>Email</b></label>
                <input type="text" placeholder="hello@goo.com" name="user_email" id="register_user_email">

                <label for="user_password"><b>Password</b></label>
                <input type="password"  name="user_password" id="register_user_password">
                    
                <button type="submit">Register</button>
                <button type="reset">Reset</button>
            </form>
    </script>
    <script type="text/template" id="view-wishlist-template">
            <% if(wishList.length>0) { %>
                <div class="row w-100">
                    <h1 class="text-center w-100">WishList</h1>
                </div>
                <div class="row w-100 border-bottom border-dark ">
                    <div class="col-6 p-0 col-md-3">
                        <h4 class="text-primary">Title</h4>
                    </div>
                    <div class="col-6 p-0 col-md-3">
                        <h4 class="text-primary">URL</h4>
                    </div>
                    <div class="col-6 p-0 col-md-2">
                        <h4 class="text-primary">Price</h4>
                    </div>
                    <div class="col-6 p-0 col-md-2">
                        <h4 class="text-primary">Priority</h4>
                    </div>
                </div>
            <% } else { %>
                <div class="row mt-5 pt-5">
                    <div class="col-12">
                        <h3 class="text-center">The wishList is empty</h3>
                        <div class="row mt-5 pt-5">
                            <button class="btn text-center m-auto btn-success">
                                Add a new Item
                            </button>
                        </div>
                    </div>
                </div>
            <% } %>
    </script>
    <script type="text/template" id="wishlist-item-template">
            <div class="row border-bottom border-primary w-100">
                <div class="col-6 col-md-3 p-0">
                    <div class="row">
                        <h5 class="heading">{{wli_title}}</h5>
                    </div>
                </div>
                <div class="col-6 col-md-3 p-0">
                    <a href="{{wli_url}}" target="_blank">
                        <h5 class=" text-right">{{wli_url}}</h5>
                    </a>
                </div>
                <div class="col-6 col-md-2 p-0">
                    <h5 class=" text-right">&#163;{{wli_price}}</h5>
                </div>
                <div class="col-6 col-md-2 p-0">
                    <h5 class=" text-right">{{wli_priority}}</h5>
                </div>
                <div class="col-6 col-md-1 p-0">
                    <button>
                        <i class="medium material-icons">edit</i>
                    </button>
                </div>
                <div class="col-6 col-md-1 p-0">
                    <button>
                        <i class="medium material-icons">delete</i>
                    </button>
                </div>
            </div>
    </script>
    <script type="text/template" id="add-wishlist-item-template">
        <form>
            <input type="hidden" name="wli_user_id" value={{wli_user_id}}>
            <label for="wli_title"><b>Title</b></label>
            <input type="text" placeholder="Perfume" name="wli_title" id="add_wli_title">
            <label for="wli_url"><b>URL</b></label>
            <input type="text" placeholder="https://www.tesco.com/groceries/en-GB/products/301869750" name="wli_url" id="add_wli_url">
            <label for="wli_price"><b>Price</b></label>
            <input type="number" step="0.01" placeholder="40.00" name="wli_price" id="add_wli_price">  
            <label for="wli_priority"><b>Priority</b></label>
            <input type="radio" name="wli_priority" value="'A must have">
            <label for="wli_priority_1">A must have</label><br>
            <input type="radio" name="wli_priority" value="Nice to have">
            <label for="wli_priority_2">Nice to have</label><br>  
            <input type="radio" name="wli_priority" value="Only if you can">
            <label for="wli_priority_3">Only if you can</label><br><br>
            <button type="submit">Add Item</button>
            <button type="reset">Reset</button>
        </form>
    </script>
    <script type="text/template" id="edit-wishlist-item-template">
        <form>
            <input type="hidden" name="wli_user_id" value={{wli_user_id}}>
            <label for="wli_title"><b>Title</b></label>
            <input type="text" value={{wli_title}} name="wli_title" id="add_wli_title">
            <label for="wli_url"><b>URL</b></label>
            <input type="text" value={{wli_url}} name="wli_url" id="add_wli_url">
            <label for="wli_price"><b>Price</b></label>
            <input type="number" step="0.01" value={{wli_price}} name="wli_price" id="add_wli_price">  
            <label for="wli_priority"><b>Priority</b></label>
            <input type="radio" name="wli_priority" value="'A must have">
            <label for="wli_priority_1">A must have</label><br>
            <input type="radio" name="wli_priority" value="Nice to have">
            <label for="wli_priority_2">Nice to have</label><br>  
            <input type="radio" name="wli_priority" value="Only if you can">
            <label for="wli_priority_3">Only if you can</label><br><br>
            <button type="submit">Save Changes</button>
            <button type="reset">Reset</button>
        </form>
    </script>

</body>

</html>