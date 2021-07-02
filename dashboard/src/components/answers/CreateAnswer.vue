<template>
    <panel ref="panelRegister" title="Creacion de respuestas">
        <b-container>
            <b-row class="m-t-10 m-b-10">
                <b-col md="10" offset-md="1">
                    <b-form-group
                        class="row"
                        label="Perfil"
                        label-cols-md="3"
                        label-for="profiles"
                    >
                        <v-select
                            label="name"
                            :options="profiles"
                            :placeholder="'Digite nombre del perfl'"
                            id="profiles"
                            :clear-search-on-select="false"
                            :filterable="false"
                            @input="selectProfile"
                            @search="searchProfile"
                        ></v-select>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Categoria"
                        label-cols-md="3"
                        label-for="categories"
                    >
                        <v-select
                            label="name"
                            :options="categories"
                            :placeholder="'Digite nombre de la categoria'"
                            id="categories"
                            :clear-search-on-select="false"
                            :filterable="false"
                            @input="selectCategory"
                            @search="searchCategory"
                        ></v-select>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Pregunta"
                        label-cols-md="3"
                        label-for="questions"
                    >
                        <v-select
                            label="question"
                            :options="questions"
                            :placeholder="'Seleccione la pregunta para asociar respuesta'"
                            id="questions"
                            :clear-search-on-select="false"
                            :filterable="false"
                            @input="selectQuestion"
                            @search="searchQuestion"
                        ></v-select>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Respuesta"
                        label-cols-md="3"
                        label-for="answer-answer"
                    >
                        <b-form-input
                            id="answer-answer"
                            type="text"
                            v-model="newAnswer.answer"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Puntaje"
                        label-cols-md="3"
                        label-for="answer-point"
                    >
                        <b-form-input
                            id="answer-point"
                            type="number"
                            v-model="newAnswer.point"
                            required
                        ></b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col md="4" offset-md="6">
                    <b-row>
                        <b-col col sm="6" md="4" offset-md="0">
                            <b-button
                                variant="outline-primary"
                                @click="resetRegister"
                            >Limpiar</b-button
                            >
                        </b-col>
                        <b-col col sm="6" md="4" offset-md="1">
                            <b-button variant="warning" @click="createAnswer"
                            >Registrar</b-button
                            >
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
        </b-container>
    </panel>
</template>

<script>
let searchTimer = null;
export default {
    name: "CreateAnswer",
    data() {
        return {
            newAnswer: {},
            loading: null,
            profiles: [],
            categories: [],
            questions: [],
            selectedProfile: null,
            selectedCategory: null,
            selectedQuestion: null,
        };
    },
    methods: {
        createAnswer() {
            let loader = this.$loading.show();
            this.$http({
                method: "POST",
                url: "/api/answers",
                data: {
                    question_id: this.newAnswer.question_id,
                    answer: this.newAnswer.answer,
                    point: this.newAnswer.point,
                }
            }).then(() => {
                console.log(this.newAnswer);
                this.registrationSuccessful();
                loader.hide();
                this.$swal.fire("Exito!", "Registro exitoso", "success");
            }).catch((error) => {
                console.log(this.newAnswer, this.answers);
                console.log(error);
                loader.hide();
                this.$swal
                    .fire("Error!", "Error durante el registro", "error")
                    .then(() => {
                        this.resetRegister();
                    });
            });
        },
        resetRegister() {
            this.$emit("resetRegister");
        },
        registrationSuccessful() {
            this.$emit("registrationSuccessful");
            this.resetRegister();
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
        selectProfile(profile) {
            //this.newAnswer.profile_id = profile.id;
            this.selectedProfile = profile.id;
        },
        selectCategory(category) {
            //this.newAnswer.category_id = category.id;
            this.selectedCategory = category.id;
        },
        selectQuestion(question) {
            //this.newAnswer.question_id = question.id;
            this.selectedQuestion = question.id;
            this.newAnswer.question_id = question.id;
        },
    },
}
</script>

<style scoped></style>
