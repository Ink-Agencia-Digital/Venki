<template>
    <Panel ref="panelList" title="Tabla de respuestas">
        <b-container>
            <b-row class="m-t-10 m-b-10">
                <b-col md="10" offset-md="1">
                    <b-form-group
                        class="row"
                        label="Perfil"
                        label-cols-md="3"
                        label-for="profiles-list"
                    >
                        <v-select
                            label="name"
                            :options="profiles"
                            :placeholder="'Digite nombre del perfl'"
                            id="profiles-list"
                            :clear-search-on-select="false"
                            :filterable="false"
                            @input="selectProfile"
                        ></v-select>
                    </b-form-group>
                </b-col>
                <b-col md="10" offset-md="1">
                    <b-form-group
                        class="row"
                        label="Categoria"
                        label-cols-md="3"
                        label-for="category-list"
                    >
                        <v-select
                            label="name"
                            :options="categories"
                            :placeholder="'Digite nombre de la categoria'"
                            id="category-list"
                            :clear-search-on-select="false"
                            :filterable="false"
                            @input="selectCategory"
                        ></v-select>
                    </b-form-group>
                </b-col>
                <b-col md="10" offset-md="1">
                    <b-form-group
                        class="row"
                        label="Pregunta"
                        label-cols-md="3"
                        label-for="questions"
                    >
                        <v-select
                            label="question"
                            :options="questions"
                            :placeholder="'Digite nombre de la pregunta'"
                            id="questions"
                            :clear-search-on-select="false"
                            :filterable="false"
                            @input="selectQuestion"
                        ></v-select>
                    </b-form-group>
                </b-col>
            </b-row>
            <div class="table-responsive" v-if="selectedProfile">
                <div class="table-responsive" v-if="selectedCategory">
                    <div class="table-responsive" v-if="selectedQuestion">
                        <vue-good-table
                            mode="remote"
                            :rows="answers"
                            :columns="columns"
                            styleClass="table table-bordered m-b-0"
                        >
                            <div slot="emptystate">
                                No hay informacion disponible
                            </div>
                            <template slot="table-row" slot-scope="props">
                                    <span v-if="props.column.field == 'actions'">
                                        <span>
                                            <div class="text-center">
                                                <a
                                                    class="btn btn-grey"
                                                    @click="selectAnswer(props.row)"
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
                                <span v-else>{{
                                        props.formattedRow[props.column.field]
                                    }}</span>
                            </template>
                        </vue-good-table>
                    </div>
                </div>
            </div>
        </b-container>
    </Panel>
</template>

<script>
let searchTimer = null;
export default {
    name: "ListAnswers",
    data() {
        return {
            page: 1,
            perPage: 10,
            totalRecords: 0,
            answers: [],
            columns: [
                {
                    label: "Respuesta",
                    field: "answer"
                },
                {
                    label: "Puntaje",
                    field: "point",
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
            profiles: [],
            categories: [],
            questions: [],
            selectedProfile: null,
            selectedCategory: null,
            selectedQuestion: null,
        }
    },
    methods: {
        confirmDelete(answer_id) {
            this.$swal({
                title: "Está seguro?",
                text: "Estos cambios no podran ser revertidos",
                icon: "warning",
                showCancelButton: true,
            }).then((response) => {
                if (response.value) {
                    let loader = this.$loading.show();
                    this.$http({
                        method: "DELETE",
                        url: "/api/answers/" + answer_id,
                    })
                        .then(() => {
                            loader.hide();
                            this.$swal({
                                title: "Hecho!",
                                icon: "success",
                            }).then(() => {
                                this.answers = this.answers.filter(
                                    (answer) => {
                                        return answer.id !== answer_id;
                                    }
                                );
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
        loadAnswers() {
            if (this.selectedProfile, this.selectedCategory, this.selectedQuestion) {
                let loader = this.$loading.show();
                this.$http({
                    method: "GET",
                    url: "/api/questions/" + this.selectedQuestion + "/answers",
                    params: {
                        per_page: this.perPage,
                        page: this.page,
                    },
                }).then((response) => {
                    this.answers = response.data.data;
                    console.log(this.answers);
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
            this.loadQuestions();
        },
        onPerPageChange(params) {
            this.perPage = params.currentPerPage;
            this.loadQuestions();
        },
        searchProfile(value, loading) {
            loading(true);
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                this.$http({
                    method: "GET",
                    url: "/api/profiles",
                    params: {
                        ...(value
                            ? {
                                query: "name|like|" + value,
                            }
                            : null),
                    },
                })
                    .then((response) => {
                        loading(false);
                        this.profiles = response.data.data;
                    })
                    .catch(() => {
                        this.$swal({
                            icon: "error",
                            title: "Error!",
                        });
                    });
            }, 300);
        },
        searchCategory(value, loading) {
            loading(true);
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                this.$http({
                    method: "GET",
                    url: "/api/categories",
                    params: {
                        ...(value
                            ? {
                                query: "name|like|" + value,
                            }
                            : null),
                    },
                })
                    .then((response) => {
                        loading(false);
                        this.categories = response.data.data;
                    })
                    .catch(() => {
                        this.$swal({
                            icon: "error",
                            title: "Error!",
                        });
                    });
            }, 300);
        },
        searchQuestion(value, loading) {
            loading(true);
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                this.$http({
                    method: "GET",
                    url: "/api/surveys/" + this.selectedProfile + "/category/" + this.selectedCategory + "/questions",
                    params: {
                        ...(value
                            ? {
                                query: "name|like|" + value,
                            }
                            : null),
                    },
                })
                    .then((response) => {
                        loading(false);
                        this.questions = response.data.data;
                    })
                    .catch(() => {
                        this.$swal({
                            icon: "error",
                            title: "Error!",
                        });
                    });
            }, 300);
        },
        selectAnswer(answer) {
            this.$emit("selectAnswer", answer);
        },
        selectProfile(profile) {
            this.selectedProfile = profile.id;
            this.getCategory();
        },
        selectCategory(category) {
            this.selectedCategory = category.id;
            this.getQuestion();
        },
        selectQuestion(question) {
            this.selectedQuestion = question.id;
            this.loadAnswers();
        },
        getProfiles()
        {
            this.$http({
                    method: "GET",
                    url: "/api/profiles"
                })
                    .then((response) => {
                        this.profiles = response.data.data;
                    })
                    .catch(() => {
                        this.$swal({
                            icon: "error",
                            title: "Error!",
                        });
                    });
        },
        getCategory(){
            this.$http({
                    method: "GET",
                    url: "/api/categories"
                })
                    .then((response) => {
                        this.categories = response.data.data;
                    })
                    .catch(() => {
                        this.$swal({
                            icon: "error",
                            title: "Error!",
                        });
                    });
        },
        getQuestion(){
            this.$http({
                    method: "GET",
                    url: "/api/surveys/" + this.selectedProfile + "/category/" + this.selectedCategory + "/questions"
                })
                    .then((response) => {
                        this.questions = response.data.data;
                    })
                    .catch(() => {
                        this.$swal({
                            icon: "error",
                            title: "Error!",
                        });
                    });
        }
    },
    mounted() {
        this.getProfiles();
        if (this.selectedProfile, this.selectedCategory, this.selectedQuestion) {
                this.loadAnswers();
            }
    }
}
</script>

<style scoped>

</style>
