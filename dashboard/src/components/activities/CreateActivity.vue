<template>
    <panel ref="panelRegister" title="Creacion de actividades">
        <b-container>
            <b-row class="m-t-10 m-b-10">
                <b-col md="10" offset-md="1">
                    <b-form-group
                        class="row"
                        label="Nombre"
                        label-cols-md="3"
                        label-for="activities-activity"
                    >
                        <b-form-input
                            id="activities-activity"
                            v-model="newActivity.activity"
                            required
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
                                @click="resetRegister"
                            >Limpiar</b-button
                            >
                        </b-col>
                        <b-col col sm="6" md="4" offset-md="1">
                            <b-button variant="warning" @click="createActivity"
                            >Registrar</b-button
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
    data() {
        return {
            busy: false,
            newActivity: {},
        };
    },
    methods: {
        createActivity() {
            this.$http({
                method: "POST",
                url: "/api/dailyactivities",
                data: this.newActivity,
            })
                .then(() => {
                    this.$swal.fire(
                        "Registrado!",
                        "Actividad registrada",
                        "success"
                    );
                    this.registrationSuccessful();
                })
                .catch((error) => {
                    console.log(error);
                    this.$swal.fire("Error!", "No se pudo registrar", "error");
                    this.resetRegister();
                });
        },
        resetRegister() {
            this.$emit("resetRegister");
        },
        registrationSuccessful() {
            this.$emit("registrationSuccessful");
        },
    },
}


</script>

