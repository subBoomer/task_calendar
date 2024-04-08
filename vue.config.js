const path = require('path')

module.exports = {
    chainWebpack: (config) => {
      config.resolve.alias.set('@', resolve('resources'))
    },
  }
  
  function resolve(dir) {
    return path.join(__dirname, '..', dir)
  }