<template>
    <panel ref="panelRegister" title="Creación de perfiles">
        <b-container>
            <b-row class="m-t-10 m-b-10">
                <b-col md="10" offset-md="1">
                    <b-form-group
                        class="row"
                        label="Nombre"
                        label-cols-md="3"
                        label-for="course-name"
                    >
                        <b-form-input
                            id="course-name"
                            v-model="newProfile.name"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Descripción 1"
                        label-cols-md="3"
                        label-for="description1-name"
                    >
                        <b-form-input
                            id="description1-name"
                            v-model="description1"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Descripción 2"
                        label-cols-md="3"
                        label-for="description2-name"
                    >
                        <b-form-input
                            id="description2-name"
                            v-model="description2"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Descripcion3"
                        label-cols-md="3"
                        label-for="description3-name"
                    >
                        <b-form-input
                            id="description3-name"
                            v-model="description3"
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
                            <b-button variant="warning" @click="createcourse"
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
            newProfile: {},
            description1:'',
            description2:'',
            description3:'',
            descriptions:[]
        };
    },
    methods: {
        createcourse() {
            this.descriptions.push({'name':this.description1});
            this.descriptions.push({'name':this.description2});
            this.descriptions.push({'name':this.description3});
            this.newProfile.descriptions=this.descriptions;
            this.$http({
                method: "POST",
                url: "/api/profiles",
                data: this.newProfile,
            })
                .then(() => {
                    this.$swal.fire(
                        "Registrado!",
                        "Perfil registrado",
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
};
</script>
