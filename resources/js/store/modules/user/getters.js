export default {
  getFriends: state => {
    let friends = [],
        object = state.friendObjects

    for (const key in object) {
      if (object.hasOwnProperty(key)) {
        const element = object[key]

        element.id = key
        friends.push(element)
      }
    }

    return friends
  }
}
