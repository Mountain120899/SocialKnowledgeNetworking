import React from "react";
import axios, { AxiosResponse } from "axios";

axios.defaults.baseURL = `http://127.0.0.1:8000`;

const requests = {
  get: (url) => axios.get(url).then(response => response.data),
  post: (url, body) => axios.post(url, body).then(response => response.data),
  put: (url, body) => axios.put(url, body).then(response => response.data),
  delete: (url) => axios.delete(url).then(response => response.data),
};

const User = {
  insert: (loginAccount) => requests.post(`/user`, loginAccount),
};
const Verify = {
  verify: (VerifyInformation) => requests.put(`/verify`, VerifyInformation),
  getanswer: (id)=> requests.get('/answernotverify/'+id)
};
export const agent = {
  User,Verify
};

export default agent;
