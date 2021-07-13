<template>
    <panel ref="panelRegister" title="Creación de encuestas">
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
                            :placeholder="'Seleccione el perfil'"
                            id="profiles"
                            :clear-search-on-select="false"
                            :filterable="false"
                            @input="selectProfile"
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
                            :placeholder="'Seleccione la categoria'"
                            id="categories"
                            :clear-search-on-select="false"
                            :filterable="false"
                            @input="selectCategory"
                        ></v-select>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Sub-Categorias"
                        label-cols-md="3"
                        label-for="subcategories"
                    >
                        <v-select
                            label="name"
                            :options="childrencategories"
                            :placeholder="'Digite nombre de la subcategoria'"
                            id="subcategories"
                            :clear-search-on-select="false"
                            :filterable="false"
                            @input="selectSubCategory"
                        ></v-select>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Pregunta"
                        label-cols-md="3"
                        label-for="quesition-question"
                    >
                        <b-form-input
                            id="quesition-question"
                            type="text"
                            v-model="newQuestion.question"
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
                            <b-button variant="warning" @click="createQuestion"
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
    data() {
        return {
            newQuestion: {},
            loading: null,
            profiles: [],
            categories: [],
            childrencategories:[]
        };
    },
    methods: {
        createQuestion() {
            let loader = this.$loading.show();
            this.$http({
                method: "POST",
                url: "/api/questions",
                data: {
                    survey_id: this.newQuestion.profile_id,
                    category_id: this.newQuestion.category_id,
                    subcategory_id:this.newQuestion.subcategory_id,
                    question: this.newQuestion.question,
                }
            })
                .then(() => {
                    console.log(this.newQuestion, this.answers);
                    this.registrationSuccessful();
                    loader.hide();
                    this.$swal.fire("Exito!", "Registro exitoso", "success");
                })
                .catch((error) => {
                    console.log(this.newQuestion, this.answers);
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
        seachProfile(value, loading) {
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
        selectProfile(profile) {
            this.newQuestion.profile_id = profile.id;
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
        selectCategory(category) {
            this.newQuestion.category_id = category.id;
            this.childrencategories = category.children_categories;
        },
        selectSubCategory(subcategory){
            this.newQuestion.subcategory_id=subcategory.id;
        },
        getProfiles(){
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
        }
    },
    mounted(){
        this.getProfiles();
        this.getCategory();
    }
};
</script>

<style scoped></style>
