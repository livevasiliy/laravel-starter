export default {
  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    title: 'frontend',
    htmlAttrs: {
      lang: 'en',
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' },
    ],
    link: [{ rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }],
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    // https://go.nuxtjs.dev/eslint
    '@nuxtjs/eslint-module',
    // https://go.nuxtjs.dev/stylelint
    '@nuxtjs/stylelint-module',
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    // https://go.nuxtjs.dev/axios
    '@nuxtjs/axios',
    'nuxt-socket-io',
    '@nuxtjs/auth',
    ['@nuxtjs/laravel-echo', {
      'host': process.env.SOCKET_URL || 'localhost:6001',
      'broadcaster': 'socket.io',
      'authModule': false
    }]
  ],

  // Axios module configuration: https://go.nuxtjs.dev/config-axios
  axios: {},

  // Socket.io module configuration
  io: {
    sockets: [
      {
        name: '/',
        url: 'http://localhost:8888'
      }
    ]
  },

  // @nuxtjs/auth module configuration
  auth: {
    localStorage: false,
    cookie: {
      prefix: 'auth.',
      options: {
        path: '/',
        expires: 7 // 7 Days (https://auth.nuxtjs.org/api/options#cookie)
      }
    },
    strategies: {
      local: {
        endpoints: {
          login: {
            url: 'auth/sign-in',
            method: 'post',
            propertyName: 'token'
          },
          user: {
            url: 'user/me',
            method: 'get',
            propertyName: false
          },
          logout: false
        }
      }
    },
    redirect: {
      home: false,
      login: '/authorization'
    }
  },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {},
}
