App.Views.WishlistView = Backbone.View.extend({

    initialize: function (options) { },

    render: function () {
        var body_template = _.template($('#view-wishlist-template').html());
        var navbar_template = _.template($('#navbar-template').html());
        var isLoggedIn = hasLoggedIn();
        console.log(isLoggedIn);
        $('#custom-navbar').html(navbar_template({ name: "View", loggedIn: isLoggedIn }));
        console.log(this.options.canEdit);
        console.log(this.id);
        var hasItems = this.options.wishlist.models.length > 0;
        this.$el.html(body_template({ hasItems: hasItems, length: this.options.wishlist.models.length }));
        var counter = 1;
        this.options.wishlist.models.forEach(element => {
            var wishlistItemView = new App.Views.WishlistItemView({ el: '#wishlist-item-' + counter, model: element, canEdit: this.options.canEdit, userId: this.id });
            // this.$el.append(this.wishlistItemView.$el);
            console.log(wishlistItemView);
            wishlistItemView.render();
            counter++;
        });
    },
    share_list: function (e) {
        e.preventDefault();
        e.stopPropagation();
        console.log(e);
        alert('The link to view the wishlist is "http://localhost/AdvancedServerSideWeb/AdSSW_CWK2_w1714855/index.php/#wishlist/' + this.id + '"')

    }
});