<template>
	<v-main>
		<v-container fluid>
			<v-overlay :value="showFullLoading" :absolute="absolute">
				<v-progress-circular indeterminate size="64"></v-progress-circular>
			</v-overlay>
            <ToolbarLeft>
                <v-spacer></v-spacer>
                <v-text-field
                    v-model="filters.search"
                    append-icon="search"
                    label="Search"
                    hide-details
                    outlined
                    @change="getServices"

                ></v-text-field>        
            </ToolbarLeft>
			<Breadcrumbs/>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="12">
                    <v-card flat>
                        <v-card-text>
                            <v-data-table  :headers="headers" :items="dataList" :search="search"
                                hide-default-footer :items-per-page="15"
                            >
                                <template v-slot:[`item.preview_image`]="{ item }">
									<v-img
										:src="item.preview_image?item.preview_image:'/no_image.png'"
										lazy-src="no_image.png"
										aspect-ratio="1"
										class="grey lighten-2"
										width="80"
										height="80"
									></v-img>
                                </template>
								<template v-slot:[`item.title_en`]="{ item }">
                                    {{item.title_en && item.title_en.length>70?item.title_en.slice(0,68)+'...':item.title_en}}
                                </template>
                                <template v-slot:[`item.description_en`]="{ item }">
                                    {{item.description_en && item.description_en.length>70?item.description_en.slice(0,68)+'...':item.description_en}}
                                </template>
                                <template v-slot:[`item.status`]="{ item }">
                                    <v-switch v-model="item.status" @change="changeStatus(item)" color="primary" inset></v-switch>
                                </template>
                                <template v-slot:[`item.action`]="{ item }">
                                    <v-icon color="blue" @click="editItem(item)">edit</v-icon>
									<v-icon color="red"  @click="deleteItem(item)">delete</v-icon>
                                </template>
								<template v-slot:no-data>
									<NoDataList :loading="loading" @initialize="initialize"></NoDataList>
                                </template>
                            </v-data-table>
                            <div class="text-center">
                                <v-pagination
                                v-model="filters.page"
                                :length="pageCount"
                                @input="getServices"
                                ></v-pagination>
                            </div>
                        </v-card-text>
                    </v-card>
				</v-col>
			</v-row>
			<DeleteModal :trigger="isDelete" :title="deleteTitle" :body="deleteBody" @request="remove"></DeleteModal>
			<v-btn bottom color="primary" dark fab fixed right @click="save">
				<v-icon>add</v-icon>
			</v-btn>
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
			<v-btn color="white" text @click="snackbar = false">Close</v-btn>
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
        Breadcrumbs,
        ToolbarLeft
	},
	data: () => ({
		setting:{},
        itemsPerPage:1,
        pageCount:2,
		search: "",
		absolute: true,
		loading: false,
		edit: true,
		dialog: false,
        dataList: [],
        dataCategory:[],
		dataBranch:[],
		branch:[],
		
        filters:
        {
            show:20,
			page:1,
		},
		
		headers: [
			{ text: "ID", align: "left", value: "id" },
			{ text: "Image", value: "preview_image" },
			{ text: "Title", value: "title_en" },
			{ text: "Description", value: "description_en" },
			{ text: "Status", value: "status" },
			{ text: "Action", value: "action" }
		],
		editedIndex: -1,
		branchIndex: -1,
		
		dataIndex: null,
		deleteTitle: "",
		deleteBody: "",
		isDelete:false,
		
		dataStatus: [
			{ name: "Active", value: 1 },
			{ name: "Disable", value: 0 }
		],
		
	}),

	props: {
		source: String
	},

	computed: {
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
			try {
				let { data } = await axios({
					method: "get",
					url: "/app/services/"+i.id+"/edit",
					params:{
						status: i.status
					},

				});
				if (data.status) {
					this.snacks("Successfully Changed", "green");
					this.close();
				} else {
					this.snacks("Failed", "red");
					this.loading = false;
				}
			} catch (e) {
				this.snacks("Error, Server issue", "red");
				this.loading = false;
			}


		},
		async initialize() 
		{
			this.loading=true;
			this.filters.page=1
			this.getServices();
		},
		
        async getServices()
        {
            this.start();
			try 
			{
				let { data } = await axios({
					method: "get",
					url: "/app/services",
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
                this.loading=false;
			}
        },
		editItem(item) 
			{
				this.$router.push('/services/servicesedit/'+item.id);
			},

		save(item) 
			{
				this.$router.push('/services/servicesadd');
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
			},

		async remove() 
		{
			this.loading=true;
			try 
			{
				let { data } = await axios({
					method: "delete",
					url: "/app/services/" + this.dataList[this.dataIndex].id
				});

				if (data.status) 
				{
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