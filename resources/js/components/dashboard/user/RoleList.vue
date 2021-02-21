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
						
							<template v-slot:[`item.action`]="{ item }">
								<v-icon color="blue"   medium @click="editItem(item)" >edit</v-icon>
							<v-icon color="red"   medium @click="deleteItem(item)" >delete</v-icon>
						</template>
						<template v-slot:no-data>
							<NoDataList :loading="loading" @initialize="initialize"></NoDataList>
						</template>
					</v-data-table>
					<div class="text-center">
                                <v-pagination
                                v-model="filters.page"
                                :length="pageCount"
                                @input="getRole"
                                ></v-pagination>
                            </div>
				</v-col>
			</v-row>
			<v-btn bottom  color="primary" dark fab fixed right @click="dialog = !dialog">
				<v-icon>mdi-plus</v-icon>
			</v-btn>
		</v-container>
        <v-dialog v-model="dialog" max-width="700px" persistent>
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
                                <v-text-field
                                    v-model="editedItem.name"
                                    label="Role Name*"
                                    :rules="[v => !!v || 'Role Name is required']"
                                    required
                                    filled 
                                    
                                ></v-text-field>
                            </v-flex>
                           
                        </v-layout>
                    </v-container>
                </v-card-text>
				<v-card-text>
               <v-simple-table>
				<template v-slot:default>
				<thead>
					<tr>
					<th class="text-left">
						Page Name
					</th>
					<th class="text-left">
						List
					</th>
					<th class="text-left">
						Create
					</th>
					<th class="text-left">
						Edit
					</th>
					<th class="text-left">
						Delete
					</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{editedItem.rolepages[0].pagename}}</td>
						<td><v-switch v-model="editedItem.rolepages[0].list" color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[0].create"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[0].edit"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[0].delete"  color="primary" inset></v-switch></td>
					</tr>
					<tr>
						<td>{{editedItem.rolepages[1].pagename}}</td>
						<td><v-switch v-model="editedItem.rolepages[1].list"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[1].create"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[1].edit"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[1].delete"  color="primary" inset></v-switch></td>
					</tr>
					<tr>
						<td>{{editedItem.rolepages[2].pagename}}</td>
						<td><v-switch v-model="editedItem.rolepages[2].list"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[2].create"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[2].edit"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[2].delete"  color="primary" inset></v-switch></td>
					</tr>
					<tr>
						<td>{{editedItem.rolepages[3].pagename}}</td>
						<td><v-switch v-model="editedItem.rolepages[3].list"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[3].create"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[3].edit"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[3].delete"  color="primary" inset></v-switch></td>
					</tr>
					<tr>
						<td>{{editedItem.rolepages[4].pagename}}</td>
						<td><v-switch v-model="editedItem.rolepages[4].list"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[4].create"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[4].edit"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[4].delete"  color="primary" inset></v-switch></td>
					</tr>
					<tr>
						<td>{{editedItem.rolepages[5].pagename}}</td>
						<td><v-switch v-model="editedItem.rolepages[5].list"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[5].create"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[5].edit"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[5].delete"  color="primary" inset></v-switch></td>
					</tr>
					<tr>
						<td>{{editedItem.rolepages[6].pagename}}</td>
						<td><v-switch v-model="editedItem.rolepages[6].list"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[6].create"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[6].edit"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[6].delete"  color="primary" inset></v-switch></td>
					</tr>
					<tr>
						<td>{{editedItem.rolepages[7].pagename}}</td>
						<td><v-switch v-model="editedItem.rolepages[7].list"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[7].create"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[7].edit"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[7].delete"  color="primary" inset></v-switch></td>
					</tr>
					<tr>
						<td>{{editedItem.rolepages[8].pagename}}</td>
						<td><v-switch v-model="editedItem.rolepages[8].list"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[8].create"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[8].edit"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[8].delete"  color="primary" inset></v-switch></td>
					</tr>
					<tr>
						<td>{{editedItem.rolepages[9].pagename}}</td>
						<td><v-switch v-model="editedItem.rolepages[9].list"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[9].create"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[9].edit"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[9].delete"  color="primary" inset></v-switch></td>
					</tr>
					<tr>
						<td>{{editedItem.rolepages[10].pagename}}</td>
						<td><v-switch v-model="editedItem.rolepages[10].list"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[10].create"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[10].edit"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[10].delete"  color="primary" inset></v-switch></td>
					</tr>
					<tr>
						<td>{{editedItem.rolepages[11].pagename}}</td>
						<td><v-switch v-model="editedItem.rolepages[11].list"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[11].create"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[11].edit"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[11].delete"  color="primary" inset></v-switch></td>
					</tr>
					<tr>
						<td>{{editedItem.rolepages[12].pagename}}</td>
						<td><v-switch v-model="editedItem.rolepages[12].list"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[12].create"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[12].edit"  color="primary" inset></v-switch></td>
						<td><v-switch v-model="editedItem.rolepages[12].delete"  color="primary" inset></v-switch></td>
					</tr>
					
				</tbody>
				</template>
			</v-simple-table>
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
	components:{ Breadcrumbs, ToolbarLeft, NoDataList,DeleteModal },
	data: () => ({
		search: "",
		absolute: true,
		loading: false,
		singleSelect: false,
		edit: true,
		dialog: false,
		dataList: [],
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
		headers: 
		[
			{ text: "ID", align: "left", value: "id" },
			{ text: "Name", value: "name" },
			{ text: "Action", value: "action" }
		],
		pageHeaders: 
		[
			{ text: "ID", align: "left", value: "id" },
			{ text: "Name", value: "name" },
			{ text: "Action", value: "action" }
		],

		editedIndex: -1,
		editedItem: 
		{
			name: "",
			rolepages:[
				{
					id:null,
					list:false,
					create:false,
					edit:false,
					delete:false,
				},
				{
					id:null,
					list:false,
					create:false,
					edit:false,
					delete:false,
				},
				{
					id:null,
					list:false,
					create:false,
					edit:false,
					delete:false,
				},
				{
					id:null,
					list:false,
					create:false,
					edit:false,
					delete:false,
				},
				{
					id:null,
					list:false,
					create:false,
					edit:false,
					delete:false,
				},
				{
					id:null,
					list:false,
					create:false,
					edit:false,
					delete:false,
				},
				{
					id:null,
					list:false,
					create:false,
					edit:false,
					delete:false,
				},
				{
					id:null,
					list:false,
					create:false,
					edit:false,
					delete:false,
				},
				{
					id:null,
					list:false,
					create:false,
					edit:false,
					delete:false,
				},
				{
					id:null,
					list:false,
					create:false,
					edit:false,
					delete:false,
				},
				{
					id:null,
					list:false,
					create:false,
					edit:false,
					delete:false,
				},
				{
					id:null,
					list:false,
					create:false,
					edit:false,
					delete:false,
				},
				{
					id:null,
					list:false,
					create:false,
					edit:false,
					delete:false,
				},
			],	
		},

		defaultItem: 
		{
			name: "",
			rolepages:[
				{
					id:null,
					list:false,
					create:false,
					edit:false,
					delete:false,
				},
				{
					id:null,
					list:false,
					create:false,
					edit:false,
					delete:false,
				},
				{
					id:null,
					list:false,
					create:false,
					edit:false,
					delete:false,
				},
				{
					id:null,
					list:false,
					create:false,
					edit:false,
					delete:false,
				},
				{
					id:null,
					list:false,
					create:false,
					edit:false,
					delete:false,
				},
				{
					id:null,
					list:false,
					create:false,
					edit:false,
					delete:false,
				},
				{
					id:null,
					list:false,
					create:false,
					edit:false,
					delete:false,
				},
				{
					id:null,
					list:false,
					create:false,
					edit:false,
					delete:false,
				},
				{
					id:null,
					list:false,
					create:false,
					edit:false,
					delete:false,
				},
				{
					id:null,
					list:false,
					create:false,
					edit:false,
					delete:false,
				},
				{
					id:null,
					list:false,
					create:false,
					edit:false,
					delete:false,
				},
				{
					id:null,
					list:false,
					create:false,
					edit:false,
					delete:false,
				},
				{
					id:null,
					list:false,
					create:false,
					edit:false,
					delete:false,
				},
			],	
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
			return this.editedIndex === -1 ? "New Role" : "Edit Role";
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
			this.getRole();
			this.getPage();
		},

		async getPage()
		{
			this.start();
			try 
			{
				let { data } = await axios({
					method: "get",
					url: "/app/page",
				});
				this.assignVlaue(data);
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

		async getRole()
		{
			this.start();
			try 
			{
				let { data } = await axios({
					method: "get",
					url: "/app/role",
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


		editItem(item) 
		{
			this.edit = false;
			this.editedIndex = this.dataList.indexOf(item);
			this.editedItem = Object.assign({}, item);
			this.assignVlaue(item.rolepages);
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
			setTimeout(() => {
				this.editedItem = Object.assign({}, this.defaultItem);
				this.getPage();
				this.editedIndex = -1;
			}, 300);
		},
		
		assignVlaue(data)
		{
				this.editedItem.rolepages[0].pagename = data[0].pagename!=null?data[0].pagename:data[0].pages.pagename;
				this.editedItem.rolepages[1].pagename = data[1].pagename!=null?data[1].pagename:data[1].pages.pagename;
				this.editedItem.rolepages[2].pagename = data[2].pagename!=null?data[2].pagename:data[2].pages.pagename;
				this.editedItem.rolepages[3].pagename = data[3].pagename!=null?data[3].pagename:data[3].pages.pagename;
				this.editedItem.rolepages[4].pagename = data[4].pagename!=null?data[4].pagename:data[4].pages.pagename;
				this.editedItem.rolepages[5].pagename = data[5].pagename!=null?data[5].pagename:data[5].pages.pagename;
				this.editedItem.rolepages[6].pagename = data[6].pagename!=null?data[6].pagename:data[6].pages.pagename;
				this.editedItem.rolepages[7].pagename = data[7].pagename!=null?data[7].pagename:data[7].pages.pagename;
				this.editedItem.rolepages[8].pagename = data[8].pagename!=null?data[8].pagename:data[8].pages.pagename;
				this.editedItem.rolepages[9].pagename = data[9].pagename!=null?data[9].pagename:data[9].pages.pagename;
				this.editedItem.rolepages[10].pagename = data[10].pagename!=null?data[10].pagename:data[10].pages.pagename;
				this.editedItem.rolepages[11].pagename = data[11].pagename!=null?data[11].pagename:data[11].pages.pagename;
				this.editedItem.rolepages[12].pagename = data[12].pagename!=null?data[12].pagename:data[12].pages.pagename;
				this.editedItem.rolepages[0].id = data[0].id
				this.editedItem.rolepages[1].id = data[1].id
				this.editedItem.rolepages[2].id = data[2].id
				this.editedItem.rolepages[3].id = data[3].id
				this.editedItem.rolepages[4].id = data[4].id
				this.editedItem.rolepages[5].id = data[5].id
				this.editedItem.rolepages[6].id = data[6].id
				this.editedItem.rolepages[7].id = data[7].id
				this.editedItem.rolepages[8].id = data[8].id
				this.editedItem.rolepages[9].id = data[9].id
				this.editedItem.rolepages[10].id = data[10].id
				this.editedItem.rolepages[11].id = data[11].id
				this.editedItem.rolepages[12].id = data[12].id

			return this.editedItem;
		},

		async save() 
		{
			if (!this.editedItem.name ) 
			 {
				return true
			 }
			this.loading = true;
			if (this.editedIndex > -1) 
			{
				try 
				{
					let { data } = await axios({
						method: "put",
						url: "/app/role/" + this.editedItem.id,
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
						url: "/app/role",
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
				url: "/app/role/" + this.dataList[this.dataIndex].id
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