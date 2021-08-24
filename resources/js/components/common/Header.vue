<template>
  <v-app-bar  :clipped-left="$vuetify.breakpoint.lgAndUp" app color="secondary" dark >
    <v-toolbar-title style="width: 300px" class="ml-0 pl-4">
      <v-app-bar-nav-icon @click="drawerTrigger"></v-app-bar-nav-icon>
      <span class="hidden-sm-and-down">Blog </span>
    </v-toolbar-title>
    <div class="flex-grow-1"></div>
    <v-btn icon large>
      <v-avatar size="32px" item>
        <v-img :src="dataUser.image?dataUser.image:dataUser.profile_photo_url" :alt="dataUser.name"></v-img>
      </v-avatar>
    </v-btn>
  </v-app-bar>
</template>

<script>
export default {
  props: {
    source: String
  },
  data: () => ({
    isNew: false,
    drawer: false,
    dialog: false,
    dataUser: {},
  }),
  created() 
  {
    this.dataUser = this.$store.state.authUser;
  },
  watch: {

  },
  methods: {
    drawerTrigger() {
      this.drawer = !this.drawer;
      this.$emit("send", this.drawer);
    },
   
    
  }
};
</script>