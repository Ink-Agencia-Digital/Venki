<template>
    <div>
        <ListReplies />
    </div>
</template>

<script>
export default {
    components: {
        ListReplies: (resolve) => {
            import(
                /* webpackChunkName: "components" */ "@/components/replies/ListReplies.vue"
            ).then((ListReplies) => {
                resolve(ListReplies.default);
            });
        },
    },
};
</script>

<style></style>
