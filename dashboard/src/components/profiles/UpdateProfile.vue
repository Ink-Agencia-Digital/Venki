<template>
    <panel ref="panelRegister" title="Modificación de perfiles">
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
                            v-model="profile.name"
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
                        label="Descripción 3"
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
                            <b-button variant="warning" @click="updateprofile"
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
    props: {
        initialProfile: Object,
    },
    data() {
        return {
            profile: { ...this.initialProfile },
            busy: false,
            description1:'',
            description2:'',
            description3:'',
            descriptions:[]
        };
    },
    methods: {
        updateprofile() {
            this.descriptions.push({'name':this.description1});
            this.descriptions.push({'name':this.description2});
            this.descriptions.push({'name':this.description3});
            this.profile.descriptions=this.descriptions;
            this.$http({
                method: "PUT",
                url: "/api/profiles/"+this.profile.id,
                data: this.profile,
            })
                .then(() => {
                    this.$swal.fire(
                        "Registrado!",
                        "Perfil registrado",
                        "success"
                    );
                    this.updateSuccess();
                })
                .catch(() => {
                    this.$swal.fire("Error!", "No se pudo registrar", "error");
                    this.resetUpdate();
                });
        },
        resetUpdate() {
            this.$emit("resetUpdate");
        },
        updateSuccess() {
            this.$emit("updateSuccess");
        },
    },
    created() {
        this.description1=this.profile.descriptions[0].name;
        this.description2=this.profile.descriptions[1].name;
        this.description3=this.profile.descriptions[2].name;
    },
};
</script>
