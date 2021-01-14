var App = {

  Views: {},
  Models: {},
  Collections: {},
  Router: {}
}

function hasLoggedIn() {
  current_user = JSON.parse(localStorage.getItem("current_user"));
  if (current_user == null) {
    return false;
  } else {
    return true;
  }
}
function getCurrentUserId() {
  current_user = JSON.parse(localStorage.getItem("current_user"));
  if (current_user == null) {
    return false;
  } else {
    return current_user.get('user_id');
  }

}
$(document).ready(function () {
  // _.templateSettings = { interpolate: /{{(.+?)}}/g };
  App.Router = new App.Router.CurrentRouter();
  $(function () {
    Backbone.history.start();
  });
  // Add some code here
});
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


// $(function () {
//   // var template = _.template("<p>Hello World!</p>");
//   _.templateSettings = { interpolate: /{{(.+?)}}/g };

// }
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
//   var User = Backbone.Model.extend({
//     defaults: {
//       user_id: 0,
//       user_fname: "",
//       user_lname: "",
//       user_email: "",
//       user_password: "",
//       wishlist_name: "",
//       wishlist_description: "",
//       wishlist_occasion: "",
//     },
//     urlRoot: 'http://localhost/AdvancedServerSideWeb/AdSSW_CWK2_w1714855/index.php/api/user' + user_id
//   });
//   var user = new User({ "user_id": 8 });
//   user.fetch({ success: function () { alert("Name is " + user.get('user_lname')) } })
//   var SharkTankView = Backbone.View.extend({
//     initialize: function () {
//       this.render();
//     },
//     tankTemplate: _.template(
//       $('#tank-template').html()
//     ),
//     render: function () {
//       this.$el.html(this.tankTemplate({
//         name: "Danger Mouse McGree"
//       }));
//     }
//   });
//   new SharkTankView({
//     el: $('#tank'),
//   });
// });


// app.models.WishListItem = Backbone.Model.extend({
//   urlRoot: app.base_url + 'api/wishlist/item/',
//   defaults: {
//     wli_title: "",
//     wli_priority: '',
//     wli_price: 0,
//     wli_url: "",
//     wli_user_id: 0
//   },
//   url: app.base_url + 'api/wishlist/item/',
// });

// app.collections.WishListItemCollection = Backbone.Collection.extend({
//   model: app.models.WishListItem,
//   comparator: 'wli_priority',
//   url: app.base_url + 'api/wishlist/items/1',
// });
// app.wishListItems = new app.collections.WishListItemCollection();