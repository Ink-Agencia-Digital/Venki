<template>
    <div>
        <!-- begin page-header -->
        <h1 class="page-header">
            Notificaciones 
            <small>Admnistración de notificaciones Push</small>
        </h1>
        <!-- end page-header -->

        <b-container>
            <b-row>
                <b-col md="12">
                    <transition
                        name="my-swing"
                        enter-active-class="bounce-in-top"
                        leave-active-class="bounce-out-bck"
                        mode="out-in"
                    >
                        <CreateNotificacion
                            v-if="!selectedNotificacion"
                            :key="registerKey"
                            @registrationSuccessful="registrationSuccessful"
                            @resetRegister="resetRegister"
                        />
                    </transition>
                </b-col>
                <b-col md="12">
                    <ListNotificaciones
                        ref="notificaciones-list"
                        @selectNotificacion="selectNotificacion"
                    />
                </b-col>
                <b-col md="12">
                    <transition
                        name="my-swing"
                        enter-active-class="bounce-in-top"
                        leave-active-class="bounce-out-bck"
                        mode="out-in"
                    >
                        <UpdateNotificacion
                            v-if="selectedNotificacion"
                            :initialNotificacion="selectedNotificacion"
                            :key="updateKey"
                            @resetUpdate="resetUpdate"
                            @updateSuccess="updateSuccess"
                        />
                    </transition>
                </b-col>
            </b-row>
        </b-container>
    </div>
</template>

<script>
export default {
    components: {
        CreateNotificacion: (resolve) => {
            import(
                /* webpackChunkName: "components" */ "@/components/notificaciones/CreateNotificacion.vue"
            ).then((CreateNotificacion) => {
                resolve(CreateNotificacion.default);
            });
        },
        ListNotificaciones: (resolve) => {
            import(
                /* webpackChunkName: "components" */ "@/components/notificaciones/ListNotificaciones.vue"
            ).then((ListNotificaciones) => {
                resolve(ListNotificaciones.default);
            });
        },
        UpdateNotificacion: (resolve) => {
            import(
                /* webpackChunkName: "components" */ "@/components/notificaciones/UpdateNotificacion.vue"
            ).then((UpdateNotificacion) => {
                resolve(UpdateNotificacion.default);
            });
        },
    },
    data() {
        return {
            selectedNotificacion: null,
            registerKey: 1,
            listKey: 1,
            updateKey: 1,
        };
    },
    methods: {
        selectNotificacion(notificacion) {
            this.updateKey++;
            this.selectedNotificacion = { ...notificacion };
        },
        resetRegister() {
            this.registerKey++;
        },
        resetUpdate() {
            this.selectedNotificacion = null;
            this.updateKey++;
        },
        registrationSuccessful() {
            this.resetRegister();
            this.$refs["notificaciones-list"].loadNotificaciones();
        },
        updateSuccess() {
            this.$refs["notificaciones-list"].loadNotificaciones();
        },
    },
};
</script>

<style scoped>
.bounce-in-top {
    -webkit-animation: bounce-in-top 1.1s both;
    animation: bounce-in-top 1.1s both;
}

.bounce-out-bck {
    -webkit-animation: bounce-out-bck 1.5s both;
    animation: bounce-out-bck 1.5s both;
}

@-webkit-keyframes bounce-in-top {
    0% {
        -webkit-transform: translateY(-500px);
        transform: translateY(-500px);
        -webkit-animation-timing-function: ease-in;
        animation-timing-function: ease-in;
        opacity: 0;
    }
    38% {
        -webkit-transform: translateY(0);
        transform: translateY(0);
        -webkit-animation-timing-function: ease-out;
        animation-timing-function: ease-out;
        opacity: 1;
    }
    55% {
        -webkit-transform: translateY(-65px);
        transform: translateY(-65px);
        -webkit-animation-timing-function: ease-in;
        animation-timing-function: ease-in;
    }
    72% {
        -webkit-transform: translateY(0);
        transform: translateY(0);
        -webkit-animation-timing-function: ease-out;
        animation-timing-function: ease-out;
    }
    81% {
        -webkit-transform: translateY(-28px);
        transform: translateY(-28px);
        -webkit-animation-timing-function: ease-in;
        animation-timing-function: ease-in;
    }
    90% {
        -webkit-transform: translateY(0);
        transform: translateY(0);
        -webkit-animation-timing-function: ease-out;
        animation-timing-function: ease-out;
    }
    95% {
        -webkit-transform: translateY(-8px);
        transform: translateY(-8px);
        -webkit-animation-timing-function: ease-in;
        animation-timing-function: ease-in;
    }
    100% {
        -webkit-transform: translateY(0);
        transform: translateY(0);
        -webkit-animation-timing-function: ease-out;
        animation-timing-function: ease-out;
    }
}
@keyframes bounce-in-top {
    0% {
        -webkit-transform: translateY(-500px);
        transform: translateY(-500px);
        -webkit-animation-timing-function: ease-in;
        animation-timing-function: ease-in;
        opacity: 0;
    }
    38% {
        -webkit-transform: translateY(0);
        transform: translateY(0);
        -webkit-animation-timing-function: ease-out;
        animation-timing-function: ease-out;
        opacity: 1;
    }
    55% {
        -webkit-transform: translateY(-65px);
        transform: translateY(-65px);
        -webkit-animation-timing-function: ease-in;
        animation-timing-function: ease-in;
    }
    72% {
        -webkit-transform: translateY(0);
        transform: translateY(0);
        -webkit-animation-timing-function: ease-out;
        animation-timing-function: ease-out;
    }
    81% {
        -webkit-transform: translateY(-28px);
        transform: translateY(-28px);
        -webkit-animation-timing-function: ease-in;
        animation-timing-function: ease-in;
    }
    90% {
        -webkit-transform: translateY(0);
        transform: translateY(0);
        -webkit-animation-timing-function: ease-out;
        animation-timing-function: ease-out;
    }
    95% {
        -webkit-transform: translateY(-8px);
        transform: translateY(-8px);
        -webkit-animation-timing-function: ease-in;
        animation-timing-function: ease-in;
    }
    100% {
        -webkit-transform: translateY(0);
        transform: translateY(0);
        -webkit-animation-timing-function: ease-out;
        animation-timing-function: ease-out;
    }
}

@-webkit-keyframes bounce-out-bck {
    0% {
        -webkit-transform: translateZ(0);
        transform: translateZ(0);
        -webkit-animation-timing-function: ease-out;
        animation-timing-function: ease-out;
    }
    5% {
        -webkit-transform: translateZ(-100px);
        transform: translateZ(-100px);
        -webkit-animation-timing-function: ease-in;
        animation-timing-function: ease-in;
    }
    15% {
        -webkit-transform: translateZ(0);
        transform: translateZ(0);
        -webkit-animation-timing-function: ease-out;
        animation-timing-function: ease-out;
    }
    25% {
        -webkit-transform: translateZ(-110px);
        transform: translateZ(-110px);
        -webkit-animation-timing-function: ease-in;
        animation-timing-function: ease-in;
    }
    38% {
        -webkit-transform: translateZ(0);
        transform: translateZ(0);
        -webkit-animation-timing-function: ease-out;
        animation-timing-function: ease-out;
    }
    52% {
        -webkit-transform: translateZ(-200px);
        transform: translateZ(-200px);
        -webkit-animation-timing-function: ease-in;
        animation-timing-function: ease-in;
    }
    70% {
        -webkit-transform: translateZ(0) scale(1);
        transform: translateZ(0) scale(1);
        -webkit-animation-timing-function: ease-out;
        animation-timing-function: ease-out;
    }
    85% {
        opacity: 1;
    }
    100% {
        -webkit-transform: translateZ(-900px) scale(0);
        transform: translateZ(-900px) scale(0);
        -webkit-animation-timing-function: ease-in;
        animation-timing-function: ease-in;
        opacity: 0;
    }
}
@keyframes bounce-out-bck {
    0% {
        -webkit-transform: translateZ(0);
        transform: translateZ(0);
        -webkit-animation-timing-function: ease-out;
        animation-timing-function: ease-out;
    }
    5% {
        -webkit-transform: translateZ(-100px);
        transform: translateZ(-100px);
        -webkit-animation-timing-function: ease-in;
        animation-timing-function: ease-in;
    }
    15% {
        -webkit-transform: translateZ(0);
        transform: translateZ(0);
        -webkit-animation-timing-function: ease-out;
        animation-timing-function: ease-out;
    }
    25% {
        -webkit-transform: translateZ(-110px);
        transform: translateZ(-110px);
        -webkit-animation-timing-function: ease-in;
        animation-timing-function: ease-in;
    }
    38% {
        -webkit-transform: translateZ(0);
        transform: translateZ(0);
        -webkit-animation-timing-function: ease-out;
        animation-timing-function: ease-out;
    }
    52% {
        -webkit-transform: translateZ(-200px);
        transform: translateZ(-200px);
        -webkit-animation-timing-function: ease-in;
        animation-timing-function: ease-in;
    }
    70% {
        -webkit-transform: translateZ(0) scale(1);
        transform: translateZ(0) scale(1);
        -webkit-animation-timing-function: ease-out;
        animation-timing-function: ease-out;
    }
    85% {
        opacity: 1;
    }
    100% {
        -webkit-transform: translateZ(-900px) scale(0);
        transform: translateZ(-900px) scale(0);
        -webkit-animation-timing-function: ease-in;
        animation-timing-function: ease-in;
        opacity: 0;
    }
}
</style>
