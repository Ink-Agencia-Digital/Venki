<template>
    <panel ref="panelRegister" title="Creación de notificaciones">
        <b-container>
            <b-row class="m-t-10 m-b-10">
                <b-col md="10" offset-md="1">
                    <b-form-group
                        class="row"
                        label="Titulo"
                        label-cols-md="3"
                        label-for="notificacion-titulo"
                    >
                        <b-form-input
                            id="notificacion-titulo"
                            v-model="newNotificacion.titulo"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Mensaje"
                        label-cols-md="3"
                        label-for="notificacion-mensaje"
                    >
                        <b-form-input
                            id="notificacion-mensaje"
                            v-model="newNotificacion.mensaje"
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Perfil"
                        label-cols-md="3"
                        label-for="notificacion-perfil"
                    >
                        <v-select
                            label="name"
                            :options="profiles"
                            :placeholder="'Seleccione perfil'"
                            id="profiles"
                            :clear-search-on-select="false"
                            :filterable="false"
                            @input="selectProfile"
                            @search="searchProfile"
                            v-model="newNotificacion.id_profile"
                        ></v-select>
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
                            <b-button variant="warning" @click="createNotificacion"
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
let searchTimer = null;
export default {
    data() {
        return {
            busy: false,
            newNotificacion: {},
            notificaciones: [],
            profiles:[],
            loading: null,
            selectedProfile:null
        };
    },
    components: {
        
    },
    methods: {
        sendingEvent(file, xhr, formData) {
            console.log(this.newNotificacion);
            Object.keys(this.newNotificacion).forEach((key) => {
                formData.append(key, this.newNotificacion[key]);
            });
        },
        deletePicture(file) {
            this.$refs.dropzone_picture.removeFile(file);
        },
        sendSuccess() {
            this.registrationSuccessful();
            this.$swal.fire("Exito!", "Registro exitoso", "success");
        },
        createNotificacion() {
            this.$http({
            method:"POST",
            url:"/api/notifications",
            data: this.newNotificacion,
            })
            .then(()=>{
                this.$swal.fire("Exito","Puede ingresar las preguntas","success");
                this.sendSuccess();
            })
            .catch(()=>{
                this.sendError();
            })
        },
        sendError() {
            this.$swal.fire("Error!", "Registro fallido", "error");
        },
        resetRegister() {
            this.$emit("resetRegister");
        },
        registrationSuccessful() {
            this.$emit("registrationSuccessful");
            this.resetRegister();
        },
        searchProfile(value, loading) {
            loading(true);
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                this.$http({
                    method: "GET",
                    url: "/api/profiles?query=name|LIKE|%" + value + "%",
                    
                })
                    .then((response) => {
                        loading(false);
                        this.profiles = response.data.data;
                    })
                    .catch(() => {
                        this.$swal({
                            icon: "error",
                            title: "Error!",
                        });
                    });
            }, 300);
        },
        selectProfile(profile) {
            this.selectedProfile = profile.id;
            this.newNotificacion.id_profile = this.selectedProfile;
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
</style>
