import axios from "axios";
import { loginFailure, loginStart, loginSuccess } from "./AuthActions";

export const login = async (user, dispatch) => {
  dispatch(loginStart());
  try {
    const res = await fetch("http://localhost:1501/login", {
      method: "POST",
      body: JSON.stringify(user),
      credentials: "include",
      headers: new Headers({
        "Authorization": "Basic amZnbWFpbC5jb206cGFzc3dvcmQ=",
        "Content-type": "application/x-www-form-urlencoded"
    })
    });
    const data = await res.json();
    if (!res.ok) {
      throw new Error(data.message);
    }
    dispatch(loginSuccess(data));
  } catch (err) {
    dispatch(loginFailure());
  }
};