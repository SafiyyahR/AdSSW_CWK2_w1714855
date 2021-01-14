App.Views.LoginView = Backbone.View.extend({

    initialize: function (options) { },

    render: function () {
        var body_template = _.template($('#login-template').html());
        var navbar_template = _.template($('#navbar-template').html());
        var isLoggedIn = hasLoggedIn();
        var userId = getCurrentUserId();
        $('#custom-navbar').html(navbar_template({ name: "Login", loggedIn: isLoggedIn, userId: userId }))
        this.$el.html(body_template(this.model.attributes));
    },
    events: {
        "click #btn-login": "login"
    },

    validateLoginForm: function () {
        var login_details = {
            'username': $("input#login_username").val(),
            'user_password': $("input#login_user_password").val()
        };
        if (!login_details.username || !login_details.user_password) {
            return { valid: false };
        }
        return { valid: true, details: login_details };
    },
    login: function (e) {
        e.preventDefault();
        e.stopPropagation();
        var validatedLogin = this.validateLoginForm();
        if (validatedLogin.valid) {
            this.model.set(validatedLogin['details']);
            this.model.save(this.model.attributes, {
                url: this.model.urlRoot + "/login",
                type: "POST",
                success: function (model, reponse) {
                    console.log("Success");
                    var url = model.urlRoot + "/" + model.get('username');
                    model.fetch({ url: url });
                    localStorage.setItem('current_user_id', model.get('user_id'));
                    localStorage.setItem('current_user_fname', model.get('user_fname'));
                    localStorage.setItem('current_user_lname', model.get('user_lname'));
                    localStorage.setItem('current_username', model.get('username'));
                    localStorage.setItem('current_wishlist_name', model.get('wishlist_name'));
                    localStorage.setItem('current_wishlist_description', model.get('wishlist_description'));
                    localStorage.setItem('current_wishlist_occasion', model.get('wishlist_occasion'));
                    App.Router.navigate("#wishlist/"+model.get('user_id'), {trigger: true, replace: true});
                },
                error: function (model, error) {
                    alert('Incorrect Username or Password.');
                }
            })
        } else {
            alert('Login Fields are empty.');
        }
    }
});