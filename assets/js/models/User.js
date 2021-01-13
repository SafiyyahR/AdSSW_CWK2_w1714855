var app = app || {};

app.models.User = Backbone.Model.extend({
    defaults:{
    $user_id  = 0,
    $user_fname = "",
    $user_lname = "",
    $user_email = "",
    $user_password = "",
    $wishlist_name = "",
    $wishlist_description ="",
    $wishlist_occasion = "",
    },
    url: app.base_url + 'api/user/'
});