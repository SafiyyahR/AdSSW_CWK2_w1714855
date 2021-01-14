App.Models.User = Backbone.Model.extend({
    initialize: function (options) { },
    urlRoot: 'http://localhost/AdvancedServerSideWeb/AdSSW_CWK2_w1714855/index.php/api/user',
    defaults: {
        user_id: 0,
        user_fname: "",
        user_lname: "",
        user_email: "",
        user_password: "",
        wishlist_name: "",
        wishlist_description: "",
        wishlist_occasion: "",
    },

});
