export const getCall = (apiUrl, userId) => {    return  axios.get(apiUrl, {        headers: {          user: userId,        }      })}export const postCall = (apiUrl, userId) => {  return  axios.post(apiUrl, {    headers: {      user: userId,    }  })}