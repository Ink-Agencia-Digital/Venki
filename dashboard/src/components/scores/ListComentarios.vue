<template>
    <div>
        <Panel ref="panelList" title="Tabla de comentarios">
            <b-container>
                <!--<b-row class="m-t-10 m-b-10">
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
                        <b-form-group
                            class="row"
                            label="Cursos"
                            label-cols-md="3"
                            label-for="list-courses"
                        >
                            <v-select
                                label="name"
                                :options="courses"
                                :placeholder="'Seleccione el curso'"
                                id="list-courses"
                                :clear-search-on-select="false"
                                :filterable="false"
                                @input="selectCourse"
                            ></v-select>
                        </b-form-group>
                    </b-col>
                </b-row>-->
                <div class="table-responsive" >
                    <vue-good-table
                        mode="remote"
                        :rows="scores"
                        :columns="columns"
                        :select-options="{
                            enabled: true,
                            selectOnCheckboxOnly:true,
                            selectionInfoClass: 'custom-class',
                            selectionText: 'rows selected',
                            clearSelectionText: 'clear',
                            disableSelectInfo: true, // disable the select info panel on top
                            selectAllByGroup: true,
                        }"
                        :sort-options="sort"
                        :pagination-options="pagination_options"
                        :totalRows="totalRecords"
                        @on-page-change="onPageChange"
                        @on-per-page-change="onPerPageChange"
                        @on-selected-rows-change="selectionChanged"
                        styleClass="table table-bordered m-b-0"
                    >
                        <div slot="emptystate">
                            No hay información disponible
                        </div>
                    </vue-good-table>
                </div>
                 <b-row>
                <b-col md="4" offset-md="6">
                    <b-row>
                        <b-col col sm="6" md="4" offset-md="1">
                            <b-button variant="warning" @click="aprobarComentario"
                                >Enviar</b-button
                            >
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
            </b-container>
        </Panel>
    </div>
</template>

<script>
//let searchTimer = null;
export default {
    data() {
        return {
            page: 1,
            perPage: 10,
            totalRecords: 0,
            columns: [
                {
                    label: "Curso",
                    field: "course.name",
                },
                {
                    label: "Usuario",
                    field: "user.email",
                },
                {
                    label: "comentario",
                    field: "comment",
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
            scores: [],
            //id_examen:null,
            //id_user:null,
            //users:[],
            Correctas:[]
        };
    },
    methods: {
        loadScores() {
            this.$http({
                method: "GET",
                url:
                    "/api/scores?per_page=" +
                    this.perPage +
                    "&page=" +
                    this.page
            })
                .then((response) => {
                    this.scores = response.data.data;
                    this.scores=this.scores.filter(x=>x.active==0);
                    console.log(this.scores);
                })
                .catch(() => {
                    this.$swal({
                        title: "Error",
                        text: "Error cargando los datos",
                        icon: "error",
                    });
                });
        },
        selectionChanged(params){
            console.log(params);
            this.Correctas=params.selectedRows;
            console.log(this.Correctas);
            //$idrespuesta = params[0].id;
            //$valor = params[0].valor;
        },
        onPageChange(params) {
            this.page = params.currentPage;
            //this.loadLessons();
        },
        onPerPageChange(params) {
            this.perPage = params.currentPerPage;
            //this.loadLessons();
        },
        /*searchCourse(value, loading) {
            loading(true);
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                this.$http({
                    method: "GET",
                    url: "/api/courses?query=name|LIKE|%" + value + "%",
                })
                    .then((response) => {
                        loading(false);
                        this.courses = response.data.data;
                    })
                    .catch(() => {
                        this.$swal({
                            icon: "error",
                            title: "Error!",
                        });
                    });
            }, 300);
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
        selectCourse(course) {
            this.selectedCourse = course.id;
            this.id_examen = course.examen.id;
            this.loadRespuestas();
        },
        selectUser(user){
            this.id_user=user.id;
            this.loadRespuestas();
        },*/
        aprobarComentario(){
            let loader = this.$loading.show();
            this.$http({
                method:"POST",
                url:"/api/scores/aprobacion",
                data:this.Correctas})
                .then(()=>{
                    loader.hide();
                    this.$swal({
                        icon:"success",
                        title:"Aprobado",
                        message:"Aprobado"
                    })
                    this.Correctas=[];
                    this.loadScores();
                    //this.id_examen=null;
                    //this.id_user=null;
                    //this.selectedCourse=null;
                })
        },
        /*getCourses(){
            this.$http({
                    method: "GET",
                    url: "/api/courses",
                })
                    .then((response) => {
                        this.courses = response.data.data;
                    })
                    .catch(() => {
                        this.$swal({
                            icon: "error",
                            title: "Error!",
                        });
                    });
        }*/
    },
    /*mounted(){
        this.getCourses();
    },*/
    created() {
        this.loadScores();
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
