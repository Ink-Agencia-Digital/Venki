<template>
    <panel ref="panelUpdate" title="Modificacion de categorias">
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
                            v-model="course.name"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Descripcion"
                        label-cols-md="3"
                        label-for="update-description"
                    >
                        <b-form-textarea
                            id="update-description"
                            type="text"
                            v-model="course.description"
                        ></b-form-textarea>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Trailer"
                        label-cols-md="3"
                        label-for="update-trailer"
                    >
                        <b-form-input
                            id="update-trailer"
                            v-model="course.trailer"
                            required
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
                                class="img-course"
                                loading="lazy"
                                :src="'/' + course.photo"
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
                                    ...o da click para seleccionar un arricho de
                                    tu computadora
                                </div>
                            </div>
                        </vue-dropzone>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Categorias"
                        label-cols-md="3"
                        label-for="categories-update"
                    >
                        <v-select
                            label="name"
                            :options="categories"
                            :placeholder="'Digite nombre de la cagoria'"
                            id="categories-update"
                            :clear-search-on-select="true"
                            :filterable="false"
                            :value="initialCourse.categories"
                            @input="selectCategory"
                            @search="searchCategories"
                            :multiple="true"
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
                            <b-button variant="warning" @click="updateCourse"
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
let searchTimer = null;

export default {
    props: {
        initialCourse: Object,
    },
    data() {
        return {
            course: { ...this.initialCourse },
            dropzoneOptions: {
                url: "/api/courses/" + this.initialCourse.id,
                thumbnailWidth: 150,
                acceptedFiles: "image/*",
                addRemoveLinks: true,
                autoProcessQueue: false,
                paramName: "photo",
                maxFiles: 1,
            },
            loading: null,
            categories: [],
            newCategories: [],
        };
    },
    components: {
        vueDropzone: vue2Dropzone,
    },
    methods: {
        sendingEvent(file, xhr, formData) {
            Object.keys(this.course).forEach((key) => {
                if (key == "categories" && this.newCategories.length > 0) {
                    formData.append("categories", this.newCategories);
                } else {
                    formData.append(key, this.course[key]);
                }
            });
            formData.append("_method", "PUT");
        },
        deletePicture(file) {
            this.$refs.dropzone_picture.removeFile(file);
        },
        sendSuccess(file, response) {
            this.course = response.data;
            this.$refs.dropzone_picture.removeAllFiles();
            this.$swal.fire("Exito!", "Cambio exitoso", "success").then(() => {
                this.updateSuccess();
            });
        },
        updateCourse() {
            if (this.$refs.dropzone_picture.dropzone.files.length > 0) {
                this.$refs.dropzone_picture.processQueue();
            } else {
                this.$http({
                    method: "PUT",
                    url: "/api/courses/" + this.course.id,
                    data: {
                        name: this.course.name,
                        description: this.course.description,
                        trailer: this.course.trailer,
                        ...(this.newCategories.length > 0 && {
                            categories: this.newCategories,
                        }),
                    },
                })
                    .then((response) => {
                        this.course = response.data.data;
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
        searchCategories(value, loading) {
            loading(true);
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                this.$http({
                    method: "GET",
                    url: "/api/categories?query=name|LIKE|%" + value + "%",
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
        selectCategory(categories) {
            this.initialCourse.categories = categories;
            this.newCategories = categories.map((category) => {
                return category.id;
            });
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
