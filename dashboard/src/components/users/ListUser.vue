<template>
    <div>
        <div>
            <download-excel :data="json_data">
            Descargar Información
                <i class="fa fa-download"></i>
            </download-excel>
        </div>
        <Panel ref="panelList" title="Tabla de usuarios">
            <b-container>
                <div class="table-responsive">
                    <vue-good-table
                        mode="remote"
                        :rows="users"
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
                           
                            <span v-if="props.column.field == 'premium'">
                                <span>
                                    <div class="text-center">
                                        <a
                                            @click="updateUser(props.row)"
                                        >

                                            <i v-if="props.row.premium" class="fas fa-thumbs-up" tooltip="Premium"></i>
                                            <i v-else class="fas fa-thumbs-down" tooltip="Free"></i>
                                        </a>
                                    </div>
                                </span>
                            </span>
                             <span v-else >{{
                                props.formattedRow[props.column.field]
                            }}</span>
                        </template>
                    </vue-good-table>
                </div>
            </b-container>
        </Panel>
    </div>
</template>

<script>
import Axios from "axios";

export default {
    data() {
        return {
            page: 1,
            perPage: 10,
            totalRecords: 0,
            users: [],
            columns: [
                {
                    label: "Nombre",
                    field: "name",
                },
                {
                    label: "Apellido",
                    field: "lastname",
                },
                {
                    label: "Fecha de nacimiento",
                    field: "birthday",
                },
                 {
                    label: "Correo",
                    field: "email",
                },
                {
                    label: "Tipo Usuario",
                    field: "premium",
                },
                {
                    label: "Membresia",
                    field: "nombre",
                },
                {
                    label: "Precio",
                    field: "precio",
                },
                {
                    label: "Fecha Pago",
                    field: "fecha_pago",
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
            selectedPhoto: null,
            isOpen: "none",
            json_data:[]
        };
    },
    mounted() {
        this.loadUsers();
    },
    methods: {
        loadUsers() {
            let loader = this.$loading.show();
                Axios
                 .get("/api/Pagos?per_page=" +
                    this.perPage +
                    "&page=" +
                    this.page, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then((response) => {
                    console.log(response);
                    this.users = response.data.data;
                   // this.users.forEach(item =>{
                   //     switch(item.premium)
                   //     {
                   //         case 1:
                   //             item.premium = true;         
                   //             break
                   //         case 0:
                   //             item.premium = false
                   //             break
                   //     }
                    //})
                    this.json_data=this.users;
                    //console.log(this.users);
                    //this.totalRecords = response.data.meta.total;
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
        updateUser(useredit) {
            console.log(useredit)
            var premium =0
            if(useredit.premium==0)
                premium = 1
           this.$http({
                method: "POST",
                url: "/api/users/" + useredit.id+"/premium/"+premium,
            })
                .then(() => {
                    this.loadUsers();
                })
                .catch((error) => {
                    console.log(error);
                    this.$swal.fire("Error!", "Cambio fallido", "error");
                });
        },
        onPageChange(params) {
            this.page = params.currentPage;
            this.loadUsers();
        },
        onPerPageChange(params) {
            this.perPage = params.currentPerPage;
            this.loadUsers();
        },
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
