<template>
    <!-- begin login -->
    <div class="login login-v1">
        <!-- begin login-container -->
        <div class="login-container">
            <!-- begin login-header -->
            <div class="login-header">
                <div class="brand">
                    <span class="logo"></span>
                    <b>Venki</b> Administrador

                </div>
                <div class="icon">
                    <i class="fa fa-lock"></i>
                </div>
            </div>
            <!-- end login-header -->
            <!-- begin login-body -->
            <div class="login-body">
                <!-- begin login-content -->
                <div class="login-content">
                    <div class="form-group m-b-20">
                        <label for="email">Email</label>
                        <input
                            id="email"
                            name="email"
                            v-model="user.email"
                            type="email"
                            class="form-control form-control-lg inverse-mode"
                            placeholder="Email Address"
                            required
                        />
                    </div>
                    <div class="form-group m-b-20">
                        <label for="password">Password</label>
                        <input
                            id="password"
                            name="password"
                            v-model="user.password"
                            type="password"
                            class="form-control"
                            placeholder="Password"
                            required
                        />
                    </div>
                    <div class="login-buttons">
                        <button
                            type="button"
                            @click="login"
                            class="btn btn-success btn-block btn-lg"
                        >
                            Iniciar sesion
                        </button>
                    </div>
                </div>
                <!-- end login-content -->
            </div>
            <!-- end login-body -->
        </div>
        <!-- end login-container -->
    </div>
    <!-- end login -->
</template>

<script>
import PageOptions from "../config/PageOptions.vue";

export default {
    name: "login",
    created() {
        PageOptions.pageEmpty = true;
    },
    beforeRouteLeave() {
        PageOptions.pageEmpty = false;
        window.location = "/home";
    },

    data: () => ({
       user: {
           email: "",
           password: ""
       }
    }),

    methods: {
        login: function () {
            let loader = this.$loading.show();
            this.$store
                 .dispatch('login', {
                    email: this.user.email,
                    password: this.user.password
                })
                .then((response) => {
                    console.log(response);
                    /*if(response.message)
                    {
                        this.$swal.fire("Error!", response.message, "error");
                         loader.hide();
                    }
                    else{*/
                        this.$router.replace("/home");
                        loader.hide();
                    //}*/
                    
                })
                .catch((error) => {
                    loader.hide();
                    console.trace(error);
                });
        },
    },
};
</script>
