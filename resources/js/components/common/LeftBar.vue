<template>
  <div>
    <v-navigation-drawer
      v-model="drawer"
      :clipped="$vuetify.breakpoint.lgAndUp"
      color="primary"
      dark
      app

    >
      <v-list  dense>
        <v-list-group
          v-for="(item,index) in items"
          :key="index"
          v-model="item.model"
          :prepend-icon="item.meta.icon"
          active-class="black elevation-8  white--text"
          v-show="isShow(item.meta)"
        >
          <template v-slot:activator >
            <v-list-item  >
              <v-list-item-content>
                <v-list-item-title>{{ item.meta.title }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </template>
          <v-list-item 
          dark
            v-for="(child, i) in item.children"
            :key="i"
            :to="handleGoToMenu(item.path+'/'+child.path)"
            active-class="secondary white--text"
            v-show="isShow(child.meta) && child.meta.status"
          >
            <v-list-item-content>
              <v-list-item-title>
                <v-icon x-small color="rgba(255, 255, 255, 0.3)">fiber_manual_record</v-icon>
                 {{ child.meta.title }}
            </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-group>
      </v-list>
        <template v-slot:append>
        <div class="pa-2">
            <p class="text-center white--text " > Version 1.0 </p>
          <v-btn block href="/logoutuser">Logout</v-btn>
        </div>
      </template>

    </v-navigation-drawer>
     <v-dialog v-model="showDialog" width="500" persistent>
      <v-card>
        <v-card :color="showClose ? 'green' : 'red'" dark flat>
          <v-card-title v-if="showClose">Internet working</v-card-title>
          <v-card-title v-else>No Internet</v-card-title>
        </v-card>
        <v-card-title></v-card-title>
        <v-card-text>
          <h4 v-if="showClose">You have become online. You can close now.</h4>
          <h4 v-else>
            The internet is disconnected. Kindly connect to an internet source.
          </h4>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn v-if="showClose" text color="green" @click="handleClose"
            >Close</v-btn
          >
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  props: {
    trigger: true,
    items:Array,
  },
data: function () {
    return {
    drawer: true,
    showClose: false,
    showDialog: false,
  }},
  watch: {
    trigger() {
      this.drawer = !this.drawer;
    }
  },
    mounted() {
    window.addEventListener("online", () => {
      this.showClose = true;
    });
    window.addEventListener("offline", () => {
      this.showDialog = true;
    });
  },
  methods: {
    logout()
    {
      

    },
     handleClose() {
      this.showDialog = !this.showDialog;
      this.showClose = !this.showClose;
    },
      isShow(item)
      {
          let flag=false;
          for(let i=0;i<item.type.length;i++)
          {
              if(item.type[i]==1)
              {
                  return flag=true;
                  
              }
          }
          return flag;

      },
    handleGoToMenu(d) {
      return d;
    },
    showChild(link) {
      if(link)
      return true;
      else
      return false;
    }
  }
};
</script>