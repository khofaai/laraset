module.exports = {
  // title: 'Laravel Nova',
  title: 'Laraset',
  description: 'Master Your Universe',
  base: '/docs/',
  head: [
    [
      'link',
      {
        href:
          'https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,800,800i,900,900i',
        rel: 'stylesheet',
        type: 'text/css',
      },
    ],
  ],

  themeConfig: {
    repo: 'khofaai/laraset',
    displayAllHeaders: true,
    sidebarDepth: 1,

    nav: [
      {text: 'Home', link: '/1.0/'},
      // {text: 'Version', link: '/', items: [{text: '1.0', link: '/1.0/'}]},
    ],

    sidebar: {
      "/":require('./1.0')
    } 
  },
};
