
export default {
  /*
    GET   /api/user
  */
  getUser: async function() {
    return await axios.get('api/auth').then(res => {
      return res.data.user;
    }).catch(err => {
      throw err;
    });
  },
  /*
    POST   /login
  */
  login: async function(data) {
    return await axios.post('api/login', data).then(res => {
      return res.data;
    }).catch(err => {
      throw err;
    });
  },
  /*
    POST  /Logout
  */
  logout: async function() {
    return await axios.post('api/logout', {
    }).then(res => {
      return res.data;
    }).catch(err => {
      throw err;
    });
  }
}
