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
        "click .btn-delete": 'delete_item'
    },

    delete_item: function (e) {
        e.preventDefault();
        e.stopPropagation();
        console.log(e.currentTarget.id.split('btn_delete_')[1]);
        
    },

});