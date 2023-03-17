import React from 'react'
import Security from '../../component/Security'

const Register = () => {
    const register = {
        formTitle: "S'incrire",
        register: true,
        button:"Je m'inscris",
        textLink:"Tu as déjà un compte ? ",
        linkText: "Je me connecte",
        link: "/",
    };
    
  return (
    <div>
        <Security infoSecurity={register}/>
    </div>
  )
}

export default Register