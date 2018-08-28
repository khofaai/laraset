module.exports = [
  {
    title: 'Getting Started',
    collapsable: false,
    children: [
      '/1.0/' 
    ],
  },
  {
    title: 'Basics',
    collapsable: false,
    children: prefix('/1.0/basics', [
      '',
      'units',
    ]),
  },
  {
    title: 'Commands',
    collapsable: false,
    children: prefix('/1.0/commands', [
      '',
    ]),
  }
]

function prefix(prefix, children) {
  return children.map(child => `${prefix}/${child}`)
}