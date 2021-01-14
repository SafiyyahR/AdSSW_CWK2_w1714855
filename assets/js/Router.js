App.Router.CurrentRouter = Backbone.Router.extend({
    routes: {
        "wishlist/:id": "viewList",
        "login": "login",
        "register": "register",
        "edit/:itemId": "edit",
        "add/:userId": "add",
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
            //this.viewList(current_user_id);
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
        }
    },

    viewList: function (id) {
        var current_user_id = JSON.parse(localStorage.getItem("current_user_id"));
        if (id.split('#')[1] == null) {
            alert('User Id is not given.');
            App.appRouter.navigate("", { trigger: true, replace: true });
        } else {
            if (current_user_id == id.split('#')[1]) {
                App.wishlist = new App.Collections.WishListItemCollection();
                App.wishlistView = new App.Views.WishlistView({ wishlist: App.wishlist, el: "#main-container", canEdit: "true", id: id.split('#')[1] });
                var url = 'http://localhost/AdvancedServerSideWeb/AdSSW_CWK2_w1714855/index.php/api/wishlist/items/' + current_user_id;
                App.wishlist.fetch({
                    'url': url,
                    wait: true,
                    success: function (collection, response) {
                        app.wishlistView.render();
                    },
                    error: function (model, error) {
                        alert('User has been deleted.');
                    }
                })
            } else {
                App.wishlist = new App.Collections.WishListItemCollection();
                App.wishlistView = new App.Views.WishlistView({ wishlist: App.wishlist, el: "#main-container", canEdit: "false", id: id.split('#')[1] });
                var url = 'http://localhost/AdvancedServerSideWeb/AdSSW_CWK2_w1714855/index.php/api/wishlist/items/' + id.split('#')[1];
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

    edit: function (userId, itemId) {
        if (!app.shareView) {
            app.shareUser = new app.models.User();
            app.shareUser.fetch({ "url": app.shareUser.url + id });
            app.shareView = new app.views.ShareView({ collection: new app.collections.ItemCollection() });
            var url = app.shareView.collection.url + id;
            app.shareView.collection.fetch({
                "url": url,
                wait: true,
                success: function (collection, response) {
                    app.shareView.render();
                },
                error: function (model, xhr) {
                    if (xhr.status == 404) {
                        $("#item_status").css('display', 'block');
                    }
                }
            });

        } else {
            this.viewList();
        }
    },
    add: function (userId, itemId) {
        if (!app.shareView) {
            app.shareUser = new app.models.User();
            app.shareUser.fetch({ "url": app.shareUser.url + id });
            app.shareView = new app.views.ShareView({ collection: new app.collections.ItemCollection() });
            var url = app.shareView.collection.url + id;
            app.shareView.collection.fetch({
                "url": url,
                wait: true,
                success: function (collection, response) {
                    app.shareView.render();
                },
                error: function (model, xhr) {
                    if (xhr.status == 404) {
                        $("#item_status").css('display', 'block');
                    }
                }
            });

        } else {
            this.viewList();
        }
    }

});