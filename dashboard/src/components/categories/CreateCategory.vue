<template>
  <panel ref="panelRegister" title="Creacion de categorias">
    <b-container>
      <b-row class="m-t-10 m-b-10">
        <b-col md="10" offset-md="1">
          <b-form-group class="row" label="Nombre" label-cols-md="3" label-for="category-name">
            <b-form-input id="category-name" v-model="newCategory.name" required></b-form-input>
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
          <b-form-group class="row" label="Imagen" label-cols-md="3" label-for="picture">
            <vue-dropzone
              id="picture"
              ref="dropzone_picture"
              :options="dropzoneOptions"
              @vdropzone-max-files-exceeded="deletePicture"
              @vdropzone-success="sendSuccess"
              @vdropzone-error="sendError"
              @vdropzone-sending="sendingEvent"
            />
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col md="4" offset-md="6">
          <b-row>
            <b-col col sm="6" md="4" offset-md="0">
              <b-button variant="outline-primary" @click="resetRegister">Limpiar</b-button>
            </b-col>
            <b-col col sm="6" md="4" offset-md="1">
              <b-button variant="warning" @click="createCategory">Registrar</b-button>
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
  data() {
    return {
      busy: false,
      newCategory: {},
      dropzoneOptions: {
        url: "localhost:8000/api/categories",
        thumbnailWidth: 150,
        acceptedFiles: "image/*",
        addRemoveLinks: true,
        autoProcessQueue: false,
        paramName: "photo",
        maxFiles: 1
      }
    };
  },
  components: {
    vueDropzone: vue2Dropzone
  },
  methods: {
    sendingEvent(file, xhr, formData) {
      Object.keys(this.newCategory).forEach(key => {
        formData.append(key, this.newCategory[key]);
      });
    },
    deletePicture(file) {
      this.$refs.dropzone_picture.removeFile(file);
    },
    sendSuccess() {
      this.resetRegister();
      this.$swal.fire("Exito!", "Registro exitoso", "success");
    },
    createCategory() {
      this.$refs.dropzone_picture.processQueue();
      // this.$emit("registrationSuccessful");
    },
    sendError() {
      this.$swal.fire("Error!", "Registro fallido", "error");
    },
    resetRegister() {
      // this.$emit("resetRegister");
    },
    registrationSuccessful() {
      // this.$emit("registrationSuccessful");
    }
  }
};
</script>

<style>
</style>