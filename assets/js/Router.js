App.Router.CurrentRouter = Backbone.Router.extend({
    routes: {
        "wishlist/:id": "viewList",
        "login": "login",
        "register": "register",
        "edit/:itemId": "edit",
        "add": "add",
        '*path': 'login'
    },

    login: function () {
        var current_user_id = JSON.parse(localStorage.getItem("current_user_id"));
        if (current_user_id == null) {
            App.user = new App.Models.User();
            if (!App.loginView) {
                App.loginView = new App.Views.LoginView({ model: App.user, el: "#main-container" });
                App.loginView.render();
            }
        } else {
            alert('Logged in');
            App.Router.navigate("/#wishlist/#" + current_user_id, { trigger: true, replace: true });
        }
    },

    register: function () {
        var current_user_id = JSON.parse(localStorage.getItem("current_user_id"));
        if (current_user_id == null) {
            App.user = new App.Models.User();
            if (!App.registerView) {
                App.registerView = new App.Views.RegisterView({ model: App.user, el: "#main-container" });
                App.registerView.render();
            }
        } else {
            alert('Logged in');
            App.Router.navigate("/#wishlist/#" + current_user_id, { trigger: true, replace: true });
        }
    },

    viewList: function (id) {
        var current_user_id = JSON.parse(localStorage.getItem("current_user_id"));
        if (isNaN(id) && id.split('#')[1] == null) {
            alert('User Id is not given.');
            App.Router.navigate("login", { trigger: true, replace: true });
        } else {
            var userId;
            if (!isNaN(id)) {
                userId = id;
            } else {
                userId = id.split('#')[1];
            }
            if (current_user_id == userId) {
                App.wishlist = new App.Collections.WishListItemCollection();
                App.wishlistView = new App.Views.WishlistView({ wishlist: App.wishlist, el: "#main-container", canEdit: "true", id: userId });
                var url = 'http://localhost/AdvancedServerSideWeb/AdSSW_CWK2_w1714855/index.php/api/wishlist/items/' + current_user_id;
                App.wishlist.fetch({
                    'url': url,
                    wait: true,
                    success: function (collection, response) {
                        App.wishlistView.render();
                    },
                    error: function (model, error) {
                        alert('User has been deleted.');
                    }
                })
            } else {
                App.wishlist = new App.Collections.WishListItemCollection();
                App.wishlistView = new App.Views.WishlistView({ wishlist: App.wishlist, el: "#main-container", canEdit: "false", id: userId });
                var url = 'http://localhost/AdvancedServerSideWeb/AdSSW_CWK2_w1714855/index.php/api/wishlist/items/' + userId;
                App.wishlist.fetch({
                    'url': url,
                    wait: true,
                    success: function (collection, response) {
                        App.wishlistView.render();
                    },
                    error: function (model, error) {
                        alert('Incorrect User Id');
                    }
                })
            }
        }
    },

    edit: function (id) {
        if (isNaN(id) && id.split('#')[1] == null) {
            alert('Item Id is not given.');
            App.Router.navigate("login", { trigger: true, replace: true });
        } else {
            var itemId;
            if (!isNaN(id)) {
                itemId = id;
            } else {
                itemId = id.split('#')[1];
            }
            App.wishlistItem = new App.Models.WishListItem();
            var url = App.wishlistItem.urlRoot + "/" + itemId;
            App.wishlistItem.fetch({
                wait: true, url: url,
                success: function (model, response) {
                    console.log(App.wishlistItem);
                    if (!App.editWishlistItemView) {
                        App.editWishlistItemView = new App.Views.EditWishlistItemView({ model: App.wishlistItem, el: "#main-container" });
                        App.editWishlistItemView.render();
                    }
                },
                error: function (model, error) {
                    alert('Incorrect Item Id');
                }
            });

        }
    },
    add: function () {
        var current_user_id = JSON.parse(localStorage.getItem("current_user_id"));
        console.log(current_user_id);
        if (current_user_id == null) {
            alert("Not logged in.");
            App.Router.navigate("login", { trigger: true, replace: true });
        } else {
            App.wishlistItem = new App.Models.WishListItem();
            if (!App.addWishlistItemView) {
                App.addWishlistItemView = new App.Views.AddWishlistItemView({ model: App.wishlistItem, el: "#main-container", userId: current_user_id });
                App.addWishlistItemView.render();
            }
        }
    },

});