var app = app || {};
app.views = {};
app.routers = {};
app.models = {};
app.collections = {};
app.categories = {};
app.status = {};
app.base_url = 'http://localhost/AdvancedServerSideWeb/AdSSW_CWK2_w1714855/index.php/';
// var SharkTankView = Backbone.View.extend({
//     initialize: function () {
//       this.render();
//     },
//     render: function () {
//       this.$el.append('sharks!');
//     }
//   });
//   $(function () {
//     var sharkTankView = new SharkTankView({
//       el: $('#tank')
//     });
//   });


$(function () {
    // var template = _.template("<p>Hello World!</p>");
    _.templateSettings = {interpolate: /{{(.+?)}}/g};
    // var template = _.template("<p>Hello {{name}}!</p>");
    // //var template = _.template("<p>Hello <%= name %>!</p>");
    // var SharkTankView = Backbone.View.extend({
    //   initialize: function () {
    //     this.render();
    //   },
    //   render: function () {
    //     this.$el.html(template({name: "Wavy Davey"}));
    //     //this.$el.html(template);
    //   }
    // });
    // new SharkTankView({
    //   el: $('#tank'),
    // });
    var SharkTankView = Backbone.View.extend({
        initialize: function () {
          this.render();
        },
        tankTemplate: _.template(
          $('#tank-template').html()
        ),
        render: function () {
          this.$el.html(this.tankTemplate({
            name: "Danger Mouse McGree"
          }));
        }
      });
      new SharkTankView({
          el: $('#tank'),
        });
  });

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
    url: app.base_url+'api/wishlist/items/1',
  });
  app.wishListItems = new app.collections.WishListItemCollection();