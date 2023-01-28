import axios from 'axios';
import React, { useRef, useState } from 'react'
import { Link} from 'react-router-dom';
import { Button } from '../../components/Button/Button';


const Register = () => {
    const [email, setEmail] = useState("");
    const [confirm_password, setConfirm_password] = useState("");
    const [password, setPassword] = useState("");
    const [username, setUsername] = useState("");
    const [error, setError] = useState('');
    // const navigate = useNavigate();


    const handleSubmit = async (e) => {
        e.preventDefault();
        // if (password !== confirm_password) {
        //   setError('Les mots de passe ne correspondent pas');
        //   return;
        // }
        fetch('http://localhost:1501/register', {
            method: "POST",
            mode: "cors",
            body: new URLSearchParams({
                email,password,username,confirm_password
            }),
            credentials: "include",
            headers: new Headers({
                "Authorization" : "Basic amZnbWFpbC5jb206cGFzc3dvcmQ=",
                "Content-type":  "application/x-www-form-urlencoded"
            })
        })
            .then(data => data.json())
            // .then(json =>
            //     console.log(json.token)
            
            // ) 
            .then(json => {
                if(json.token){
                    // navigate("/home")
                }
            })

           
    }


  return (
      <div className='vh-100 page page-register page-log-reg flex-center'>
          <div className='register-container'>
              <h2 className="title-regular text-center">Bienvenue sur <br/><span>ColoCount</span></h2>
              <div className="box-shadow-1 box-model">
                  <h1 className="text-center">S'inscrire</h1>
                  <form onSubmit={handleSubmit}>
                      <div className="fields-column">
                          <div className="fields-row mb-4">
                              <input type="text" id="form3Example3" className="form-control form-control-lg" placeholder="Pseudo"  value={username} onChange={(e) => setUsername(e.target.value)} required />
                              <input type="email" id="form3Example3" className="form-control form-control-lg" placeholder="Adresse email" value={email} onChange={(e) => setEmail(e.target.value)} required />
                          </div>
                          <div className="fields-row mb-4">
                              <input type="password" id="form3Example3" className="form-control form-control-lg" placeholder="Mot de passe" value={password} onChange={(e) => setPassword(e.target.value)}   />
                              <input type="password" id="form3Example3" className="form-control form-control-lg" placeholder="Confirmation mot de passe"  value={confirm_password} onChange={(e) => setConfirm_password(e.target.value)}  />
                          </div>
                      </div>
                      <div className="bloc-btn">
                          <button type="submit">Je m'inscris</button>
                      </div>
                  </form>
              </div>
              <p className="para-16 medium text-center link-reg-log">Tu as déjà un compte ? <Link className="link" to="/Login">Je me connecte</Link></p>
          </div>
      </div>
 
  )
}

export default Register