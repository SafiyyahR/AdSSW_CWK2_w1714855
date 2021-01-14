var App = {

  Views: {},
  Models: {},
  Collections: {},
  Router: {}
}

function hasLoggedIn() {
  var current_user_id = JSON.parse(localStorage.getItem("current_user_id"));
  console.log(current_user_id)
  if (current_user_id == null) {
    return false;
  } else {
    return true;
  }
}
function getCurrentUserId() {
  var current_user_id = JSON.parse(localStorage.getItem("current_user_id"));
  if (current_user_id == null) {
    return false;
  } else {
    return current_user_id;
  }

}
$(document).ready(function () {
  // _.templateSettings = { interpolate: /{{(.+?)}}/g };
  App.Router = new App.Router.CurrentRouter();
  $(function () {
    Backbone.history.start({ root: "http://localhost/AdvancedServerSideWeb/AdSSW_CWK2_w1714855/index.php" });
  });
  // Add some code here
});
