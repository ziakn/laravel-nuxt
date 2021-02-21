<template>
    <v-card :color="color" dark>
        <v-card-title> 
            <v-icon left >
                {{icon}}
            </v-icon>
            <span class="title font-weight-light" >{{title}}</span>
            <v-spacer></v-spacer>
        </v-card-title>
        <v-card-text>
            <span class="display-3">{{data}}</span>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>{{action}}
        </v-card-actions>
    </v-card>
</template>

<script>
export default {
    props:{
        icon:String,
        title:String,
        data:null,
        color:String,
        action:String,
    }

}
</script>

<style>

</style>