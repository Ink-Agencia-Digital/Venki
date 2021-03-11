<template>
    <div>
        <Panel ref="panelList" title="Tabla Actividades">
            <b-container>
                <div class="table-responsive">
                    <vue-good-table
                        mode="remote"
                        :rows="activities"
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

                        <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field === 'actions'">
                                <span>
                                    <div class="text-center">
                                        <a
                                            class="btn btn-grey"
                                            @click="selectActivity(props.row)"
                                        >
                                            <i class="fas fa-edit fa-fw"></i>
                                        </a>
                                        <a
                                            class="btn btn-danger"
                                            @click="confirmDelete(props.row.id)"
                                        >
                                            <i
                                                class="fas fa-trash-alt fa-fw"
                                            ></i>
                                        </a>
                                    </div>
                                </span>
                            </span>
                        </template>
                    </vue-good-table>
                </div>
            </b-container>
        </Panel>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            page: 1,
            perPage: 10,
            totalRecords: 0,
            activities: [],
            columns: [
                {
                    label: "Nombre",
                    field: "activity",
                },
                {
                    label: "Ultima hecha",
                    field: "last_done",
                },
                {
                    label: "Acciones",
                    field: "actions",
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
                rowsPerPageLabel: "Registros por pagina",
                ofLabel: "de",
                pageLabel: "Pagina", // for 'pages' mode
                allLabel: "Todos",
                perPageDropdown: [10, 30, 50],
                dropdownAllowAll: false,
            },
            selectedPhoto: null,
            isOpen: "none",
        };
    },
    created() {
        this.loadActivities();
    },
    methods: {
        loadActivities() {
            let loader = this.$loading.show();
            this.$http({
                method: "GET",
                url:
                    "/api/dailyactivities?per_page=" +
                    this.perPage +
                    "&page=" +
                    this.page,
            })
                .then((response) => {
                    console.log(response);
                    this.activities = response.data.data;
                    console.log(this.activities);
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
        },
        onPageChange(params) {
            this.page = params.currentPage;
            this.loadActivities();
        },
        onPerPageChange(params) {
            this.perPage = params.currentPerPage;
            this.loadActivities();
        },
        confirmDelete(activity_id) {
            this.$swal({
                title: "Está seguro?",
                text: "Estos cambios no podran ser revertidos",
                icon: "warning",
                showCancelButton: true,
            }).then((response) => {
                if (response.value) {
                    let loader = this.$loading.show();
                    axios.delete('/api/dailyactivities/'+ activity_id, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${localStorage.getItem('token')}`
                        }
                    })
                        .then(() => {
                            this.$swal({
                                title: "Hecho!",
                                icon: "success",
                            }).then(() => {
                                this.loadActivities();
                                loader.hide();
                            });
                        })
                        .catch((error) => {
                            this.$swal({
                                title: "Error!",
                                icon: "error",
                                text: error.data.error,
                            }).then(() => {
                                loader.hide();
                            });
                        });

                }
            });
        },
        selectActivity(activity) {
            this.$emit("selectActivity", activity);
        },
    },
};
</script>

<style scoped>

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
