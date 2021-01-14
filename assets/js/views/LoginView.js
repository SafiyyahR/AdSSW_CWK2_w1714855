App.Views.LoginView = Backbone.View.extend({

    initialize: function (options) { },
    el: "#main-container",

    loginTemplate: _.template(
        $('#login-template').html()
    ),
    render: function () {
        this.$el.html(this.loginTemplate(this.model.attributes));
    },

    events: {
        "click #btn-login": "login"
    },

    validateLoginForm: function () {
        var login_details = {
            'user_email': $("input#login_user_email").val(),
            'user_password': $("input#login_user_password").val()
        };
        if (!login_details.user_email || !login_details.user_password) {
            return { valid: false };
        }
        return { valid: true, details: login_details };
    },
    login: function (e) {
        e.preventDefault();
        e.stopPropagation();
        var validatedLogin = this.validateLoginForm();
        if (validatedLogin.valid) {
            this.model.set(validatedLogin);
            this.model.save(this.model.attributes, {
                'url': this.model.url + "/login",
                success: function (model, reponse) {
                    localStorage.setItem('user', JSON.stringify(model));
                    console.log(localStorage.getItem('user'));
                }
            })
        } else {
            console.log('login fields empty')
        }
    }
});