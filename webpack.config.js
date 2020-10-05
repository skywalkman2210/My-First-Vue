const path = require('path');

module.exports = {
    resolve: {
      alias: {
        'vue$': '/node_modules/vue/dist/vue.esm.js' // 'vue/dist/vue.common.js' for webpack 1
      }
    }
  }