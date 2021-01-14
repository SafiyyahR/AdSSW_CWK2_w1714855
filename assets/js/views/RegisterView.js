App.Views.RegisterView = Backbone.View.extend({

    initialize: function (options) { },

    render: function () {
        var body_template = _.template($('#register-template').html());
        var navbar_template = _.template($('#navbar-template').html());
        $('#custom-navbar').html(navbar_template({ name: "Register", loggedIn: false }))
        this.$el.html(body_template(this.model.attributes));
    },
    events: {
        "click #btn-register": "register"
    },

    validateRegisterForm: function () {
        var registration_details = {
            'user_fname': $("input#register_user_fname").val(),
            'user_lname': $("input#register_user_lname").val(),
            'wishlist_name': $("input#register_wishlist_name").val(),
            'wishlist_description': $("input#register_wishlist_description").val(),
            'wishlist_occasion': $("input#register_wishlist_occasion").val(),
            'username': $("input#register_username").val(),
            'user_password': $("input#register_user_password").val()
        };
        if (!registration_details.username || !registration_details.user_password || !registration_details.user_fname || !registration_details.user_lname || !registration_details.wishlist_description || !registration_details.wishlist_name || !registration_details.wishlist_occasion) {
            return { valid: false };
        }
        return { valid: true, details: registration_details };
    },
    register: function (e) {
        e.preventDefault();
        e.stopPropagation();
        var validRegDetails = this.validateRegisterForm();
        if (validRegDetails.valid) {
            console.log(validRegDetails);
            this.model.set(validRegDetails['details']);
            console.log(this.model.attributes);
            this.model.save(this.model.attributes, {
                url: this.model.urlRoot + "/register",
                type: "POST",
                success: function (model, reponse) {
                    alert('You have successfully registered.');
                    app.appRouter.navigate("", {trigger: true, replace: true});
                },
                error: function (model, error) {
                    console.log(error);
                    alert('Username has already been taken.');
                }
            })
        } else {
            alert('All fields are required to register.');
        }
    }
});