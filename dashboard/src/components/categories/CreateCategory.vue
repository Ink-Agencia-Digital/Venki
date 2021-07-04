<template>
    <panel ref="panelRegister" title="Creacion de componentes">
        <b-container>
            <b-row class="m-t-10 m-b-10">
                <b-col md="10" offset-md="1">
                    <b-form-group
                        class="row"
                        label="Nombre"
                        label-cols-md="3"
                        label-for="category-name"
                    >
                        <b-form-input
                            id="category-name"
                            v-model="newCategory.name"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Descripcion"
                        label-cols-md="3"
                        label-for="category-description"
                    >
                        <b-form-textarea
                            id="category-description"
                            type="text"
                            v-model="newCategory.description"
                        ></b-form-textarea>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="video"
                        label-cols-md="3"
                        label-for="category-video"
                    > 
                        <b-form-input
                            id="category-video"
                            type="text"
                            v-model="newCategory.video"
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Componente"
                        label-cols-md="3"
                        label-for="categories"
                    >
                        <v-select
                            label="name"
                            :options="categories"
                            :placeholder="'Seleccione componente si depende de este'"
                            id="categories"
                            :clear-search-on-select="false"
                            :filterable="false"
                            @input="selectCategory"
                            @search="searchCategory"
                            v-model="newCategory.category_id"
                        ></v-select>
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
                     <b-form-group
                        class="row"
                        label="PDF"
                        label-cols-md="3"
                        label-for="pdf"
                    >
                        <vue-dropzone
                            id="pdf"
                            ref="dropzone_pdf"
                            :options="dropzoneOptionspdf"
                            @vdropzone-max-files-exceeded="deletePdf"
                            @vdropzone-success="sendSuccess"
                            @vdropzone-error="sendError"
                            @vdropzone-sending="sendingEvent"
                            @vdropzone-file-added="pdfadded"
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
                            <b-button variant="warning" @click="createCategory"
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

let searchTimer = null;
export default {
    data() {
        return {
            busy: false,
            newCategory: {},
            categories: [],
            dropzoneOptions: {
                url: "/api/categories",
                thumbnailWidth: 150,
                acceptedFiles: "image/*",
                addRemoveLinks: true,
                autoProcessQueue: false,
                paramName: "photo",
                maxFiles: 1,
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                },

            },
            dropzoneOptionspdf: {
                url: "/api/categories",
                thumbnailWidth: 150,
                acceptedFiles: ".pdf",
                addRemoveLinks: true,
                autoProcessQueue: false,
                paramName: "pdf",
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
            Object.keys(this.newCategory).forEach((key) => {
                formData.append(key, this.newCategory[key]);
            });
        },
        deletePicture(file) {
            this.$refs.dropzone_picture.removeFile(file);
        },
        deletePdf(file) {
            this.$refs.dropzone_pdf.removeFile(file);
        },
        sendSuccess() {
            this.registrationSuccessful();
            this.$swal.fire("Exito!", "Registro exitoso", "success");
        },
        pdfadded(file){
            this.newCategory.pdf=file;
        },
        createCategory() {
            if(this.$refs.dropzone_picture.dropzone.files.length>0)
                this.$refs.dropzone_picture.processQueue();
            else 
                this.$refs.dropzone_pdf.processQueue();
        },
        sendError(message) {
            if(message.status!="canceled")
                this.$swal.fire("Error!", "Registro fallido", "error");
        },
        resetRegister() {
            this.$emit("resetRegister");
        },
        registrationSuccessful() {
            this.$emit("registrationSuccessful");
            this.resetRegister();
        },
        searchCategory(value, loading) {
            loading(true);
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                this.$http({
                    method: "GET",
                    url: "/api/categoriesChildren",
                    params: {
                        ...(value
                            ? {
                                query: "name|like|" + value,
                            }
                            : null),
                    },
                })
                    .then((response) => {
                        loading(false);
                        this.categories = response.data.data;
                    })
                    .catch(() => {
                        this.$swal({
                            icon: "error",
                            title: "Error!",
                        });
                    });
            }, 300);
        },
        selectCategory(category) {
            this.selectedCategory = category.id;
            this.newCategory.category_id = this.selectedCategory;
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
