<template>
    <panel ref="panelUpdate" title="Modificación de membresias">
        <b-container>
            <b-row class="m-t-10 m-b-10">
                <b-col md="10" offset-md="1">
                    <b-form-group
                        class="row"
                        label="Nombre"
                        label-cols-md="3"
                        label-for="update-name"
                    >
                        <b-form-input
                            id="update-name"
                            v-model="membresia.nombre"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Precio"
                        label-cols-md="3"
                        label-for="update-precio"
                    >
                        <b-form-input
                            id="update-precio"
                            type="number"
                            v-model="membresia.precio"
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Duración"
                        label-cols-md="3"
                        label-for="update-duracion"
                    >
                        <b-form-input
                            id="update-duracion"
                            type="number"
                            v-model="membresia.duracion"
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Imagen Actual"
                        label-cols-md="3"
                        label-for="actual-photo"
                    >
                        <div class="text-center">
                            <img
                                class="img-category"
                                loading="lazy"
                                :src="'/' + membresia.imagen"
                            />
                        </div>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Imagen Nueva"
                        label-cols-md="3"
                        label-for="picture"
                    >
                        <vue-dropzone
                            id="update-picture"
                            ref="dropzone_picture"
                            :options="dropzoneOptions"
                            @vdropzone-max-files-exceeded="deletePicture"
                            @vdropzone-success="sendSuccess"
                            @vdropzone-error="sendError"
                            @vdropzone-sending="sendingEvent"
                            :useCustomSlot="true"
                        >
                            <div class="dropzone-custom-content">
                                <h3 class="dropzone-custom-title">
                                    Arrastra y suelta para subir contenido!
                                </h3>
                                <div class="subtitle">
                                    ...o da click para seleccionar un archivo de
                                    tu computadora
                                </div>
                            </div>
                        </vue-dropzone>
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
                            <b-button variant="warning" @click="updateMembresia"
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
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";

export default {
    props: {
        initialMembresia: Object,
    },
    data() {
        return {
            membresia: { ...this.initialMembresia },
            dropzoneOptions: {
                url: "/api/membresias/" + this.initialMembresia.id,
                thumbnailWidth: 150,
                acceptedFiles: "image/*",
                addRemoveLinks: true,
                autoProcessQueue: false,
                paramName: "image",
                maxFiles: 1,
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                },
            },
            loading: null,
        };
    },
    components: {
        vueDropzone: vue2Dropzone,
    },
    methods: {
        sendingEvent(file, xhr, formData) {
            Object.keys(this.membresia).forEach((key) => {
                formData.append(key, this.membresia[key]);
            });
            formData.append("_method", "PUT");
        },
        deletePicture(file) {
            this.$refs.dropzone_picture.removeFile(file);
        },
        sendSuccess(file, response) {
            this.membresia = response.data;
            this.$refs.dropzone_picture.removeAllFiles();
            this.$swal.fire("Exito!", "Cambio exitoso", "success").then(() => {
                this.updateSuccess();
            });
        },
        updateMembresia() {
            if (this.$refs.dropzone_picture.dropzone.files.length > 0) {
                this.$refs.dropzone_picture.processQueue();
            } else {
                this.$http({
                    method: "PUT",
                    url: "/api/membresias/" + this.membresia.id,
                    data: {
                        nombre: this.membresia.nombre,
                        precio: this.membresia.precio,
                        duracion: this.membresia.duracion
                    },
                })
                    .then((response) => {
                        this.membresia = response.data.data;
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
            }
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
