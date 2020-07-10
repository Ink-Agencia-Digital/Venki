<template>
  <div>
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
      <li class="breadcrumb-item active">
        <a href="javascript:;">Categorias</a>
      </li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">
      Categorias
      <small>Admnistracion de categorias</small>
    </h1>
    <!-- end page-header -->
    <b-container>
      <b-row>
        <b-col md="12">
          <CreateCategory />
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
export default {
  components: {
    CreateCategory: resolve => {
      import(
        /* webpackChunkName: "components" */ "@/components/categories/CreateCategory.vue"
      ).then(CreateCategory => {
        resolve(CreateCategory.default);
      });
    }
  }
};
</script>

<style>
</style>