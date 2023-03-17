import React from 'react'
import Security from '../../component/Security'

const Login = () => {
  const login = {
    formTitle: "Se connecter",
    register: false,
    button:"Je me connecte",
    textLink:"Tu n'as pas encore de compte ? ",
    linkText: "Je m'inscris",
    link: "/register",
};
  return (
    <div>
        <Security infoSecurity={login}/>
    </div>
  )
}

export default Login