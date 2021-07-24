<template>
    <panel ref="panelUpdate" title="Modificación de membresias">
        <b-container>
            <b-row class="m-t-10 m-b-10">
                <b-col md="10" offset-md="1">
                    <b-form-group
                        class="row"
                        label="Nombre"
                        label-cols-md="3"
                        label-for="user-name"
                    >
                        <b-form-input
                            id="user-name"
                            v-model="User.user_name"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Apellido"
                        label-cols-md="3"
                        label-for="user-lastname"
                    >
                        <b-form-input
                            id="user-lastname"
                            v-model="User.user_lastname"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Email"
                        label-cols-md="3"
                        label-for="user-email"
                    >
                        <b-form-input
                            id="user-email"
                            readonly="true"
                            v-model="User.user_email"
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Email"
                        label-cols-md="3"
                        label-for="user-password"
                    >
                        <b-form-input
                            id="user-password"
                            type="password"
                            v-model="User.user_password"
                        ></b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col md="4" offset-md="6">
                    <b-row>
                        <b-col col sm="6" md="4" offset-md="0">
                            <b-button
                                variant="outline-primary"
                                @click="resetUpdate"
                                >Cerrar</b-button
                            >
                        </b-col>
                        <b-col col sm="6" md="4" offset-md="1">
                            <b-button variant="warning" @click="updateUser"
                                >Modificar</b-button
                            >
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
        </b-container>
    </panel>
</template>

<script>
export default {
    props: {
        initialUser: Object,
    },
    data() {
        return {
            User: { ...this.initialUser },
            loading: null,
        };
    },
    methods: {
        sendingEvent(file, xhr, formData) {
            Object.keys(this.User).forEach((key) => {
                formData.append(key, this.User[key]);
            });
            formData.append("_method", "PUT");
        },
        sendSuccess(file, response) {
            this.User = response.data;
            this.$swal.fire("Exito!", "Cambio exitoso", "success").then(() => {
                this.updateSuccess();
            });
        },
        updateUser() {
            this.$http({
                method: "PUT",
                url: "/api/useradmin/" + this.User.id,
                data: {
                    name: this.User.user_name,
                    lastname: this.User.user_lastname,
                    password:this.User.user_password
                },
            })
                .then((response) => {
                    this.User = response.data.data;
                    this.$swal
                        .fire("Exito!", "Cambio exitoso", "success")
                        .then(() => {
                            this.updateSuccess();
                        });
                })
                .catch((error) => {
                    console.log(error);
                    this.$swal.fire("Error!", "Cambio fallido", "error");
                });
            
        },
        sendError() {
            this.$swal.fire("Error!", "Cambio fallido", "error");
        },
        resetUpdate() {
            this.$emit("resetUpdate");
        },
        updateSuccess() {
            this.$emit("updateSuccess");
        },
    },
};
</script>

<style scoped>
.dropzone-custom-content {
    position: inherit;
    top: 50%;
    left: 50%;
    text-align: center;
}

.dropzone-custom-title {
    margin-top: 0;
    color: #00b782;
}

.subtitle {
    color: #314b5f;
    font-size: medium;
}

img {
    max-width: 200px;
}
</style>
