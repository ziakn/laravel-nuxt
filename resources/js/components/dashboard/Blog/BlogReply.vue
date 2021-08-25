<template>
	<v-main>
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
				></v-text-field>
            </ToolbarLeft>
			<Breadcrumbs/>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="12">
					<v-data-table  :headers="headers" :items="dataList" :search="search" class="elevation-12" :items-per-page="20" :hide-default-footer="true">>
						<template v-slot:[`item.image`]="{ item }">
							<v-img
								:src="item.image?item.image:'/no_image.png'"
								lazy-src="no_image.png"
								aspect-ratio="1"
								class="grey lighten-2"
								width="80"
								height="80"
							></v-img>
						</template>
						  <template v-slot:[`item.status`]="{ item }">
                                    <v-switch v-model="item.status" @change="changeStatus(item)" color="primary" inset></v-switch>
                                </template>
						<template v-slot:[`item.action`]="{ item }">
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
                                @input="getBlogReply"
                        ></v-pagination>
                    </div>
				</v-col>
			</v-row>
			<DeleteModal :trigger="isDelete" :title="deleteTitle" :body="deleteBody" @request="remove"></DeleteModal>
		</v-container>
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
	</v-main>
</template>

<script>
import DeleteModal from "./../../common/DeleteModal";
import NoDataList from "./../../common/NoDataList"
import Breadcrumbs from "./../../common/Breadcrumbs"
import ToolbarLeft from "./../../common/ToolbarLeft"
export default {
	components: {
		DeleteModal,
		NoDataList,
        ToolbarLeft,
        Breadcrumbs
	},
	data: () => ({
		isImage:false,
		search: "",
		itemsPerPage:1,
        pageCount:2,
		absolute: true,
		loading: false,
		edit: true,
		dialog: false,
        dataList: [],
		headers: 
		[

			{ text: "Name", value: "name" },
			{ text: "Comment", value: "comment" },
			{ text: "Email", value: "email" },
			{ text: "Status", value: "status" },
			{ text: "Website", value: "website" },
			{ text: "Action", value: "action" }
		],
		editedIndex: -1,
		editedItem: 
		{
			title_en: "",
            title_ar: "",
            description_en:"",
            description_ar:"",
			image:"",
			status: 1,
		},
		dataIndex: null,
		deleteTitle: "",
		deleteBody: "",
		isDelete:false,
		defaultItem: 
		{
			title_en: "",
            title_ar: "",
            description_en:"",
            description_ar:"",
			image:"",
			status: 1,
		},
		dataStatus: 
		[
			{ name: "Active", value: 1 },
			{ name: "Disable", value: 0 }
		],

		filters:
        {
            show:20,
			page:1,
        },

		
	}),

	props: 
	{
		source: String
	},

	computed: 
	{
		
	},
	
	watch: {},

	created() 
	{
		this.initialize();
	},
	
	methods: {
		async changeStatus(i)
		{
			this.loading = true;
			try 
			{
				let { data } = await axios({
					method: "get",
					url: "/app/blogreply/"+i.id+"/edit",
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
		

		async initialize() 
		{
			this.getBlogReply();        
		},

		async getBlogReply()
		{
			this.start();
			try 
			{
				let { data } = await axios({
					method: "get",
					url: "/app/blogreply",
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
				this.editedIndex = -1;
			}, 300);
		},
		async save() 
		{
			 if (!this.editedItem.title_en || !this.editedItem.title_ar ) 
			 {
				return
			 }
			this.loading = true;
			if (this.editedIndex > -1) 
			{
				try 
				{
					let { data } = await axios({
						method: "put",
						url: "/app/blogreply/" + this.editedItem.id,
						data: this.editedItem
					});
					if (data.status) 
					{
						this.snacks("Successfully Added", "green");
						Object.assign(this.dataList[this.editedIndex], this.editedItem);
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
						url: "/app/blogreply",
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
				} catch (e) {
					this.snacks("Failed", "red");
					this.loading = false;
				}
			}
		},

		async remove() 
		{
			this.loading=true;
			try {
				let { data } = await axios({
					method: "delete",
					url: "/app/blogreply/" + this.dataList[this.dataIndex].id
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
				this.loading = false;
			}
		}
	}
};
</script>