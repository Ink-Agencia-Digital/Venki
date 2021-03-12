<template>
    <panel ref="panelUpdate" title="Modificacion de actividades">
        <b-container>
            <b-row class="m-t-10 m-b-10">
                <b-col md="10" offset-md="1">
                    <b-form-group
                        class="row"
                        label="Nombre"
                        label-cols-md="3"
                        label-for="update-activity"
                    >
                        <b-form-input
                            id="update-activity"
                            v-model="activity.activity"
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
                                @click="resetUpdate"
                            >Cerrar</b-button
                            >
                        </b-col>
                        <b-col col sm="6" md="4" offset-md="1">
                            <b-button variant="warning" @click="updateActivity"
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
        initialActivity: Object,
    },
    data() {
        return {
            activity: { ...this.initialActivity },
        };
    },
    methods: {
        updateActivity() {
            this.$http({
                method: "PUT",
                url: "/api/dailyactivities/" + this.activity.id,
                data: this.activity,
            })
                .then((response) => {
                    this.activity = response.data.data;
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
        resetUpdate() {
            this.$emit("resetUpdate");
        },
        updateSuccess() {
            this.$emit("updateSuccess");
        },
    },
}


</script>

