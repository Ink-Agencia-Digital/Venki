<script>
var sidebarMenu = [
    { path: "/home", icon: "fa fa-home", title: "Home", id:"1" },
    { path: "/users", icon: "fa fa-user", title: "Usuarios", id:"2" },
    { path: "/usersadmin", icon: "fa fa-user-circle", title: "Administradores", id:"3" },
    { path:"/membresias",icon:"fa fa-address-card", title:"Membresias", id:"4"},
    { path: "/images", icon: "fa fa-camera", title: "Imagenes del día ", id:"5" },
    { path: "/activities", icon: "fa fa-tasks", title: "Actividades", id:"6" },
    { path:"/scores", icon:"fa fa-comments", title:"Aprobación Comentarios", id:"7"},
    { path:"/notificaciones", icon:"fa fa-exclamation", title:"Notificaciones Push", id:"8"},
    { path: "/profiles", icon: "fa fa-address-book", title: "Perfiles", id:"9" },
    { path: "/categories", icon: "fa fa-cogs", title: "Componentes", id:"10" },
    { path: "/courses", icon: "fa fa-book", title: "Cursos", id:"11" },
    { path: "/lessons", icon: "fa fa-clipboard", title: "Lecciones de Cursos", id:"12" },
    { path: "/resource", icon: "fa fa-share-alt", title: "Recursos de Lecciones", id:"13" },
    { path:"/quiz", icon:"fa fa-reply", title:"Respuestas del Quiz", id:"14"},
    { path: "/surveys", icon: "fa fa-tablet", title: "Encuesta de Diagnostico", id:"15" },
    { path: "/questions", icon: "fa fa-question", title: "Preguntas de Encuestas", id:"16" },
    { path: "/answers", icon: "fa fa-reply-all", title: "Respuestas de Encuestas", id:"17" },
    { path: "/replies", icon: "fa fa-thumbs-up", title: "Resul. Diag.", id:"18" },
    { path:"/examen", icon:"fa fa-edit", title:"Creación de Examen", id:"19"},
    { path:"/respuesta", icon:"fa fa-folder", title:"Calificación de Examen", id:"20"},
    { path:"/resultado", icon:"fa fa-box",title:"Consulta Resultados Examen", id:"21"},
    { path:"/trofeos", icon:"fa fa-trophy", title:"Trofeos e Insignias", id:"22"}
];

const sidebarMenuFilter = () => {
    let rol =sessionStorage.getItem("opcmenu").split(',');
    console.log(rol);
    let data = sidebarMenu;
    let dataFiltered = [];
    data.map(function (item) {
        rol.forEach(function (itemid){
            if(itemid==item.id)
            {
                dataFiltered.push(item);
            }
        })
    })
    return dataFiltered;
};
sidebarMenu=sidebarMenuFilter();
export default sidebarMenu;
</script>
