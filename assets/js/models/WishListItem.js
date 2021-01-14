
App.Models.WishListItem = Backbone.Model.extend({
    initialize: function (options) { },
    urlRoot:  'http://localhost/AdvancedServerSideWeb/AdSSW_CWK2_w1714855/index.php/api/wishlist/item/',
    defaults:{
        wli_title:"",
        wli_priority:'',
        wli_price:0,
        wli_url:"",
        wli_user_id:0
    }
});
