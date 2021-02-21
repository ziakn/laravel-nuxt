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
                  <span class="title font-weight-light" dark>Profile</span>
                </v-card-title>
                <v-card-text>
                  <v-row>
                    <v-col sm="12" md="12" lg="12">
                      <v-text-field v-model="dataList.id" label="ID" required disabled  outlined dense></v-text-field>
                    </v-col>
                    <v-col sm="12" md="12" lg="6">
                      <v-text-field
                        v-model="dataList.email"
                        label="Email Address"
                        required
                        disabled
                        outlined 
                        dense
                      ></v-text-field>
                    </v-col>
                    <v-col sm="12" md="12" lg="6">
                      <v-text-field v-model="dataList.name" label="Name" required  outlined dense></v-text-field>
                    </v-col>
                    <v-col sm="12" md="12" lg="12">
                      <v-text-field v-model="dataList.mobile" label="Mobile" required  outlined  dense></v-text-field>
                    </v-col>
                    <v-col sm="12" md="12" lg="12">
                      <v-textarea
                        v-model="dataList.address"
                        label="Address"
                        outlined 
                         dense
                      ></v-textarea>
                    </v-col>
                  </v-row>
                  <v-row align="center">
                    <div class="ml-5">
                      <v-btn color="primary" :loading="loading" :disabled="loading" @click="editProfile">Update</v-btn>                      
                    </div>
                  </v-row>
                </v-card-text>
              </v-card>
            </v-col>
          </v-row>
        </v-col>

        <v-col sm="12" md="4" lg="4">
          <v-card max-width="344" class="mx-auto mb-1" >
            <v-img
              :src="dataList.image?dataList.image:dataList.profile_photo_url"
              height="194"
            ></v-img>
             <v-card-title>
                {{ dataList.name }}
              </v-card-title>
            <v-card-text>
            </v-card-text>
            <v-card-actions>
              <v-btn dark color="primary" @click="changePassword()">Password</v-btn> <v-btn :loading="loading" :disabled="loading" dark color="blue-grey" @click="$refs.inputUpload.click()">
                    Image<v-icon right >add_a_photo</v-icon>
                  </v-btn>
                  <input
                    v-show="false"
                    ref="inputUpload"
                    accept="image/*"
                    type="file"
                    @change="profileChange"
                  />
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>

      <v-dialog v-model="dialog" persistent max-width="600px">
        <v-card>
          <v-card-title>
            <span class="headline">User Profile</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col  cols="12">
                  <v-text-field
                    v-model="password.oldPassword"
                    label="Current Password*"
                    :rules="passwordRules"
                    required
                    outlined 
                    dense
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    v-model="password.newPassword"
                    label="New Password*"
                    :rules="passwordRules"
                    required
                    outlined 
                    dense
                  ></v-text-field>
                </v-col>

                <v-col cols="12">
                  <v-text-field
                    v-model="password.confirmPassword"
                    :rules="[
                    v => v == password.newPassword || 'Should be same as new password']"
                    label="Confirm Password*"
                    required
                    outlined 
                    dense
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-container>
            <small>*indicates required field</small>
          </v-card-text>
          <v-card-actions>
            <div class="flex-grow-1"></div>
            <v-btn color="red darken-1" text @click="dialog = false">Close</v-btn>
            <v-btn
              color="primary"
              :loading="loading"
              :disabled="loading"
              text
              @click="save"
            >Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

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
    dataList: {},

    headers: 
    [
			{ text: "Ip", value: "ip_address" },
			{ text: "Action", value: "action" }
		],

    password: 
    {
      oldPassword: "",
      newPassword: "",
      confirmPassword: ""
    },

    defaultPassword:
    {
      oldPassword: "",
      newPassword: "",
      confirmPassword: ""
    },

    passwordRules: 
    [
      v => (v || "").length >= 8 || `Minimum Password charecter is 8`
    ],

    confirmPasswordRules: 
    [
      v => (v || "").length >= 8 || `Minimum Password charecter is 8`,
      v => v == password.newPassword || "Should be same as new password"
    ]

  }),

  watch: {},

  created() 
  {
      this.initialize();
  },

  methods: {

    async editProfile() 
    {
        this.loading = true;
        try 
        {
        let { data } = await axios({
          method: "put",
          url: "/app/user/"+this.dataList.id,
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

   

    changePassword() 
    {
        this.dialog = true;
    },

    async save() 
    {
        this.loading = true;
        try 
        {
        let { data } = await axios({
          method: "post",
          url: "/app/changepassword",
          data: this.password
        });
        if (data.status) 
        {
          this.snacks("Successfully Changed", "green");
          this.close();
        } 
        else 
        {
          this.snacks(data.message, "red");
          this.loading = false;
        }
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
        try 
        {
          let { data } = await axios({
            method: "get",
            url: "/app/profile"
          });
          this.dataList = data;
        } 
        catch (e) 
        {
          this.fail();
        }
        finally
        {
          this.finish();
        }

       
      
    },

    async profileChange(e) 
    {
        this.imageFile = event.target.files[0];
        this.upload();
    },

    async upload() 
    {
        this.loading=true;
        const formData = new FormData();
        formData.append("myFile", this.imageFile, this.imageFile.name);
        try 
        {
          let { data } = await axios({
            method: "post",
            url: "/app/avatar",
            data: formData
          });
          this.dataList.image = data.data;
          this.snacks("Successfully Uploaded", "green");
            this.close();
          this.loading=false;
        } 
        catch (error) 
        {
          this.snacks("Operation Failed", "red");
          this.loading=false;
        }
    },
  },
  
};
</script>

<style>
</style>