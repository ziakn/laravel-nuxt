<template>
	<v-main>
		<v-container fluid>
			<v-overlay :value="showFullLoading" :absolute="absolute">
				<v-progress-circular indeterminate size="64"></v-progress-circular>
			</v-overlay>
            <ToolbarLeft>
                <v-spacer></v-spacer>
            </ToolbarLeft>
			<Breadcrumbs/>
			<v-form ref="form" v-model="valid"> 
			<v-row justify="center">    
                <v-col cols="12" lg="10">
					<v-row>
						<v-col cols=12>
							<v-card flat >
								<v-card-title> 
									<v-icon large left color="primary" >
										assignment
									</v-icon>
									<span class="title font-weight-light" >Genral</span>
								</v-card-title>
								<v-card-text>
                                    <v-row>
                                       <v-tabs >
											<v-tab >
												English
											</v-tab>
											<v-tab >
												Arabic
											</v-tab>
											<v-tab-item >
												<v-card flat>
													<v-card-text>
														<v-row >
															<v-col cols="12"  >
																<v-text-field v-model="editedItem.title_en" label="Title En*" :rules="titleRules"  filled  ></v-text-field>
															</v-col>
															<v-col  cols="12">
																<v-textarea v-model="editedItem.description_en" label="Description En"   filled></v-textarea>
															</v-col>
															<v-col  cols="12">
																<v-text-field v-model="editedItem.feature_title_en" label="Feature Title En"  filled></v-text-field>
															</v-col>
                                                            <v-col  cols="12">
																<v-text-field v-model="editedItem.video_title_en" label="Video Title En"  filled></v-text-field>
															</v-col>
														</v-row>
													</v-card-text>
												</v-card>
											</v-tab-item>
											<v-tab-item >
												<v-card flat >
													<v-card-text>
														<v-row >
															<v-col cols="12"  >
																<v-text-field v-model="editedItem.title_ar" label="Title Ar*" :rules="titleRules" filled  ></v-text-field>
															</v-col>
															<v-col  cols="12">
																<v-textarea v-model="editedItem.description_ar" label="Description Ar"   filled></v-textarea>
															</v-col>
															<v-col  cols="12">
																<v-text-field v-model="editedItem.feature_title_ar" label="Feature Title Ar"  filled></v-text-field>
															</v-col>
                                                            <v-col  cols="12">
																<v-text-field v-model="editedItem.video_title_ar" label="Video Title Ar"  filled></v-text-field>
															</v-col>
														</v-row>
													</v-card-text>
												</v-card>
											</v-tab-item>
											</v-tabs>
                                                <v-col  cols="12">
													<v-text-field type="url" v-model="editedItem.video_url" label="Video Url"  filled></v-text-field>
												</v-col>
                                    </v-row>
										
								</v-card-text>
							</v-card>
						</v-col>
						<v-col cols="12">
							<v-card flat>
								<v-card-title> 
									<v-icon large left color="primary" >
										attach_file
									</v-icon>
									<span class="title font-weight-light" >Media</span>
								</v-card-title>
								<v-card-text> 
                                <v-row justify="center">
									<v-col cols="6">
										<v-card
											class="mx-auto"
											width="180"
											outlined
											align="center"
											justify="center"
										>
										<v-img
										:src="editedItem.preview_image?editedItem.preview_image:'/images/plus.png'"
										aspect-ratio="1"
										@click="isImage=!isImage"
										>
										</v-img>
										<v-card-subtitle v-if="!editedItem.preview_image">Preview Images</v-card-subtitle>
										<v-card-text v-else class="my-2">
											<v-btn x-small color="primary" @click="isImage=!isImage">
												Change
											</v-btn>
											<v-btn x-small color="primary" @click="editedItem.preview_image=''">
												Remove
											</v-btn>
										</v-card-text>
										
										</v-card>
									</v-col>
                                    <v-col cols="6">
										<v-card
											class="mx-auto"
											width="180"
											outlined
											align="center"
											justify="center"
										>
										<v-img
										:src="editedItem.feature_image?editedItem.feature_image:'/images/plus.png'"
										aspect-ratio="1"
										@click="isFeature=!isFeature"
										>
										</v-img>
										<v-card-subtitle v-if="!editedItem.feature_image">Feature Image</v-card-subtitle>
										<v-card-text v-else class="my-2">
											<v-btn x-small color="primary" @click="isFeature=!isFeature">
												Change
											</v-btn>
											<v-btn x-small color="primary" @click="editedItem.feature_image=''">
												Remove
											</v-btn>
										</v-card-text>
										
										</v-card>
									</v-col>
                                    </v-row>
									<ImageModule :toggle="isImage" @send="receiveImage" @cancel="cancelImage"/>
									<ImageModule :toggle="isFeature" @send="receiveFeature" @cancel="cancelFeature"/>
								</v-card-text>
								<v-card-text>
									  <v-card-title>Gallery Image</v-card-title>
									<v-row>
									<ImageModule :toggle="isBanner" @send="receiveBanner" @cancel="cancelBanner"/>
									<v-col
										class="d-flex child-flex"
										cols="4"
										lg="2"
										>
											<v-card  >
												<v-img
												src="/images/plus.png"
												aspect-ratio="1"
												@click="isBanner=!isBanner"
												>
												</v-img>
												<v-card-subtitle align="center">
													Add image
												</v-card-subtitle>
											</v-card>
										</v-col>
										<v-col
										v-for="(image , index) in editedItem.banner"
										:key="index"
										class="d-flex child-flex"
										cols="4"
										lg="2"
										>
											<v-card flat >
												<v-img
												:src="image"
												aspect-ratio="1"
												class="grey lighten-2"
												>
												<v-btn color="error" @click="removeBanner(index)">x</v-btn>
												<template v-slot:placeholder>
													<v-row
													class="fill-height ma-0"
													align="center"
													justify="center"
													>
													<v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
													</v-row>
												</template>
												</v-img>
												
											</v-card>
										</v-col>
									</v-row>
								</v-card-text>
							</v-card>
							
						</v-col>
					</v-row>
                </v-col>

			</v-row>
				</v-form>
			<v-btn v-show="valid" bottom color="green  darken-3" dark fab fixed right @click="save">
				<v-icon>check</v-icon>
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
import Breadcrumbs from "./../../common/Breadcrumbs"
import ToolbarLeft from "./../../common/ToolbarLeft"
import ImageModule from "./../../common/ImageModule"
export default {
	components:
	{
        ToolbarLeft,
        ToolbarLeft,
		Breadcrumbs,
		ImageModule
	},
	data: () => ({
		isImage:false,
		valid:false,
		absolute:false,
		loading: false,
		isBanner: false,
		isFeature: false,
		editedItem: 
			{
			title_en:'',
			title_ar:'',
			description_en: '',
			description_ar: '',
			video_title_en:'',
			video_title_ar:'',
			video_url:'',
			feature_title_en:'',
			feature_title_ar:'',
			feature_image:'',
			preview_image:'',
			status: 1,
			banner:[],
            },
		
		titleRules: [
			v => !!v || 'This Field is required',
			v => v.length <= 35 || 'Max 35 characters'
			],
		descRules: [
			v => !!v || 'This Field is required',
			v => v.length <= 60 || 'Max 60 characters'
			],
		dataStatus: [
			{ name: "Active", value: 1 },
			{ name: "Disable", value: 0 }
		]
	}),
	computed: {
		
	},

	created() 
	{
	},

	methods: {
		receiveImage(item)
		{
			this.isImage=!this.isImage;
			this.editedItem.preview_image=item.src
		},
		cancelImage()
		{
			this.isImage = !this.isImage;
		},
		receiveFeature(item)
		{
			this.isFeature=!this.isFeature;
			this.editedItem.feature_image=item.src
		},
		cancelFeature()
		{
			this.isFeature = !this.isFeature;
		},
		cancelBanner()
		{
			this.isBanner = !this.isBanner;
		},
		 receiveBanner(item)
		{
			this.isBanner=!this.isBanner;
			this.editedItem.banner.push(item.src)
		},
		removeBanner(index)
		{
			this.editedItem.banner.splice(index, 1);

		},
	
		
		

		

	

		

		back()
		{
			this.$router.push('/services/serviceslist');
		},

		close() 
		{
			this.dialog = false;
			this.loading = false;
			this.back();
		},

		async save() 
		{
			this.loading = true;
			
				try 
				{
					console.log(this.editedItem)
					let { data } = await axios({
						method: "post",
						url: "/app/services",
						data: this.editedItem
					});
					if (data.status) 
					{
						this.snacks("Successfully Added", "green");
						this.close();
					} 
					else 
					{
						this.snacks(data.data, "red");
						this.loading = false;
					}
				} 
				catch (e) 
				{
					this.snacks("Failed", "red");
					this.loading = false;
				}
		}
	}
};
</script>