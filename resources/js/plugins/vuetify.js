import Vue from 'vue'
import Vuetify from 'vuetify'
// To add vuetify css file
import colors from 'vuetify/lib/util/colors'
import 'vuetify/dist/vuetify.min.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css' // Ensure you are using css-loader
import '@mdi/font/css/materialdesignicons.css' // Ensure you are using css-loader

Vue.use(Vuetify)

const opts = {
    icons: {
        iconfont: 'mdi' || 'md'
      },
      theme: {
        themes: {
          light: {
            primary: colors.red.darken1, // #E53935
            secondary: colors.red.lighten1, // #FFCDD2
            accent: '#241d3b', // #3F51B5
            error: '#FF5252',
            info: '#2196F3',
            success: '#4CAF50',
            warning: '#FFC107',
          },
        },
      },
}



export default new Vuetify(opts)