App.Views.WishlistItemView = Backbone.View.extend({

    el: '#wishlist-item',
    initialize: function (options) { },

    render: function () {
        console.log(this.model.attributes);
        console.log(this.options.canEdit);
        var body_template = _.template($('#wishlist-item-template').html());
        this.$el.html(body_template({ model: this.model.attributes, canEdit: this.options.canEdit, userId: this.options.userId }));
    },
    events: {
        "click #btn-update": "update_item",
        "click #btn-delete": 'delete_item',
        "click #btn-share": 'share_item'
    },

    update_item: function (e) {
        e.preventDefault();
        e.stopPropagation();
        console.log(e);
        // var validRegDetails = this.validateRegisterForm();
        // if (validRegDetails.valid) {
        //     console.log(validRegDetails);
        //     this.model.set(validRegDetails['details']);
        //     console.log(this.model.attributes);
        //     this.model.save(this.model.attributes, {
        //         url: this.model.urlRoot + "/register",
        //         type: "POST",
        //         success: function (model, reponse) {
        //             alert('You have successfully registered.');
        //             app.appRouter.navigate("", {trigger: true, replace: true});
        //         },
        //         error: function (model, error) {
        //             console.log(error);
        //             alert('Username has already been taken.');
        //         }
        //     })
        // } else {
        //     alert('All fields are required to register.');
        // }
    },
    delete_item: function (e) {
        e.preventDefault();
        e.stopPropagation();
        console.log(e);
    },
    share_item: function (e) {
        e.preventDefault();
        e.stopPropagation();
        console.log(e);
        alert('The link to view the wishlist is "http://localhost/AdvancedServerSideWeb/AdSSW_CWK2_w1714855/index.php/#wishlist/' + this.id + '"')

    }
});