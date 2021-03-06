App.Views.AddWishlistItemView = Backbone.View.extend({

    initialize: function (options) { },

    render: function () {
        var body_template = _.template($('#add-wishlist-item-template').html());
        var navbar_template = _.template($('#navbar-template').html());
        var isLoggedIn = hasLoggedIn();
        var userId = getCurrentUserId();
        console.log(userId);
        $('#custom-navbar').html(navbar_template({ name: "Add", loggedIn: isLoggedIn, userId: userId }))
        this.$el.html(body_template({ model: this.model.attributes, userId: userId }));
    },
    events: {
        "click #btn-add-item": "add_item"
    },

    validateAddItemForm: function () {
        var wli_priority = $('input[name=wli_priority]:checked')[0];
        console.log($("input#add_wli_user_id").val());
        var new_item = {
            'wli_user_id': $("input#add_wli_user_id").val(),
            'wli_title': $("input#add_wli_title").val(),
            'wli_url': $("input#add_wli_url").val(),
            'wli_price': $("input#add_wli_price").val(),
            'wli_priority': wli_priority.value,
        };
        console.log(new_item);
        if (!new_item.wli_price || !new_item.wli_url || !new_item.wli_priority || !new_item.wli_title || !new_item.wli_user_id) {
            return { valid: false };
        }
        return { valid: true, details: new_item };
    },
    add_item: function (e) {
        e.preventDefault();
        e.stopPropagation();
        var validNewItem = this.validateAddItemForm();
        console.log(validNewItem);
        if (validNewItem.valid) {
            console.log(validNewItem);
            this.model.set(validNewItem['details']);
            console.log(this.model.attributes);
            this.model.save(this.model.attributes, {
                url: this.model.urlRoot + "s",
                type: "POST",
                success: function (model, reponse) {
                    alert('You have successfully added a new item.');
                    App.Router.navigate("/#wishlist/#" + validNewItem['details']['wli_user_id'], { trigger: true, replace: true });
                },
                error: function (model, error) {
                    console.log(error);
                    alert('Could not add item to list.');
                }
            })
        } else {
            alert('All fields are required to add a new item.');
        }
    }
});