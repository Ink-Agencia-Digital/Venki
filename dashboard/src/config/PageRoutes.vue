<script>
const routes = [
    {
        path: "/",
        name: "login",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Login.vue").then(
                (Login) => {
                    resolve(Login.default);
                }
            ),
    },
    {
        path: "/home",
        name: "home",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Home.vue").then(
                (Home) => {
                    resolve(Home.default);
                }
            ),
        meta: {
          requiresAuth: true,
        },
    },
    {
        path: "/categories",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Category.vue").then(
                (Category) => {
                    resolve(Category.default);
                }
            ),
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/profiles",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Profile.vue").then(
                (Profile) => {
                    resolve(Profile.default);
                }
            ),
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/courses",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Course.vue").then(
                (Course) => {
                    resolve(Course.default);
                }
            ),
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/lessons",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Lesson.vue").then(
                (Course) => {
                    resolve(Course.default);
                }
            ),
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/resource",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Resource.vue").then(
                (Resource) => {
                    resolve(Resource.default);
                }
            ),
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/surveys",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Survey.vue").then(
                (Survey) => {
                    resolve(Survey.default);
                }
            ),
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/questions",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Question.vue").then(
                (Question) => {
                    resolve(Question.default);
                }
            ),
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/answers",
        name: "Answer",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Answer.vue").then(
                (Answer) => {
                    resolve(Answer.default);
                }
            ),
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/replies",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Reply.vue").then(
                (Reply) => {
                    resolve(Reply.default);
                }
            ),
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/users",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Users.vue").then(
                (Users) => {
                    resolve(Users.default);
                }
            ),
        meta: {
            requiresAuth: true,
        },
    },
     {
        path: "/images",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Image.vue").then(
                (Image) => {
                    resolve(Image.default);
                }
            ),
         meta: {
             requiresAuth: true,
         },
    },
    {
        path: "/activities",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Activity.vue").then(
                (Activity) => {
                    resolve(Activity.default);
                }
            ),
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/membresias",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Membresia.vue").then(
                (Membresia) => {
                    resolve(Membresia.default);
                }
            ),
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/quiz",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Quiz.vue").then(
                (quiz) => {
                    resolve(quiz.default);
                }
            ),
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/examen",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Examen.vue").then(
                (examen) => {
                    resolve(examen.default);
                }
            ),
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/respuesta",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Respuestas.vue").then(
                (respuesta) => {
                    resolve(respuesta.default);
                }
            ),
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/trofeos",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Trofeo.vue").then(
                (trofeo) => {
                    resolve(trofeo.default);
                }
            ),
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/resultado",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Resultados.vue").then(
                (resultado) => {
                    resolve(resultado.default);
                }
            ),
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/notificaciones",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Notification.vue").then(
                (notificacion) => {
                    resolve(notificacion.default);
                }
            ),
        meta: {
            requiresAuth: true,
        }
    },
    {
        path:"/politica",
        component:(resolve)=>
            import(/*webpackChunkName: "pages" */ "@/pages/Politica.vue").then(
                (politica)=>{
                    resolve(politica.default);
                }
            ),
            
    },
     {
        path:"/terminos",
        component:(resolve)=>
            import(/*webpackChunkName: "pages" */ "@/pages/Terminos.vue").then(
                (terminos)=>{
                    resolve(terminos.default);
                }
            ),
            
    },
    {
        path: "Configuracion/scores",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/Scores.vue").then(
                (scores) => {
                    resolve(scores.default);
                }
            ),
        meta: {
            requiresAuth: true,
        }
    },
    {
        path: "/usersadmin",
        component: (resolve) =>
            import(/* webpackChunkName: "pages" */ "@/pages/UsersAdmin.vue").then(
                (usersadmin) => {
                    resolve(usersadmin.default);
                }
            ),
        meta: {
            requiresAuth: true,
        }
    }
    
];

export default routes;
</script>
