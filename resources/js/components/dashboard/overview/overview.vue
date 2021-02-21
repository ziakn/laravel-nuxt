<template>
	<v-main>
		<v-container fluid>
			<v-overlay :value="showFullLoading" :absolute="absolute">
				<v-progress-circular indeterminate size="64"></v-progress-circular>
			</v-overlay>
			<v-row justify="center">
				<v-col cols="12" lg="3" md="3">
                    <DashboardCard :icon="'assignment'" :title="'Total Users '" :data="dashboard.totaluser" :action="''"  :color="'red accent-2'"></DashboardCard>
                </v-col>
				<v-col cols="12" lg="3" md="3">
                    <DashboardCard :icon="'assignment'" :title="'Total Role'" :data="dashboard.totalrole" :action="''" :color="'red accent-1'" ></DashboardCard>
                </v-col>
				<v-col cols="12" lg="3" md="3">
                    <DashboardCard :icon="'assignment'" :title="'Total Services '" :data="dashboard.totalservice" :action="''"  :color="'pink accent-2'"></DashboardCard>
                </v-col>
				<v-col cols="12" lg="3" md="3">
                    <DashboardCard :icon="'assignment'" :title="'Total Project'" :data="dashboard.totalproject" :action="''"  :color="'pink accent-1'"></DashboardCard>
                </v-col>
 				<v-col cols="12" lg="6">
					<p class="title">
						Recent Users
					</p>
                    <v-data-table :items-per-page="itemperpage" :headers="headers" :items="dataUser" :search="search" class="elevation-4">
						<template v-slot:no-data>
							<NoDataList :loading="loading" @initialize="initialize"></NoDataList>
						</template>
					</v-data-table>
                </v-col> 
				  <v-col cols="12" lg="6">
					<p class="title">
						Your Activity
					</p>
                    <v-data-table :items-per-page="itemperpage" :headers="sessionHeaders" :items="dataSession" :search="search" class="elevation-4">
						<template v-slot:no-data>
							<NoDataList :loading="loading" @initialize="initialize"></NoDataList>
						</template>
					</v-data-table>
                </v-col> 
               
         
			</v-row>
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
import NoDataList from './../../common/NoDataList'
import DashboardCard from './../../common/DashboardCard'

export default {
	data: () => ({
		itemperpage:5,
		dashboard:{},
		contact:null,
		search:'',
		image:'/no_image.png',
		isCustomer:false,
		
		setting:{},
		valid:false,
		absolute:false,
		
		
		dataSession:[],
		dataUser:[],
		loading: false,

		dataUser: [],
	
		headers: [
			{ text: "ID", value: "id" },
			{ text: "Name", value: "name" },
			{ text: "Email", value: "email" },
			{ text: "Mobile", value: "mobile" },
			
		],

	sessionHeaders: [
			{ text: "ID", value: "id" },
			{ text: "IP", value: "ip_address" },
			// { text: "Device", value: "user_agent" },
			// { text: "Mobile", value: "mobile" },
			
		],
	

	}),

	props: {
		source: String
    },
    components:{
		DashboardCard,
		NoDataList
    },
	computed: {

		
	},
	watch: {},
	created() {

	this.initialize();
	},
	methods: {
		handleGoToMenu(d) {
		return d;
		},
		async initialize() {
			this.start()
			this.loading=true;
            this.setting=this.$store.state.setting
            try {
				let { data } = await axios({
					method: "get",
					url: "/app/dashboard"
				});
				this.dashboard = data;
				
			} catch (e) {
				this.fail();
				this.loading=false;
			}
            try {
				let { data } = await axios({
					method: "get",
					url: "/app/user"
				});
				this.dataUser = data;
			} catch (e) {
				this.loading=false;
				this.fail();
			}
			try {
				let { data } = await axios({
					method: "get",
					url: "/app/session"
				});
				this.dataSession = data;
			} catch (e) {
				this.loading=false;
				this.fail();
			}
			this.loading=false;
			this.finish();

		},
	
		close() {
			this.$refs.form.reset();
			this.cart = [];
			this.loading = false;
		},
		remove(item)
		{
			var index = this.cart.indexOf(item);
			this.cart.splice(index, 1);
		},
	},
	mounted()
	{

	}
};
</script>