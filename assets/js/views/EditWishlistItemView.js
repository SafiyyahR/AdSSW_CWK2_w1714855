App.Views.EditWishlistItemView = Backbone.View.extend({

    initialize: function (options) { },

    render: function () {
        var body_template = _.template($('#edit-wishlist-item-template').html());
        var navbar_template = _.template($('#navbar-template').html());
        var isLoggedIn = hasLoggedIn();
        var userId = getCurrentUserId();
        $('#custom-navbar').html(navbar_template({ name: "Edit", loggedIn: isLoggedIn, userId: userId }))
        this.$el.html(body_template(this.model.attributes));
    },
    events: {
        "click #btn-edit-item": "update_item"
    },

    validateUpdatedItemForm: function () {
        var wli_priority = $('input[name=wli_priority]:checked')[0];
        console.log($("input#edit_wli_user_id").val());
        var new_item = {
            'wli_user_id': $("input#edit_wli_user_id").val(),
            'wli_title': $("input#edit_wli_title").val(),
            'wli_url': $("input#edit_wli_url").val(),
            'wli_price': $("input#edit_wli_price").val(),
            'wli_priority': wli_priority.value,
        };
        console.log(new_item);
        if (!new_item.wli_price || !new_item.wli_url || !new_item.wli_priority || !new_item.wli_title || !new_item.wli_user_id) {
            return { valid: false };
        }
        return { valid: true, details: new_item };
    },
    update_item: function (e) {
        e.preventDefault();
        e.stopPropagation();
        console.log(e);
        var validNewItem = this.validateUpdatedItemForm();
        console.log(validNewItem);
        if (validNewItem.valid) {
            console.log(validNewItem);
            this.model.set(validNewItem['details']);
            console.log(this.model.attributes);
            this.model.save(this.model.attributes, {
                wait: true,
                url: this.model.urlRoot,
                type: "POST",
                success: function (model, reponse) {
                    alert('You have successfully updated the item.');
                    App.Router.navigate("/#wishlist/#" + validNewItem['details']['wli_user_id'], { trigger: true, replace: true });
                },
                error: function (model, error) {
                    console.log(error);
                    alert('Could not update item.');
                }
            })
        } else {
            alert('All fields are required to update an item.');
        }
    }
});