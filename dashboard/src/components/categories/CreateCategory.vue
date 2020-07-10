<template>
  <panel ref="panelRegister" title="Creacion de categorias">
    <b-container>
      <legend>Informacion de Usuario</legend>
      <b-row class="m-t-10 m-b-10">
        <b-col md="10" offset-md="1">
          <b-form-group class="row" label="Nombre" label-cols-md="3" label-for="category-name">
            <b-form-input
              id="category-name"
              v-model="newCategory.name"
              required
              placeholder="Mental"
            ></b-form-input>
          </b-form-group>
          <b-form-group
            class="row"
            label="Descripcion"
            label-cols-md="3"
            label-for="category-description"
          >
            <b-form-input id="category-description" type="text" v-model="newCategory.cancelation"></b-form-input>
          </b-form-group>
          <b-form-group class="row" label="Email" label-cols-md="3" label-for="email">
            <b-form-input
              id="email"
              v-model="newOffice.email"
              required
              placeholder="email@example.com"
            ></b-form-input>
          </b-form-group>
        </b-col>
      </b-row>
    </b-container>
  </panel>
</template>

<script>
export default {
  data() {
    return {
      newCategory: {}
    };
  }
};
</script>

<style>
</style>