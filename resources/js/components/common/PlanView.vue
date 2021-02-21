<template>
    <v-dialog v-model="dialog" persistent max-width="400">
            <v-tabs centered grow color="primary">
                    <v-tab :href="`#tab-1`">Plans Page</v-tab>
                    <v-tab :href="`#tab-2`">Home Page</v-tab>
                    <v-tab-item :value="'tab-1'">
        <v-card flat>
        <v-card-text>
      <v-row>
      <v-col >
        <v-card   class="mx-auto" max-width="85%" shaped>
            	<v-card color="secondary" dark   shaped>
					<v-card-title
					class="text-center justify-center py-1"
					>
                    {{planData.title}}
                    </v-card-title>
         		 </v-card >
        <v-card-text>
          <p></p>
            <p class="display-1 text-center primary--text">{{planData.price}}</p>
            <v-divider class="mx-4 primary"></v-divider>
            <v-list-item  v-for="(item, index) in planData.planattribute" :key="index">
            <v-list-item-icon >
                <v-icon color="purple">mdi-send</v-icon>
            </v-list-item-icon>
            <v-list-item-subtitle>{{item.attribute.name}}</v-list-item-subtitle>
            </v-list-item>
        </v-card-text>
        <v-divider class="mx-4 primary"></v-divider>
        <v-card-actions color="primary" class="display-1 text--primary justify-center">
         {{planData.duration}}
        </v-card-actions>
        </v-card>
        </v-col>
        </v-row>
          </v-card-text>
            <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="red darken-1" text @click="dialog = false">Close</v-btn>
            </v-card-actions>
        </v-card>
            </v-tab-item>
                    <v-tab-item :value="'tab-2'">
                             <v-card flat>
        <v-card-text>
      <v-row>
      <v-col >
        <v-card   class="mx-auto" max-width="85%" shaped>
            	<v-card color="secondary" dark   shaped>
					<v-card-title
					class="text-center justify-center py-1"
					>
                    {{planData.title}}
                    </v-card-title>
         		 </v-card >
        <v-card-text>
          <p></p>
            <p class="display-1 text-center primary--text">{{planData.price}}</p>
            <v-divider class="mx-4 primary"></v-divider>
            <v-list-item  v-for="(item, index) in planData.homepageattribute" :key="index">
            <v-list-item-icon >
                <v-icon color="purple">mdi-send</v-icon>
            </v-list-item-icon>
            <v-list-item-subtitle>{{item.attribute.name}}</v-list-item-subtitle>
            </v-list-item>
        </v-card-text>
        <v-divider class="mx-4 primary"></v-divider>
        <v-card-actions color="primary" class="display-1 text--primary justify-center">
         {{planData.duration}}
        </v-card-actions>
        </v-card>
        </v-col>
        </v-row>
          </v-card-text>
            <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="red darken-1" text @click="dialog = false">Close</v-btn>
            </v-card-actions>
        </v-card>
           </v-tab-item>
                    </v-tabs>
    </v-dialog>
</template>
<script>
export default {
     components: {
    },
    data: () => ({
        dialog:false,
        
    }),
    props:
    {
        trigger: false,
        planData: Object,

    },
    methods:
    {        
        
    },

    computed:{
	  


    },
    watch:{
        trigger() {
            this.dialog=true
            }
    }

}
</script>
