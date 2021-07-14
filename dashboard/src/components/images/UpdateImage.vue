<template>
    <panel ref="panelRegister" title="Carga de imágenes del día">
        <b-container>
            <b-row class="m-t-10 m-b-10">
                <b-col md="10" offset-md="1">
                    <b-form-group
                        class="row"
                        label="Nombre"
                        label-cols-md="3"
                        label-for="image-name"
                    >
                        <b-form-input
                            id="image-name"
                            v-model="Image.name"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Descripcion"
                        label-cols-md="3"
                        label-for="image-description"
                    >
                        <b-form-input
                            id="image-description"
                            v-model="Image.description"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Ubicación"
                        label-cols-md="3"
                        label-for="image-type"
                    >
                        <b-form-select
                            id="image-type"
                            v-model="Image.type"
                            :options="options"
                            required
                        ></b-form-select>
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
                                :src="'/' + Image.url"
                            />
                        </div>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Imagen"
                        label-cols-md="3"
                        label-for="picture"
                    >
                        <vue-dropzone
                            id="picture"
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
                                @click="resetRegister"
                                >Limpiar</b-button
                            >
                        </b-col>
                        <b-col col sm="6" md="4" offset-md="1">
                            <b-button variant="warning" @click="updateImage"
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
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";

export default {
    props: {
        initialImage: Object,
    },
    data() {
        return {
            busy: false,
            Image: { ...this.initialImage },
            dropzoneOptions: {
                url: "/api/images/"+this.initialImage.id,
                thumbnailWidth: 150,
                acceptedFiles: "image/*",
                addRemoveLinks: true,
                autoProcessQueue: false,
                paramName: "url",
                maxFiles: 1,
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                },
            },
            loading: null,
            options: [
                { value: null, text: 'Selecciona una opción' },
                { value: 0, text: 'Académico' },
                { value: 1, text: 'Deportivo' },
                { value: 2, text: 'Inicio' },
            ]
        };
    },
    components: {
        vueDropzone: vue2Dropzone,
    },
    methods: {
        sendingEvent(file, xhr, formData) {
            Object.keys(this.Image).forEach((key) => {
                formData.append(key, this.Image[key]);
            });
            formData.append("_method", "PUT");
        },
        deletePicture(file) {
            this.$refs.dropzone_picture.removeFile(file);
        },
        sendSuccess(file, response) {
            this.Image = response.data;
            this.$refs.dropzone_picture.removeAllFiles();
            this.$swal.fire("Exito!", "Cambio exitoso", "success").then(() => {
                this.updateSuccess();
            });
        },
        updateImage() {
            if (this.$refs.dropzone_picture.dropzone.files.length > 0) {
                this.$refs.dropzone_picture.processQueue();
            } else {
                this.$http({
                    method: "PUT",
                    url: "/api/images/" + this.Image.id,
                    data: {
                        name: this.Image.name,
                        description: this.Image.description,
                        type: this.Image.type
                    },
                })
                    .then((response) => {
                        this.Image = response.data.data;
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
            this.$swal.fire("Error!", "Registro fallido", "error");
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
</style>
