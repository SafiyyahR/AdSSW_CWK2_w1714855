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
            'user_email': $("input#login_user_email").val(),
            'user_password': $("input#login_user_password").val()
        };
        console.log(login_details);
        if (!login_details.user_email || !login_details.user_password) {
            return { valid: false };
        }
        return { valid: true, details: login_details };
    },
    login: function (e) {
        e.preventDefault();
        e.stopPropagation();
        var validatedLogin = this.validateLoginForm();
        console.log(validatedLogin);
        if (validatedLogin.valid) {
            this.model.set(validatedLogin['details']);
            console.log(this.model.urlRoot);
            this.model.save(this.model.attributes, {
                wait: true,
                url: this.model.urlRoot + "/login",
                success: function (model, reponse) {
                    console.log("Success");
                    this.model.fetch();
                    // localStorage.setItem('current_user', JSON.stringify(model));
                    // console.log(localStorage.getItem('current_user'));
                },
                error: function (model, error) {
                    alert('Incorrect Email or Password.');
                }
            })
        } else {
            console.log('login fields empty')
        }
    }
});