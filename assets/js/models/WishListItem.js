var app = app || {};

app.models.WishListItem = Backbone.Model.extend({
    urlRoot: app.base_url + 'api/wishlist/item/',
    defaults:{
        wli_title:"",
        wli_priority:'',
        wli_price:0,
        wli_url:"",
        wli_user_id:0
    },
    url: app.base_url + 'api/wishlist/item/',
});

app.collections.WishListItemCollection = Backbone.Collection.extend({
    model:app.models.WishListItem,
    comparator:'wli_priority',
    url: app.base_url+'api/wishlist/items/'+app.userId,
  });
  app.wishListItems = new app.WishListItemCollection();