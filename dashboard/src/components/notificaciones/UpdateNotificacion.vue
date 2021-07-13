<template>
    <panel ref="panelUpdate" title="Modificación de notificaciones">
        <b-container>
            <b-row class="m-t-10 m-b-10">
                <b-col md="10" offset-md="1">
                    <b-form-group
                        class="row"
                        label="Titulo"
                        label-cols-md="3"
                        label-for="update-titulo"
                    >
                        <b-form-input
                            id="update-titulo"
                            v-model="notificacion.titulo"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Mensaje"
                        label-cols-md="3"
                        label-for="update-mensaje"
                    >
                        <b-form-input
                            id="update-mensaje"
                            v-model="notificacion.mensaje"
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
                            v-model="notificacion.id_profile"
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
                                @click="resetUpdate"
                                >Cerrar</b-button
                            >
                        </b-col>
                        <b-col col sm="6" md="4" offset-md="1">
                            <b-button variant="warning" @click="updateNotificacion"
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
let searchTimer = null;
export default {
    props: {
        initialNotificacion: Object,
    },
    data() {
        return {
            notificacion: { ...this.initialNotificacion },
            loading: null,
            profiles:[],
            selectedProfile:null
        };
    },
    components: {
        
    },
    methods: {
        sendingEvent(file, xhr, formData) {
            Object.keys(this.notificacion).forEach((key) => {
                formData.append(key, this.notificacion[key]);
            });
            formData.append("_method", "PUT");
        },
        sendSuccess(file, response) {
            this.notificacion = response.data;
            this.$swal.fire("Exito!", "Cambio exitoso", "success").then(() => {
                this.updateSuccess();
            });
        },
        updateNotificacion() {
            this.$http({
                method: "PUT",
                url: "/api/notifications/" + this.notificacion.id,
                data: {
                    titulo: this.notificacion.titulo,
                    mensaje: this.notificacion.mensaje,
                    id_profile:this.notificacion.id_profile
                },
            })
                .then((response) => {
                    this.notificacion = response.data.data;
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
            console.log(profile);
            this.selectedProfile = profile.id;
            this.notificacion.id_profile = this.selectedProfile;
        },
        getProfiles(){
            this.$http({
                    method: "GET",
                    url: "/api/profiles"
                    
                })
                    .then((response) => {
                        this.profiles = response.data.data;
                    })
                    .catch(() => {
                        this.$swal({
                            icon: "error",
                            title: "Error!",
                        });
                    });
        }
    },
    mounted(){
        this.getProfiles();
    }
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
