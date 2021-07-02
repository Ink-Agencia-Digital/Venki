<template>
    <panel ref="panelRegister" title="Creación de Examen">
        <b-container>
            <b-row class="m-t-10 m-b-10">
                <b-col md="10" offset-md="1">
                    <b-form-group
                        class="row"
                        label="Curso"
                        label-cols-md="3"
                        label-for="courses"
                    >
                        <v-select
                            label="name"
                            :options="courses"
                            v-model="selectedCourse"
                            :placeholder="'Digite nombre del curso'"
                            id="courses"
                            :clear-search-on-select="true"
                            :filterable="false"
                            @input="selectCourse"
                            @search="searchCourse"
                        ></v-select>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Descripción"
                        label-cols-md="3"
                        label-for="examen-description"
                    >
                        <b-form-input
                            id="examen-description"
                            v-model="newExamen.descripcion"
                            type="text"
                        ></b-form-input>
                        <v-button type="button" class="btn btn-primary" @click="insertarExamen">Agregar Preguntas</v-button>
                    </b-form-group>
                    <b-form-group 
                        class="row"
                        label="Pregunta"
                        label-cols-md="3"
                        v-if="preguntas"
                        label-for="Examen-pregunta">
                        <b-form-input 
                            id="Examen-pregunta" 
                            v-model="newPregunta.pregunta"
                            placeholder="Escribe la pregunta y selecciona el tipo de respuesta"
                            required>
                        </b-form-input>
                        <v-select
                            id="AnswerType"
                            :options="['Abierta', 'Numérica', 'Multiple']"
                            v-model="newPregunta.tiporespuesta"
                            @input="selectAnswer"
                            :clearable="false"
                        ></v-select>
                        <b-form
                            class="row"
                            v-if="newPregunta.tiporespuesta=='Multiple'">
                            <b-row>
                                <b-form-input id="quiz-answer" class="col-md-6" placeholder="respuesta" v-model="optionanswer"></b-form-input>
                                <v-button type="button" class="btn btn-circle btn-primary col-md-2" @click="insertAnswer" v-if="edit==false"><i class="fa fa-plus"></i></v-button>
                                <v-button type="button" class="btn btn-circle btn-warning col-md-2" @click="saveAnswer" v-if="edit==true"><i class="fa fa-edit"></i></v-button>
                                <v-button type="button" class="btn btn-circle btn-danger col-md-2" @click="deleteAnswer" v-if="edit==true"><i class="fa fa-trash"></i></v-button>
                            </b-row>
                        </b-form>
                        <b-row>
                            <b-list-group v-if="quiz_answers.length>0">
                                <b-list-group-item v-for="(item,index) in quiz_answers" v-bind:key="item"><a @click="editar(item,index)">{{item}}</a></b-list-group-item>
                            </b-list-group>
                        </b-row>
                        <b-form-input
                            id="Valor-pregunta"
                            v-model="newPregunta.valor"
                            type="number"
                            placeholder="Valor dado a la pregunta">
                        </b-form-input>
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
                            <b-button variant="warning" @click="createPregunta"
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
            newExamen: {},
            newPregunta:{},
            loading: null,
            courses: [],
            quiz_answers:[],
            optionanswer:'',
            selectedCourse: null,
            keyDrop: 0,
            selectedAnswer:"Abierta",
            edit:false,
            editindex:0,
            idexamen:0,
            totalpreguntas:0,
            preguntas:false,
            nuevoexamen:true
        };
    },
    components: {
        
    },
    methods: {
        resetRegister() {
            this.$emit("resetRegister");
        },
        registrationSuccessful(idexamen) {
            this.$emit("registrationSuccessful",idexamen);
            //this.resetRegister();
        },
        searchCourse(value, loading) {
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
        selectCourse(course) {
            this.selectedCourse = course.id;
            this.newExamen.id_course=this.selectedCourse;
            if(course.examen.id!=null){
                this.newExamen.descripcion=course.examen.descripcion;
                this.newPregunta.id_examen=course.examen.id;
                this.nuevoexamen=false;
                this.idexamen=course.examen.id;
            }
        },
        sendSuccess() {
            this.registrationSuccessful();
            this.$swal.fire("Exito!", "Registro exitoso", "success");
        },
        insertarExamen(){
            console.log(this.nuevoexamen);
            if(this.newExamen.descripcion=="")
                this.newExamen.descripcion="Examen";
            if(this.nuevoexamen==true)
            {
                this.$http({
                method:"POST",
                url:"/api/examen",
                data: this.newExamen,
                })
                .then((res)=>{
                    this.$swal.fire("Exito","Puede ingresar las preguntas","success");
                    this.newPregunta.id_examen=res.data.data.id;
                    this.idexamen=res.data.data.id;
                    this.preguntas= true;
                })
                .catch((error)=>{
                    console.log(error);
                    this.$swal.fire(
                            "Error",
                            "Error creando examen",
                            "error"
                        );
                })
            }
            else{
                this.preguntas = true;
            }
            
        },
        createPregunta() {
            this.newPregunta.opciones=this.quiz_answers.join();
            this.$http({
                method: "POST",
                url: "/api/preguntaexamen",
                data: this.newPregunta,
            })
                .then((res) => {
                    console.log(res.data);
                    this.$swal.fire("Exito", "Pregunta creada", "success");
                    this.registrationSuccessful(res.data.data.id_examen);
                    this.newPregunta = {};
                    this.newPregunta.id_examen=this.idexamen;
                    this.quiz_answers=[];
                })
                .catch((error) => {
                    console.log(error);
                    this.$swal.fire(
                        "Error",
                        "Error creando pregunta",
                        "error"
                    );
                });
        },
        sendError() {
            this.$swal.fire("Error!", "Registro fallido", "error").then(() => {
                this.resetRegister();
            });
        },
        sendingEvent(file, xhr, formData) {
            Object.keys(this.newPregunta).forEach((key) => {
                formData.append(key, this.newPregunta[key]);
            });
        },
        insertAnswer(){
            if(this.quiz_answers.length==5){
                this.$swal.fire("Advertencia!","Máximo 5 respuestas.","warning");
                return;
            }
            this.quiz_answers.push(this.optionanswer);
            this.optionanswer='';
        },
        editar(item,index){
            this.edit=true;
            this.editindex=index;
            this.optionanswer=item.option;
        },
        saveAnswer(){
            this.quiz_answers[this.editindex]=this.optionanswer;
            this.edit=false;
            this.optionanswer='';
        },
        deleteAnswer(){
            this.quiz_answers.splice(this.editindex,1);
            this.edit=false;
            this.optionanswer='';
        }
    },
};
</script>

<style scoped>
.subtitle {
    color: #314b5f;
    font-size: medium;
}
</style>
