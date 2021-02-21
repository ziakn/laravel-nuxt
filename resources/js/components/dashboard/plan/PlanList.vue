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
					 outlined 
                                        dense
					dense
				></v-text-field>
			</ToolbarLeft>
			<Breadcrumbs/>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="12">
					<v-data-table color="white" :headers="headers" :items="dataList" :search="search"  class="elevation-12" :items-per-page="20" :hide-default-footer="true">
							<template v-slot:item.action="{ item }">
								 <v-icon color="black"  @click="viewItem(item)">remove_red_eye</v-icon>
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
                                @input="getPlan"
                                ></v-pagination>
                            </div>
				</v-col>
			</v-row>
			<v-btn bottom   color="primary" dark fab fixed right @click="dialog = !dialog">
				<v-icon>mdi-plus</v-icon>
			</v-btn>
		</v-container>
        <v-dialog v-model="dialog" max-width="800px" persistent>
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
                            <v-flex xs12 sm12 md6 >
                                <v-text-field
                                    v-model="editedItem.title"
                                    label="Title"
                                    :rules="[v => !!v || 'Title is required']"
                                    required
                                     outlined 
                                        dense
                                    dense
                                ></v-text-field>
                            </v-flex>
							  <v-flex xs12 sm12 md6>
                                <v-text-field
                                    v-model="editedItem.title_ar"
                                    label="Title Arabic"
                                    :rules="[v => !!v || 'Title Arabic is required']"
                                    required
                                     outlined 
                                        dense
                                    dense
                                ></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm12 md12>
                                <v-text-field
                                    v-model="editedItem.price"
                                    label="Price"
									type="number"
									:rules="[v => !!v || 'Price is required']"
                                     outlined 
                                        dense
                                    dense
                                ></v-text-field>
                            </v-flex>
                              <v-flex xs12 sm12 md6>
                                <v-text-field
                                    v-model="editedItem.duration"
                                    label="Duration"
									:rules="[v => !!v || 'Duration is required']"
                                     outlined 
                                        dense
                                    dense
                                ></v-text-field>
                            </v-flex>
                              <v-flex xs12 sm12 md6>
                                <v-text-field
                                    v-model="editedItem.duration_ar"
                                    label="Duration Arabic"
									:rules="[v => !!v || 'Duration Arabic is required']"
                                     outlined 
                                        dense
                                    dense
                                ></v-text-field>
                            </v-flex>
                      
                        </v-layout>
                    </v-container>
                </v-card-text>
            <v-card>
                	<v-card color="secondary" dark :tile="true" flat   >
					<v-card-title class="text-center justify-center py-1">
                         <h6 class="headline">Attributes</h6>
                    </v-card-title>
                    </v-card>
                    <v-card-text>
                            <v-container grid-list-md>
                        <v-layout wrap>
                     <v-tabs centered grow color="primary">
                    <v-tab :href="`#tab-1`">Plans Page</v-tab>
                    <v-tab :href="`#tab-2`">Home Page</v-tab>
                    <v-tab-item :value="'tab-1'">
                        <v-card  flat >
                        <v-card-text>
                        <v-data-table dir="rtl" id="groups" v-model="planPageAttribute"  item-key="id" color="white" :headers="attributeheaders" show-select :single-select="singleSelect" :items="dataAttribute" :items-per-page="20" :hide-default-footer="true">
					    </v-data-table>
                        </v-card-text>
                        </v-card>
                    </v-tab-item>
                    <v-tab-item :value="'tab-2'">
                       <v-card  flat >
                        <v-card-text>
                            <v-data-table dir="rtl"  v-model="homePageAttribute"  item-key="id" color="white" :headers="attributeheaders" show-select :single-select="singleSelect2" :items="dataAttribute" :items-per-page="20" :hide-default-footer="true">
					    </v-data-table>
                        </v-card-text>
                        </v-card>
                    </v-tab-item>
                    </v-tabs>
                        </v-layout>
                            </v-container>
                    </v-card-text>
         		    </v-card >

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
			<PlanView :trigger="isView" :planData="editedItem"></PlanView>
	</v-main>
</template>

<script>
import Breadcrumbs from "./../../common/Breadcrumbs"
import ToolbarLeft from "./../../common/ToolbarLeft"
import NoDataList from "./../../common/NoDataList"
import DeleteModal from "./../../common/DeleteModal";
import PlanView from "./../../common/PlanView";
export default {
	components:{
		Breadcrumbs,
		ToolbarLeft,
		NoDataList,
		DeleteModal,
		PlanView
	},
	data: () => ({
		search: "",
		absolute: true,
        loading: false,
        singleSelect: false,
		singleSelect2: false,
		edit: true,
		dialog: false,
		dataList: [],
		dataIndex: null,
		deleteTitle: "",
		deleteBody: "",
		isDelete: false,
        itemsPerPage:1,
        pageCount:2,
        planPageAttribute:[],
        dataAttribute:[],
		homePageAttribute:[],
		isView:false,
	    filters:
        {
			page: 1,
			show: 20,
        },
		attributeheaders:[
            
			{ text: "Name", align: "left", value: "name"},
			{ text: "ID", align: "left", value: "id", },
        ],
		headers: [
			{ text: "ID", align: "left", value: "id" },
		    { text: "Title", value: "title" },
			{ text: "Price", value: "price" },
			{ text: "Duration", value: "duration" },
			{ text: "Action", value: "action" }
		],
		editedIndex: -1,
        editedItem: 
        {
			title: "",
			title_ar: "",
			price: 0,
			duration: "",
            duration_ar: "",
            planPageAttribute:[],
            homePageAttribute:[],
		},
        defaultItem: 
        {
			title: "",
			title_ar: "",
			price: 0,
			duration: "",
            duration_ar: "",
            planPageAttribute:[],
            homePageAttribute:[],
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
			return this.editedIndex === -1 ? "New Plan" : "Edit Plan";
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
            this.getPlan();
            this.getAttributes();
		},

		async getPlan()
		{
			this.start();
			try 
			{
				let { data } = await axios({
					method: "get",
					url: "/app/plan",
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
        

        async getAttributes()
        {
            try 
			{
				let { data } = await axios({
					method: "get",
					url: "/app/getattributes",
				});
                this.dataAttribute = data;
               
				
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
					url: "/app/plan/"+i.id+"/edit",
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
            // console.log(item)
            for(let o of item.planattribute)
                    {
                        this.planPageAttribute.push(o.attribute)
                    }

            for(let o of item.homepageattribute)
                    {
                        this.homePageAttribute.push(o.attribute)
                    }

			this.dialog = true;
		},
		
		deleteItem(item) 
		{
			this.dataIndex = this.dataList.indexOf(item);
			this.deleteTitle = "Are you sure you want to delete this item?";
			this.isDelete = !this.isDelete;
		},
		viewItem(item) 
		{
			this.editedItem = Object.assign({}, item);
			this.isView=!this.isView;
		},
		
		close() 
		{
			this.dialog = false;
            this.loading = false;
            this.planPageAttribute=[];
            this.homePageAttribute=[];
			setTimeout(() => {
				this.editedItem = Object.assign({}, this.defaultItem);
				this.editedIndex = -1;
			}, 300);
		},
		
		async save() 
		{
			if (!this.editedItem.title ||  !this.editedItem.title_ar) 
			{
			    return
            }
            this.editedItem.planPageAttribute = [...this.planPageAttribute]
			this.editedItem.homePageAttribute = [...this.homePageAttribute]
			this.loading = true;
			if (this.editedIndex > -1) 
			{
				try 
				{
                    
					let { data } = await axios({
						method: "put",
						url: "/app/plan/" + this.editedItem.id,
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
						url: "/app/plan",
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
				url: "/app/plan/" + this.dataList[this.dataIndex].id
				});
				if (data.status) {
					this.snacks('Successfully Done','green')
					this.dataList.splice(this.dataIndex, 1);
					this.close();				
				}
				else
				{
					this.snacks(data.data,'red')
					this.loading = false;
				}
			} catch (e) {
				this.snacks('Operation Failed','red')

			}
		}
	}
};
</script>