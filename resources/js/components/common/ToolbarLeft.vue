<template>
        <v-toolbar color="transparent" flat>
            <v-avatar tile color="secondary" class=" elevation-12">
                <v-icon dark>{{dataBreadcrumbs.meta.icon}}</v-icon>
            </v-avatar>
            <v-toolbar-title class="ml-4 primary--text" >{{dataBreadcrumbs.meta.title}}</v-toolbar-title>
            <slot></slot>
    </v-toolbar>

</template>

<script>
export default {
    data: function () {
        return {
        dataBreadcrumbs: {},

    }},

    created()
    {
        this.dataBreadcrumbs=this.$route;
        
    }

}
</script>

<style>

</style>