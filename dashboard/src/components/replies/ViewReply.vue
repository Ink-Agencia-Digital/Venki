<template>
    <div>
        <Panel title="Detalles Respuesta">
            <div class="profile-content">
                <div class="table-responsive form-inline">
                    <table class="table table-profile">
                        <thead>
                            <tr>
                                <th></th>
                                <th>
                                    <h4>
                                        {{ reply.user.name }}
                                        <small>{{ reply.user.lastname }}</small>
                                    </h4>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="divider highlight">
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td class="field valign-middle">Teléfono</td>
                                <td>{{ reply.user.phone }}</td>
                            </tr>
                            <tr>
                                <td class="field valign-middle">Correo</td>
                                <td>
                                    <i class="fa fa-mobile fa-lg m-r-5"></i>
                                    {{ reply.user.email }}
                                </td>
                            </tr>
                            <tr>
                                <td class="field valign-middle">Nacimiento</td>
                                <td>{{ reply.user.birthday }}</td>
                            </tr>
                            <tr class="divider">
                                <td colspan="2"></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field valign-middle">Perfil</td>
                                <td>
                                    {{ reply.survey.profile.name }}
                                </td>
                            </tr>
                            <tr class="divider">
                                <td colspan="2"></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field valign-middle">Resultados</td>
                                <td>
                                    <tr
                                        v-for="(average,
                                        key,
                                        index) in reply.reply"
                                        :key="index"
                                    >
                                        <td>
                                            {{ key }}
                                        </td>
                                        <td>
                                            <span class="label label-info"
                                                >{{ average }}
                                            </span>
                                        </td>
                                    </tr>
                                </td>
                            </tr>
                            <tr class="highlight">
                                <td class="field valign-middle">Cursos</td>
                                <td>
                                    <tr
                                        v-for="(course, index) in reply.user
                                            .courses"
                                        :key="index"
                                    >
                                        <td>{{ course.name }}</td>
                                        <td>
                                            <span
                                                class="label label-lg"
                                                :class="
                                                    course.pivot.complete !=
                                                    false
                                                        ? 'label-success'
                                                        : 'label-warning'
                                                "
                                                >{{
                                                    course.pivot.complete ==
                                                    false
                                                        ? "Incompleto"
                                                        : "Completo"
                                                }}</span
                                            >
                                        </td>
                                    </tr>
                                </td>
                            </tr>
                            <tr class="divider">
                                <td colspan="2"></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field valign-middle">&nbsp;</td>
                                <td class="p-t-10 p-b-10">
                                    <button class="btn btn-primary width-150">
                                        Cerrar caso
                                    </button>
                                    <button
                                        @click="resetView"
                                        class="btn btn-white btn-white-without-border width-150 m-l-5"
                                    >
                                        Cancelar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </Panel>
    </div>
</template>

<script>
export default {
    props: {
        initialReply: {
            type: Object,
            default: null,
        },
    },
    data() {
        return { reply: { ...this.initialReply } };
    },
    methods: {
        resetView() {
            this.$emit("reset-view");
        },
    },
};
</script>

<style></style>
