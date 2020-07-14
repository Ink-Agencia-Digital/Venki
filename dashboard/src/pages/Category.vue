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
          <CreateCategory
            :key="registerKey"
            @registrationSuccessful="registrationSuccessful"
            @resetRegister="resetRegister"
          />
        </b-col>
        <b-col md="12">
          <ListCategories ref="categories-list" @selectCategory="selectCategory" />
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
    },
    ListCategories: resolve => {
      import(
        /* webpackChunkName: "components" */ "@/components/categories/ListCategories.vue"
      ).then(ListCategories => {
        resolve(ListCategories.default);
      });
    }
  },
  data() {
    return {
      category: null,
      registerKey: 1,
      listKey: 1,
      updateKey: 1
    };
  },
  methods: {
    selectCategory(category) {
      this.category = { ...category };
    },
    resetRegister() {
      this.registerKey++;
    },
    resetUpdate() {
      this.category = null;
      this.updateKey++;
    },
    registrationSuccessful() {
      this.resetRegister();
      this.$refs["categories-list"].loadCategories();
    }
  }
};
</script>

<style>
</style>