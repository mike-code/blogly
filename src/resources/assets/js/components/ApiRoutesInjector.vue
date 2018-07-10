<template>

</template>
<script type="text/javascript">
export default
{
	props: ['routes'],

    created()
    {
        this.$store.commit('set_api_routes', JSON.parse(this.routes));
    },
}
</script>
