<template>
    <panel ref="panelUpdate" title="Modificacion de respuestas">
        <b-container>
            <b-row class="m-t-10 m-b-10">
                <b-col md="10" offset-md="1">
                    <b-form-group
                        class="row"
                        label="Respuesta"
                        label-cols-md="3"
                        label-for="update-answer"
                    >
                        <b-form-input
                            id="update-answer"
                            v-model="answer.answer"
                            required
                        ></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col md="10" offset-md="1">
                    <b-form-group
                        class="row"
                        label="Puntaje"
                        label-cols-md="3"
                        label-for="update-point"
                    >
                        <b-form-input
                            id="update-point"
                            v-model="answer.point"
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
                            <b-button variant="warning" @click="updateAnswer"
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
    name: "UpdateAnswer",
    props: {
        initialAnswer: Object,
    },
    data() {
        return {
            answer: { ...this.initialAnswer },
        };
    },
    methods: {
        updateAnswer() {
            this.$http({
                method: "PUT",
                url: "/api/answers/" + this.answer.id,
                data: this.answer,
            }).then((response) => {
                this.answers = response.data.data;
                this.$swal
                    .fire("Exito!", "Cambio exitoso", "success")
                    .then(() => {
                        this.updateSuccess();
                    });
            }).catch((error) => {
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
    }
}
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
