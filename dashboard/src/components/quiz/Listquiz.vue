<template>
    <div>
        <Panel ref="panelList" title="Respuestas del quiz">
            <b-container>
                <b-row class="m-t-10 m-b-10">
                    <b-col md="10" offset-md="1">
                        <b-form-group
                            class="row"
                            label="Usuarios"
                            label-cols-md="3"
                            label-for="list-users"
                        >
                            <v-select
                                label="name"
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
                <div class="table-responsive" v-if="selectedUser">
                    <vue-good-table
                        mode="remote"
                        :rows="quizzes"
                        :columns="columns"
                        :sort-options="sort"
                        :pagination-options="pagination_options"
                        :totalRows="totalRecords"
                        @on-page-change="onPageChange"
                        @on-per-page-change="onPerPageChange"
                        styleClass="table table-bordered m-b-0"
                    >
                        <div slot="emptystate">
                            No hay informacion disponible
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
                    label: "ID",
                    field: "id",
                },
                {
                    label: "Pregunta",
                    field: "pregunta",
                },
                {
                    label: "Respuesta",
                    field: "respuesta",
                },
            ],
            sort: {
                enabled: false,
            },
            pagination_options: {
                enabled: true,
                mode: "pages",
                nextLabel: "Sig",
                prevLabel: "Ant",
                rowsPerPageLabel: "Registros por página",
                ofLabel: "de",
                pageLabel: "Página", // for 'pages' mode
                allLabel: "Todos",
                perPageDropdown: [10, 30, 50],
                dropdownAllowAll: false,
            },
            users: [],
            quizzes: [],
            selectedUser: null,
        };
    },
    methods: {
        loadQuizzes() {
            console.log(this.selectedUser);
            if (this.selectedUser) {
                let loader = this.$loading.show();
                this.$http({
                    method: "GET",
                    url:
                        "/api/user/" +
                        this.selectedUser +
                        "/quiz?per_page=" +
                        this.perPage +
                        "&page=" +
                        this.page,
                })
                    .then((response) => {
                        this.quizzes = response.data.data;
                        this.totalRecords = response.data.meta.total;
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
                        console.log(this.users);
                    })
                    .catch(() => {
                        this.$swal({
                            icon: "error",
                            title: "Error!",
                        });
                    });
            }, 300);
        },
        selectUser(user) {
            this.selectedUser = user.id;
            this.loadQuizzes();
        },
    },
    created() {
        if (this.selectedUser) {
            this.loadQuizzes();
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
