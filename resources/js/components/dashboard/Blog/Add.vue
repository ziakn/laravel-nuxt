<template>
	<v-main>
		<v-container fluid>
			<Breadcrumbs/>
            <v-row justify="center">
                	<v-card>
							<ImageModule :toggle="isImage" @send="receiveImage" @cancel="cancel"/>
								<v-card-text>
									<v-container grid-list-md>
										<v-layout wrap>
											<v-col cols="12">
												<v-select
													:rules="[v => !!v || 'Category is required']"
													v-model="editedItem.category_id"
													label="Category"
													:items="dataCategory"
													 outlined 
                                                    item-text="title"
													item-value="id"
												></v-select>
											</v-col>
											<v-col cols="12">
												<v-text-field
													:rules="[v => !!v || 'Title is required']"
													v-model="editedItem.title"
													label="Title"
													 outlined 
                                                    v-on:keyup="titlemonitor"
												></v-text-field>
											</v-col>
											<v-col cols="12">
												 <ckeditor v-model="editedItem.description" :config="editorConfig"></ckeditor>
    
											</v-col>
                                            <v-col cols="12">
												<v-text-field 
                                                    v-model="editedItem.meta_title" 
                                                    label="Meta Title"
                                                     outlined 

                                                ></v-text-field>
											</v-col>
                                            <v-col cols="12">
												<v-text-field 
                                                    v-model="editedItem.meta_tag" 
                                                    label="Meta Tag"
                                                     outlined 
                                                ></v-text-field>
											</v-col>
                                            <v-col cols="12">
												<v-textarea 
                                                    v-model="editedItem.meta_description" 
                                                    label="Meta Description"
                                                     outlined 
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
            </v-row>
        </v-container>
    </v-main>
</template>
<script>
import ImageModule from "./../../common/ImageModule"
import Breadcrumbs from "./../../common/Breadcrumbs"
export default {
	components: {
        ImageModule,
        Breadcrumbs
	},
	data: () => ({
		isImage:false,
		dataCategory: [],
		editedItem: 
		{
			title: "",
            description: "",
            viewed:"",
            liked:"",
			image:"",
			status: 1,
			meta_title: "",
            meta_tag: "",
            meta_description: "",
			category_id: "",

		},
		editorConfig: {
                    toolbar: [ [ 'Bold' ] ]
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

		async initialize()
		{

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
		async save() 
		{
			
				try 
				{
					
					let { data } = await axios({
						method: "post",
						url: "/app/blog",
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
			
		},

	
	}
};
</script>