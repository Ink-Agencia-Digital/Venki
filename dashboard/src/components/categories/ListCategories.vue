<template>
  <div>
    <Panel ref="panelList" title="Tabla de promociones">
      <b-container>
        <div class="table-responsive">
          <vue-good-table
            mode="remote"
            :rows="categories"
            :columns="columns"
            :sort-options="sort"
            :pagination-options="pagination_options"
            :totalRows="totalRecords"
            @on-page-change="onPageChange"
            @on-per-page-change="onPerPageChange"
            styleClass="table table-bordered m-b-0"
          >
            <template slot="table-row" slot-scope="props">
              <span v-if="props.column.field == 'actions'">
                <span>
                  <div class="text-center">
                    <a class="btn btn-grey" @click="selectCategory(props.row)">
                      <i class="fas fa-edit fa-fw"></i>
                    </a>
                    <a class="btn btn-danger" @click="confirmDelete(props.row.id)">
                      <i class="fas fa-trash-alt fa-fw"></i>
                    </a>
                  </div>
                </span>
              </span>
              <span v-else>{{props.formattedRow[props.column.field]}}</span>
            </template>
          </vue-good-table>
        </div>
      </b-container>
    </Panel>
  </div>
</template>

<script>
export default {
  data() {
    return {
      page: 1,
      perPage: 10,
      totalRecords: 0,
      categories: [],
      columns: [
        {
          label: "ID",
          field: "id"
        },
        {
          label: "Nombre",
          field: "name"
        },
        {
          label: "Descripcion",
          field: "description"
        },
        {
          label: "Acciones",
          field: "actions"
        }
      ],
      sort: {
        enabled: false
      },
      pagination_options: {
        enabled: true,
        mode: "records",
        nextLabel: "Sig",
        prevLabel: "Ant",
        rowsPerPageLabel: "Registros por pagina",
        ofLabel: "de",
        pageLabel: "Pagina", // for 'pages' mode
        allLabel: "Todos",
        perPageDropdown: [10, 30, 50],
        dropdownAllowAll: false
      }
    };
  },
  methods: {
    confirmDelete(promotion_id) {
      this.$swal({
        title: "Está seguro?",
        text: "Estos cambios no podran ser revertidos",
        type: "warning",
        showCancelButton: true
      }).then(response => {
        if (response.value) {
          let loader = this.$loading.show();
          this.$http({
            method: "DELETE",
            url: "/api/categories/" + promotion_id
          })
            .then(() => {
              this.$swal({
                title: "Hecho!",
                type: "success"
              }).then(() => {
                this.loadCategories();
                loader.hide();
              });
            })
            .catch(error => {
              this.$swal({
                title: "Error!",
                type: "error",
                text: error.data.error
              }).then(() => {
                loader.hide();
              });
            });
        }
      });
    },
    selectCategory(category) {
      this.$emit("selectCategory", category);
    },
    loadCategories() {
      let loader = this.$loading.show();
      this.$http({
        method: "GET",
        url: "/api/categories?per_page=" + this.perPage + "&page=" + this.page
      })
        .then(response => {
          this.categories = response.data.data;
          this.totalRecords = response.data.meta.total;
          loader.hide();
        })
        .catch(() => {
          loader.hide();
          this.$swal({
            title: "Error",
            text: "Error cargando los datos",
            type: "error"
          });
        });
    },
    onPageChange(params) {
      this.page = params.currentPage;
      this.loadCategories();
    },
    onPerPageChange(params) {
      this.perPage = params.currentPerPage;
      this.loadCategories();
    }
  },
  created() {
    this.loadCategories();
  }
};
</script>

<style>
</style>