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
					dense
				></v-text-field>
            </ToolbarLeft>
			<Breadcrumbs/>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="12">
					<v-data-table  :headers="headers" :items="dataList" :search="search" class="elevation-12" :items-per-page="20" :hide-default-footer="true">>
						<template v-slot:item.image="{ item }">
							<v-img
								:src="item.image?item.image:'/no_image.png'"
								lazy-src="no_image.png"
								aspect-ratio="1"
								class="grey lighten-2"
								width="80"
								height="80"
							></v-img>
						</template>
						<template v-slot:item.about="{ item }">
							{{item.about && item.about.length>70?item.about.slice(0,68)+'...':item.about}}
						</template>
						  <template v-slot:item.status="{ item }">
                                    <v-switch v-model="item.status" @change="changeStatus(item)" color="primary" inset></v-switch>
                                </template>
						<template v-slot:item.action="{ item }">
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
                                @input="getTestimonial"
                        ></v-pagination>
                    </div>
				</v-col>
			</v-row>
			<DeleteModal :trigger="isDelete" :title="deleteTitle" :body="deleteBody" @request="remove"></DeleteModal>
			<v-btn bottom color="primary" dark fab fixed right @click="dialog = !dialog">
				<v-icon>add</v-icon>
			</v-btn>
            <v-dialog v-model="dialog" max-width="700px" persistent>
							<v-card>
							<ImageModule :toggle="isImage" @send="receiveImage" @cancel="cancel"/>
								<v-card color="secondary" dark :tile="true" flat >
									<v-card-title
									class="headline"
									v-text="formTitle"
									></v-card-title>
								</v-card >

								<v-card-text>
									<v-container grid-list-md>
										<v-layout wrap>
											<v-col cols="12">
												<v-text-field
													:rules="[v => !!v || 'Name is required']"
													v-model="editedItem.name"
													label="Name*"
													 outlined 
                                        dense
												></v-text-field>
											</v-col>
												<v-col cols="12">
												<v-text-field
													:rules="[v => !!v || 'Arabic Name is required']"
													v-model="editedItem.name_ar"
													label="Name Arabic*"
													 outlined 
                                        dense
												></v-text-field>
											</v-col>
											<v-col cols="12">
												<v-textarea 
                                                    v-model="editedItem.description" 
                                                    label="Tetimonial"
                                                     outlined 
                                        dense
                                                ></v-textarea>
											</v-col>
											<v-col cols="12">
												<v-textarea 
                                                    v-model="editedItem.description_ar" 
                                                    label="Tetimonial Arabic"
                                                     outlined 
                                        dense
                                                ></v-textarea>
											</v-col>
											<v-col cols="12">
												<v-card
													class="mx-auto"
													width="180"
													 outlined 
                                        dense
													align="center"
													justify="center"
												>
												<v-img
												:src="editedItem.image?editedItem.image:'/images/plus.png'"
												aspect-ratio="1"
												@click="isImage=!isImage"
												>
												</v-img>
												<v-card-subtitle v-if="!editedItem.image">Add image</v-card-subtitle>
												<v-card-text v-else class="my-2">
													<v-btn x-small color="primary" @click="isImage=!isImage">
														Change
													</v-btn>
													<v-btn x-small color="primary" @click="editedItem.image=''">
														Remove
													</v-btn>
												</v-card-text>
												</v-card>
											</v-col>
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
import ImageModule from "./../../common/ImageModule"
import Breadcrumbs from "./../../common/Breadcrumbs"
import ToolbarLeft from "./../../common/ToolbarLeft"
export default {
	components: {
		DeleteModal,
		NoDataList,
        ImageModule,
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

			{ text: "Image", value: "image" },
			{ text: "Name", value: "name" },
			{ text: "Testimonial", value: "description" },
			{ text: "Status", value: "status" },
			{ text: "Action", value: "action" }
		],
		editedIndex: -1,
		editedItem: 
		{
			name: "",
			name_ar: "",
			description:"",
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
			name: "",
			name_ar: "",
			description:"",
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
		formTitle() 
		{
			return this.editedIndex === -1 ? "New Testimonial" : "Edit Testimonial";
		}
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
					url: "/app/testimonial/"+i.id+"/edit",
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
		cancel()
		{
			this.isImage=!this.isImage;

		},
		receiveImage(item)
		{
			this.isImage=!this.isImage;
			this.editedItem.image=item.src
		},

		async initialize() 
		{
			this.getTestimonial();        
		},

		async getTestimonial()
		{
			this.start();
			try 
			{
				let { data } = await axios({
					method: "get",
					url: "/app/testimonial",
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
				this.editedIndex = -1;
			}, 300);
		},
		async save() 
		{
			 if (!this.editedItem.name || !this.editedItem.name_ar ) 
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
						url: "/app/testimonial/" + this.editedItem.id,
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
						url: "/app/testimonial",
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
					url: "/app/testimonial/" + this.dataList[this.dataIndex].id
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