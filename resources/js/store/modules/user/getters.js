export default {
  token: state => state.token,
  user: state => state.user,
  avatar: state => state.avatar, //'images/user.png',
  avatar_big: state => state.avatar_big,
  name: state => state.name,
  plurk_uuid: state => state.plurk_uuid,
  introduction: state => state.introduction,
  full_name: state => state.full_name,
  join_date: state => state.join_date,
  karma: state => state.karma,
  timezone: state => state.timezone,
  friends_count: state => state.friends_count
}
