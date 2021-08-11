<template>
    <div>
        <Panel ref="panelList" title="Tabla de resultados">
            <b-container>
                <b-row class="m-t-10 m-b-10">
                    <b-col md="10" offset-md="1">
                        <b-form-group
                            class="row"
                            label="Usuario"
                            label-cols-md="3"
                            label-for="list-users"
                        >
                            <v-select
                                label="email"
                                :options="users"
                                :placeholder="'Digite nombre del usuario'"
                                id="list-users"
                                :clear-search-on-select="false"
                                :filterable="false"
                                @input="selectUser"
                                @search="searchUser"
                            ></v-select>
                        </b-form-group>
                    </b-col>
                </b-row>
                <div class="table-responsive" v-if="id_user">
                    <vue-good-table
                        mode="remote"
                        :rows="resultados"
                        :columns="columns"
                        :sort-options="sort"
                        :pagination-options="pagination_options"
                        :totalRows="totalRecords"
                        @on-page-change="onPageChange"
                        @on-per-page-change="onPerPageChange"
                        styleClass="table table-bordered m-b-0"
                    >
                        <div slot="emptystate">
                            No hay información disponible
                        </div>
                    </vue-good-table>
                </div>
            </b-container>
        </Panel>
    </div>
</template>

<script>
let searchTimer = null;
export default {
    data() {
        return {
            page: 1,
            perPage: 10,
            totalRecords: 0,
            columns: [
                {
                    label: "Examen",
                    field: "descripcion",
                },
                {
                    label: "Trofeo",
                    field: "nombre",
                },
                {
                    label: "Nota",
                    field: "nota",
                },
                {
                    label: "Intento #",
                    field: "intento",
                },
                {
                    label: "Valido",
                    field: "valido",
                }
            ],
            sort: {
                enabled: false,
            },
            pagination_options: {
                enabled: true,
                mode: "pages",
                nextLabel: "Sig",
                prevLabel: "Ant",
                rowsPerPageLabel: "Registros por pagina",
                ofLabel: "de",
                pageLabel: "Pagina", // for 'pages' mode
                allLabel: "Todos",
                perPageDropdown: [10, 30, 50],
                dropdownAllowAll: false,
            },
            resultados: [],
            selectedUser: null,
            id_user:null,
            users:[]
        };
    },
    methods: {
        loadResultados() {
            if (this.id_user) {
                let loader = this.$loading.show();
                this.$http({
                    method: "GET",
                    url:
                        "/api/examen/resultados/user/" +
                        this.id_user +"?per_page=" +
                        this.perPage +
                        "&page=" +
                        this.page,
                })
                    .then((response) => {
                        this.resultados = response.data.data;
                        console.log(this.resultados);
                       // this.totalRecords = this.preguntas.length;
                        //console.log(this.totalRecords);
                        loader.hide();
                    })
                    .catch(() => {
                        loader.hide();
                        this.$swal({
                            title: "Error",
                            text: "Error cargando los datos",
                            icon: "error",
                        });
                    });
            }
        },
        onPageChange(params) {
            this.page = params.currentPage;
            //this.loadLessons();
        },
        onPerPageChange(params) {
            this.perPage = params.currentPerPage;
            //this.loadLessons();
        },
        searchUser(value, loading) {
            loading(true);
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                this.$http({
                    method: "GET",
                    url: "/api/users?query=name|LIKE|%" + value + "%",
                })
                    .then((response) => {
                        loading(false);
                        this.users = response.data.data;
                    })
                    .catch(() => {
                        this.$swal({
                            icon: "error",
                            title: "Error!",
                        });
                    });
            }, 300);
        },
        selectUser(user){
            this.id_user=user.id;
            this.loadResultados();
        }
    },
    created() {
        if (this.id_user) {
            this.loadResultados();
        }
    },
};
</script>

<style scoped>
.img-category {
    max-height: 100px;
    max-width: 150px;
    height: auto;
    width: auto;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

.img-category:hover {
    opacity: 0.7;
}

.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0, 0, 0); /* Fallback color */
    background-color: rgba(0, 0, 0, 0.9); /* Black w/ opacity */
}

/* Modal Content (Image) */
.modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    margin-top: 10%;
}

/* Add Animation - Zoom in the Modal */
.modal-content,
#caption {
    animation-name: zoom;
    animation-duration: 0.6s;
}

@keyframes zoom {
    from {
        transform: scale(0);
    }
    to {
        transform: scale(1);
    }
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px) {
    .modal-content {
        width: 100%;
    }
}
</style>
