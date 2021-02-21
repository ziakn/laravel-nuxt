<template>
  <v-main>
    <v-container fluid>
      <v-overlay :value="showFullLoading" :absolute="absolute">
				<v-progress-circular indeterminate size="64"></v-progress-circular>
			</v-overlay>
			<ToolbarLeft>
			</ToolbarLeft>
			<Breadcrumbs/>
      <v-row justify="center">
        <v-col sm="12" md="6" lg="6">
          <v-row>
            <v-col lg="12">
              <v-card>
                <v-card-title>
                  <span class="title font-weight-light" dark>Socail Links</span>
                </v-card-title>
                <v-card-text>
                  <v-row>
                    <v-col sm="12" md="12" lg="12">
                      <v-text-field v-model="dataList.facebook" label="Facebook" required  outlined></v-text-field>
                    </v-col>
                     <v-col sm="12" md="12" lg="12">
                      <v-text-field v-model="dataList.twitter" label="Twitter" required  outlined></v-text-field>
                    </v-col>
                     <v-col sm="12" md="12" lg="12">
                      <v-text-field v-model="dataList.snapchat" label="Snap Chat" required  outlined></v-text-field>
                    </v-col>
                     <v-col sm="12" md="12" lg="12">
                      <v-text-field v-model="dataList.instagram" label="Instagram" required  outlined></v-text-field>
                    </v-col>
                     <v-col sm="12" md="12" lg="12">
                      <v-text-field v-model="dataList.youtube" label="Youtube" required  outlined></v-text-field>
                    </v-col>
                  </v-row>
                       <v-row align="center">
                    <div class="ml-5">
                      <v-btn color="primary" :loading="loading" :disabled="loading" @click="editSocial">Update</v-btn>                      
                    </div>
                  </v-row>
                </v-card-text>
            
            
             
              </v-card>
            </v-col>
          </v-row>
        </v-col>


      </v-row>
   <v-snackbar
        v-model="snackbar"
        :vertical="snackvertical"
        :timeout="snacktimeout"
        :top="snacktop"
        :right="snackright"
        :color="snackcolor"
      >
        {{ snacktext }}
       <template v-slot:action="{ attrs }">
        <v-btn dark text v-bind="attrs" @click="snackbar = false" > Close</v-btn>
         </template>
      </v-snackbar>
    </v-container>
  </v-main>
</template>

<script>
import ToolbarLeft from "./../../common/ToolbarLeft";
import Breadcrumbs from "./../../common/Breadcrumbs";
export default {
  components:
  {
    ToolbarLeft,
    Breadcrumbs
  },
  data: () => ({
    absolute:false,
    imageFile:null,
    loading: false,
    edit: false,
    dialog: false,
    dataUser: [],
    dataList: {},


  
  }),
  watch: {},
  created() 
  {
    this.initialize();
  },
  methods: {
    async editSocial() 
    {
      this.loading = true;
      try 
      {
        let { data } = await axios({
          method: "put",
          url: "/app/social/"+this.dataList.id,
          data: this.dataList
        });
        this.snacks("Successfully Done", "green");
        this.close();
      } 
      catch (e) 
      {
        this.loading = false;
        this.snacks("Operation Failed", "red");
      }
    },

 

  

    close() 
    {
      this.dialog = false;
      this.loading = false;
     	setTimeout(() => {
				this.password = Object.assign({}, this.defaultPassword);
			}, 300);
    },

    async initialize() 
    {
      this.start();
      try {
        let { data } = await axios({
          method: "get",
          url: "/app/social"
        });
        this.dataList = data;
      } 
      catch (e) 
      {
        this.fail();
      }
      this.finish();
    },

    

   
  },
  
};
</script>

<style>
</style>