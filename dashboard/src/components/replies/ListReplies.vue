<template>
    <Panel title="Lista de respuestas"> </Panel>
</template>

<script>
export default {
    data() {
        return { replies: [] };
    },
    mounted() {
        this.loadReplies();
    },
    methods: {
        loadReplies() {
            let loader = this.$loading.show();
            this.$http({
                method: "GET",
                url: "/api/replies",
            })
                .then((response) => {
                    loader.hide();
                    this.replies = response.data.data;
                })
                .catch((error) => {
                    loader.hide();
                    console.log(error);
                    this.$swal.fire("Error", "Error en el servidor", "error");
                });
        },
    },
};
</script>

<style></style>
