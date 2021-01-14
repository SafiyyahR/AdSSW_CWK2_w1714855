<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Wishlist w1714855</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="http://ajax.cdnjs.com/ajax/libs/underscore.js/1.3.3/underscore-min.js"></script>
    <script src="http://ajax.cdnjs.com/ajax/libs/backbone.js/0.9.2/backbone-min.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src=<?php echo base_url() . "assets/js/app.js" ?>></script>
    <script src=<?php echo base_url() . "assets/js/Router.js" ?>></script>
    <script src=<?php echo base_url() . "assets/js/models/User.js" ?>></script>
    <script src=<?php echo base_url() . "assets/js/models/WishListItem.js" ?>></script>
    <script src=<?php echo base_url() . "assets/js/collections/WishListCollection.js" ?>></script>
    <script src=<?php echo base_url() . "assets/js/views/LoginView.js" ?>></script>
    <script src=<?php echo base_url() . "assets/js/views/RegisterView.js" ?>></script>
    <script src=<?php echo base_url() . "assets/js/views/WishlistView.js" ?>></script>
    <script src=<?php echo base_url() . "assets/js/views/WishlistItemView.js" ?>></script>
    <script src=<?php echo base_url() . "assets/js/views/AddWishlistItemView.js" ?>></script>
    <script src=<?php echo base_url() . "assets/js/views/EditWishlistItemView.js" ?>></script>
    <script src=<?php echo base_url() . "assets/js/functions.js" ?>></script>
    <link href="<?php echo base_url(); ?>assets/css/styles.css" rel="stylesheet" type="text/css">

</head>

<body onload="increaseHeight()" onresize="increaseHeight()">
    <nav id="custom-navbar" class="navbar navbar-expand-lg navbar-light bg-custom sticky-top">
    </nav>
    <div class="container my-5" id="main-container"></div>
    <div class="footer-content text-center bg-secondary">
        <div class="p-2 font-weight-bold">© 2021 Copyright:&nbsp;
            <a class="footer-link" target="_blank" without="true" rel="noopener noreferrer" href="https://www.linkedin.com/in/safiyyah-r-408652132/">Safiyyah Thur Rahman</a>
        </div>
    </div>
    <script type="text/template" id="navbar-template">
        <h4>WishList</h4>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ml-auto h4">
      <% if(!loggedIn) {
          if(name==="Login") {%>
        <li class="nav-item active">
            <a class="nav-link" href="<?php echo base_url() ?>">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url() . 'register' ?>">Register</a>
          </li>
<% } else if( name=== 'Register') { %>
    <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url() ?>">Login</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="<?php echo base_url() . 'register' ?>">Register</a>
          </li>
          <% }else {%>
            <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url() ?>">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url() . 'register' ?>">Register</a>
          </li>
          <%} } else if(name ==="View" & loggedIn){ %>
          <li class="nav-item active">
            <a class="nav-link" href="<?php echo base_url() . "#wishlist/#" ?><%=userId%>">View WishList</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="<?php echo base_url() . '#add/' ?>">Add Item</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="<?php echo base_url() . '#logout' ?>">Logout</a>
          </li>
          <% } else if( name=== 'Add'  & loggedIn) { %>
            <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url() . "#wishlist/#" ?><%=userId%>">View WishList</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="<?php echo base_url() . '#add' ?>">Add Item</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="<?php echo base_url() . '#logout' ?>">Logout</a>
          </li>
          <% }else {%>
            <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url() . "#wishlist/#" ?><%=userId%>">View WishList</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url() . '#add' ?>">Add Item</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="<?php echo base_url() . '#logout' ?>">Logout</a>
          </li>
         <% }%>
      </ul>
    </div>
    </script>
    <script type="text/template" id="login-template">
        <div class="row h-100">
            <div class="col-12">
            <form>
                <div class="form-group">
                <label for="username"><b>Username</b></label>
                <input class="form-control" type="text" placeholder="hello@goo.com" name="username" id="login_username" value="<%=username%>">
                </div>
                <div class="form-group">
                <label for="user_password"><b>Password</b></label>
                <input type="password"  class="form-control" name="user_password" id="login_user_password" value ="<%=user_password%>">
</div>
                <button type="submit" class="btn btn-success" id="btn-login">Login</button>
                <button type="reset" class="btn btn-secondary" >Reset</button>
            </form>
            </div></div>
    </script>
    <script type="text/template" id="register-template">
        <div class="row h-100">
            <div class="col-12">
            <form>
                <div class="form-group">
                <label for="user_fname"><b>First Name</b></label>
                <input type="text"  class="form-control" placeholder="John" name="user_fname" id="register_user_fname">
                </div>
                <div class="form-group">
                <label for="user_lname"><b>Last Name</b></label>
                <input type="text"  class="form-control" placeholder="Paul" name="user_lname" id="register_user_lname">
                </div>
                <div class="form-group">
                <label for="wishlist_name"><b>Wishlist Name</b></label>
                <input type="text"  class="form-control" placeholder="Christmas List 2021" name="wishlist_name" id="register_wishlist_name">
                </div>
                <div class="form-group">
                <label for="wishlist_description"><b>Wishlist Description</b></label>
                <input type="text"  class="form-control" placeholder="Christmas List 2021 for the Children" name="wishlist_description" id="register_wishlist_description">
                </div>
                <div class="form-group">
                <label for="wishlist_occasion"><b>Wishlist Occasion</b></label>
                <input type="text"  class="form-control" placeholder="Christmas List 2021 for the Children" name="wishlist_occasion" id="register_wishlist_occasion">
                </div>
                <div class="form-group">
                <label for="username"><b>Username</b></label>
                <input type="text"  class="form-control" placeholder="hello@goo.com" name="username" id="register_username">
                </div>
                <div class="form-group">
                <label for="user_password"><b>Password</b></label>
                <input type="password" class="form-control" name="user_password" id="register_user_password">
                </div>
                <button type="submit" class="btn btn-success" id="btn-register">Register</button>
                <button type="reset" class="btn btn-secondary" >Reset</button>
                </form>
            </div>
        </div>
    </script>
    <script type="text/template" id="view-wishlist-template">
        <% if(hasItems) { %>
                <div class="row w-100">
                    <h1 class="text-center w-100">Wishlist</h1>
                </div>
                <div class="row w-100 border-bottom border-dark ">
                    <div class="col-6 p-0 col-md-3">
                        <h4 class="text-primary">Title</h4>
                    </div>
                    <div class="col-6 p-0 col-md-2">
                        <h4 class="text-primary">URL</h4>
                    </div>
                    <div class="col-6 p-0 col-md-2">
                        <h4 class="text-primary">Price</h4>
                    </div>
                    <div class="col-6 p-0 col-md-3">
                        <h4 class="text-primary">Priority</h4>
                    </div>
                </div>
            <% } else { %>
                <div class="row mt-5 pt-5 text-center">
                    <div class="col-12">
                        <h3 class="text-center">The wishList is empty</h3>
                    </div>
                </div>
                <div class="row w-100 my-3 mx-auto text-center ">
                            <a href="<?php echo base_url() . '#add' ?>">
                            <button class="btn text-center m-auto btn-success">
                                Add a new Item
                            </button>
                        </a>
                        </div>
            <% } %>
            <% for (let index = 1; index <= length; index++) {%>
                <div class="row border-bottom border-primary w-100 py-3" id="wishlist-item-<%=index%>"></div>
        <%}%>
        <div class="row w-100 my-3 mx-auto text-center ">
                    <button id="btn-share" class="btn btn-info px-3 mx-auto align-items-center w-50">
                        <span><i class="small material-icons">share</i> Share the Wishlist</span>
                    </button>
            </div>
            

    </script>
    <script type="text/template" id="wishlist-item-template">

        <div class="col-6 col-md-3 p-0">
                        <h5 class="heading"><%=model.wli_title%></h5>
                </div>
                <div class="col-6 col-md-2 p-0">
                    <a href="<%=model.wli_url%>" target="_blank">
                        <h5>URL</h5>
                    </a>
                </div>
                <div class="col-6 col-md-2 p-0">
                    <h5>&#163;<%=model.wli_price%></h5>
                </div>
                <div class="col-6 col-md-3 p-0">
                    <h5><%=model.wli_priority%></h5>
                </div>
                <% if(canEdit=="true") { %>
                <div class="col-6 col-md-1 p-0">
                    <a href="https://w1714855.users.ecs.westminster.ac.uk/AdSSW_CWK2_w1714855/index.php/#edit/#<%=model.wli_id%>">
                    <button class="btn btn-secondary">
                        <i class="small material-icons">edit</i>
                    </button></a>
                </div>
                <div class="col-6 col-md-1 p-0">
                    <form>
                    <button type=submit class="btn btn-danger btn-delete" id="btn_delete_<%=model.wli_id%>" data-val="<%=model.wli_id%>">
                        <i class="small material-icons">delete</i>
                    </button>
                </form>
                </div>
                <%}%>
    </script>
    <script type="text/template" id="add-wishlist-item-template">
        <div class="row w-100">
            <h1 class="text-center w-100">Add a new Item</h1>
        </div>
        <form>
        <input type="hidden" name="wli_user_id" id="add_wli_user_id" value="<%=userId%>">
             <div class="form-group">
            <label for="wli_title"><b>Title</b></label>
            <input type="text"  class="form-control" placeholder="Perfume" name="wli_title" id="add_wli_title"></div>
                <div class="form-group">
            <label for="wli_url"><b>URL</b></label>
            <input type="text" class="form-control" placeholder="https://www.tesco.com/groceries/en-GB/products/301869750" name="wli_url" id="add_wli_url"></div>
                <div class="form-group">
            <label for="wli_price"><b>Price</b></label>
            <input type="number" class="form-control"step="0.01" placeholder="40.00" name="wli_price" id="add_wli_price"> </div>
                <div class="form-group"> 
            <label for="wli_priority"><b>Priority</b></label>
            <input type="radio" class="form-control" name="wli_priority" id="add_wli_priority_1" value="A must have" checked>
            <label for="wli_priority_1">A must have</label><br>
            <input type="radio" class="form-control" name="wli_priority" id="add_wli_priority_2" value="Nice to have">
            <label for="wli_priority_2">Nice to have</label><br>  
            <input type="radio" class="form-control" name="wli_priority"id="add_wli_priority_3"  value="Only if you can">
            <label for="wli_priority_3">Only if you can</label><br></div>
            <div class="text-center">
            <button type="submit" class="btn btn-success" id="btn-add-item">Add Item</button>
            <button type="reset" class="btn btn-secondary">Reset</button></div>
        </form>
    </script>
    <script type="text/template" id="edit-wishlist-item-template">
        <form>
            <input type="hidden" name="wli_user_id" id="edit_wli_user_id" value="<%=wli_user_id%>">
                <div class="form-group">
            <label for="wli_title"><b>Title</b></label>
            <input type="text" class="form-control" value="<%=wli_title%>" name="wli_title" id="edit_wli_title"></div>
                <div class="form-group">
            <label for="wli_url"><b>URL</b></label>
            <input type="text" class="form-control" value="<%=wli_url%>" name="wli_url" id="edit_wli_url"></div>
                <div class="form-group">
            <label for="wli_price"><b>Price</b></label>
            <input type="number" class="form-control" step="0.01" value="<%=wli_price%>" name="wli_price" id="edit_wli_price">  </div>
                <div class="form-group">
            <label for="wli_priority"><b>Priority</b></label>          
            <% if(wli_priority =='A must have'){%>
            <input type="radio" class="form-control" name="wli_priority" value="A must have" checked>
            <label for="wli_priority_1">A must have</label><br>
            <input type="radio" class="form-control" name="wli_priority" value="Nice to have">
            <label for="wli_priority_2">Nice to have</label><br>  
            <input type="radio" class="form-control" name="wli_priority" value="Only if you can" >
            <label for="wli_priority_3">Only if you can</label><br>
            <% }else if(wli_priority =='Nice to have') {%>                
            <input type="radio" class="form-control" name="wli_priority" value="A must have">
            <label for="wli_priority_1">A must have</label><br>
            <input type="radio" class="form-control" name="wli_priority" value="Nice to have" checked>
            <label for="wli_priority_2">Nice to have</label><br>  
            <input type="radio" class="form-control" name="wli_priority" value="Only if you can">
            <label for="wli_priority_3">Only if you can</label><br>
            <%}else if(wli_priority =='Only if you can'){%>
                <input type="radio" class="form-control" name="wli_priority" value="A must have">
            <label for="wli_priority_1">A must have</label><br>
            <input type="radio" class="form-control" name="wli_priority" value="Nice to have" >
            <label for="wli_priority_2">Nice to have</label><br>  
            <input type="radio" class="form-control" name="wli_priority" value="Only if you can" checked>
            <label for="wli_priority_3">Only if you can</label><br>
            <%}%>
        </div>
            <div class="text-center">
            <button type="submit" class="btn btn-success" id="btn-edit-item">Save Changes</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
        </div>
        </form>
    </script>

</body>

</html>