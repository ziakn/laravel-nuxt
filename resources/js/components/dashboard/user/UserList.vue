<template>
	<v-main >
		<v-container fluid> 
		 	<v-overlay :value="showFullLoading" :absolute="absolute">
				<v-progress-circular indeterminate size="64"></v-progress-circular>
			</v-overlay>
			<ToolbarLeft>
				<v-spacer></v-spacer>
				<v-text-field
					v-model="search"
					append-icon="search"
					label="Search"
					hide-details
					filled 
					dense
				></v-text-field>
			</ToolbarLeft>
			<Breadcrumbs/>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="12">
					<v-data-table color="white" :headers="headers" :items="dataList" :search="search"  class="elevation-12" :items-per-page="20" :hide-default-footer="true">>
					
						  <template v-slot:[`item.status`]="{ item }">
                                    <v-switch v-model="item.status" @change="changeStatus(item)" color="primary" inset></v-switch>
                            </template>
							<template v-slot:[`item.action`]="{ item }">
								<v-icon color="blue"  medium @click="editItem(item)" >edit</v-icon>
							<v-icon color="red"  medium @click="deleteItem(item)" >delete</v-icon>
						</template>
						<template v-slot:no-data>
							<NoDataList :loading="loading" @initialize="initialize"></NoDataList>
						</template>
					</v-data-table>
					<div class="text-center">
                                <v-pagination
                                v-model="filters.page"
                                :length="pageCount"
                                @input="getUser"
                                ></v-pagination>
                            </div>
				</v-col>
			</v-row>
			<v-btn bottom  color="primary" dark fab fixed right @click="dialog = !dialog">
				<v-icon>mdi-plus</v-icon>
			</v-btn>
		</v-container>
        <v-dialog v-model="dialog" max-width="500px" persistent>
            <v-card>
				<v-card color="secondary" dark :tile="true" flat >
					<v-card-title
					class="headline"
					v-text="formTitle"
					></v-card-title>
         		 </v-card >
                <v-card-title>
                </v-card-title>

                <v-card-text>
                    <v-container grid-list-md>
                        <v-layout wrap>
							<v-flex xs12 sm12 md12>
								<v-select
								 	v-model="editedItem.role_id"
                                    :items="dataRole"
                                    item-text="name"
                                    item-value="id"
                                    :rules="[v => !!v || 'Role  is required']"
                                    label="Select Role"
                                    required
                                    
									filled
								>
								</v-select>
							</v-flex>
                            <v-flex xs12 sm12 md12>
                                <v-text-field
                                    v-model="editedItem.name"
                                    label="Full Name"
                                    :rules="[v => !!v || 'Name is required']"
                                    required
                                     filled 
                                        
                                ></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm12 md12>
                                <v-text-field
                                    :disabled="!edit"
                                    :rules="emailRules"
                                    v-model="editedItem.email"
                                    label="Email"
									type="email"
                                     filled 
                                        
                                ></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm12 md12>
                                <v-text-field
                                    v-model="editedItem.mobile"
									label="Mobile"
									:rules="mobileRules"
									type="number"
									 filled 
                                        
                                ></v-text-field>
							</v-flex>
							<v-flex xs12 sm12s md12 v-if="edit">
                                <v-text-field
                                    v-model="editedItem.password"
                                    :rules="passwordRules"
                                    label="Password"
                                    type="password"
                                     filled 
                                        
                                ></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm12 md12>
                                <v-textarea v-model="editedItem.address" label="Address"  filled 
                                        ></v-textarea>
                            </v-flex>
                           
                        </v-layout>
                    </v-container>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="error" text @click="close">Cancel</v-btn>
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
			<DeleteModal :trigger="isDelete" :title="deleteTitle" :body="deleteBody" @request="remove"></DeleteModal>
	</v-main>
</template>

<script>
import Breadcrumbs from "./../../common/Breadcrumbs"
import ToolbarLeft from "./../../common/ToolbarLeft"
import NoDataList from "./../../common/NoDataList"
import DeleteModal from "./../../common/DeleteModal";
export default {
	components:{
		Breadcrumbs,
		ToolbarLeft,
		NoDataList,
		DeleteModal
	},
	data: () => ({
		search: "",
		absolute: true,
		loading: false,
		edit: true,
		dialog: false,
		dataList: [],
		dataRole: [],
		dataIndex: null,
		deleteTitle: "",
		deleteBody: "",
		isDelete: false,
        itemsPerPage:1,
		pageCount:2,
	 filters:
        {
			page: 1,
			show: 20,
        },
		
		headers: [
			{ text: "ID", align: "left", value: "id" },
			{ text: "Name", value: "name" },
			{ text: "Email", value: "email" },
			{ text: "Mobile", value: "mobile" },
			{ text: "Status", value: "status" },
			{ text: "Action", value: "action" }
		],
		emailRules: [
			v => !!v || "E-mail is required",
			v => /.+@.+.\.+.+/.test(v) || "E-mail must be valid"
		],
		usernameRules: [
			v => !!v || "Name is required",
			v => (v || "").indexOf(" ") < 0 || "No spaces are allowed"
		],
		passwordRules: [
			v => (v || "").length >= 8 || `A minimum of 8 characters is allowed`
		],
		mobileRules: [
			v => (v || "").length >= 8 || `A minimum of 8 characters is allowed`
		],
		editedIndex: -1,
		editedItem: {
			role_id:null,
			name: "",
			email: "",
			mobile: "",
			address: "",
			status: 1,
			password:'',
		},
		defaultItem: {
			role_id:null,
			name: "",
			email: "",
			type: '',
			mobile: "",
			address: "",
			status: 1,
			password:'',
		},
		
	}),

	props: 
	{
		source: String
	},

	computed: 
	{
		formTitle() 
		{
			return this.editedIndex === -1 ? "New User" : "Edit User";
		}
	},
	watch: {},

	created() 
	{
		this.initialize();
	},

	methods: {
		async initialize() 
		{
			this.getUser();
			this.getRole();
		},

		async getRole()
		{
			
			try 
			{
				let { data } = await axios({
					method: "get",
					url: "/app/role",
				});
				this.dataRole = data;
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

		async getUser()
		{
			this.start();
			try 
			{
				let { data } = await axios({
					method: "get",
					url: "/app/user",
					 params: this.filters
				});
				this.dataList = data.data;
                this.itemsPerPage=data.per_page;
                this.pageCount=data.last_page;
                this.filters.page=data.current_page
				
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

	async changeStatus(i)
		{
			this.loading = true;
			try {
				let { data } = await axios({
					method: "get",
					url: "/app/user/"+i.id+"/edit",
					params:{
						status: i.status
					},

				});
				if (data.status) 
				{
					this.snacks("Successfully Changed", "green");
					this.close();
				} 
				else 
				{
					this.snacks("Failed", "red");
					this.loading = false;
				}
			} 
			catch (e) 
			{
				this.snacks("Error, Server issue", "red");
				this.loading = false;
			}
		},
		
		editItem(item) 
		{
			this.edit = false;
			this.editedIndex = this.dataList.indexOf(item);
			this.editedItem = Object.assign({}, item);
			this.editedItem.role_id = item.userrole.role_id
			this.dialog = true;
		},
		
		deleteItem(item) 
		{
			this.dataIndex = this.dataList.indexOf(item);
			this.deleteTitle = "Are you sure you want to delete this item?";
			this.isDelete = !this.isDelete;
		},
		
		close() 
		{
			this.dialog = false;
			this.loading = false;
			this.edit = true;
			setTimeout(() => {
				this.editedItem = Object.assign({}, this.defaultItem);
				this.editedIndex = -1;
			}, 300);
		},
		
		async save() 
		{
			this.loading = true;
			if (this.editedIndex > -1) 
			{
				try 
				{
					let { data } = await axios({
						method: "put",
						url: "/app/user/" + this.editedItem.id,
						data: this.editedItem
					});
					if (data.status) 
					{
						this.snacks("Successfully Added", "green");
						Object.assign(this.dataList[this.editedIndex], data.data);
						this.close();
					} 
					else 
					{
						this.snacks("Failed", "red");
						this.loading = false;
					}
				} 
				catch (e) 
				{
					this.snacks("Failed", "red");
					this.loading = false;
				}
			} 
			else 
			{
				try 
				{
					let { data } = await axios({
						method: "post",
						url: "/app/user",
						data: this.editedItem
					});
					if (data.status) 
					{
						this.dataList.unshift(data.data);
						this.snacks("Successfully Added", "green");
						this.close();
					} 
					else 
					{
						this.snacks("Failed", "red");
						this.loading = false;
					}
				} 
				catch (e) 
				{
					this.snacks("Failed", "red");
					this.loading = false;
				}
			}
		},
		async remove() {
			try {
				let { data } = await axios({
				method: "delete",
				url: "/app/user/" + this.dataList[this.dataIndex].id
				});
				if (data.status) {
					this.snacks('Successfully Done','green')
					this.dataList.splice(this.dataIndex, 1);
					this.close();				
				}
				else
				{
					this.snacks(data.data,'yellow darken-4')
					this.loading = false;
				}
			} catch (e) {
				this.snacks('Operation Failed','red')

			}
		}
	}
};
</script>