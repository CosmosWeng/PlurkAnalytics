const getters = {
  sidebar: state => state.app.sidebar,
  device: state => state.app.device,
  permission_routes: state => state.permission.routes,
  addRoutes: state => state.permission.addRoutes,
  roles: state => state.user.roles.map(item => item.name)
}

export default getters
