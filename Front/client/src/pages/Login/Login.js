import React, { useContext, useState } from 'react'
import { Link, useNavigate } from 'react-router-dom';
import { login } from '../../AuthContext/apiCalls';
import { AuthContext } from '../../AuthContext/AuthContext';

const Login = () => {
  const [username, setUsername] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState(null);
  const {logout, login, isAuthenticated } = useContext(AuthContext);
  const navigate = useNavigate();

  const handleSubmit = async (event) => {
    event.preventDefault();
    try {
      await login(username, password);
      navigate('/');
    } catch (err) {
      setError(err.message);
    }
  };

  const handleLogout = () => {
    logout();
  }


  return (
    
    <div className='vh-100 page page-login page-log-reg flex-center'>
     {isAuthenticated ? (
        <>
          <p>You are logged in.</p>
          <button onClick={handleLogout}>Logout</button>
        </>
      ) : (
        <div className='login-container' >
            <h2 className="title-regular text-center">Bienvenue sur <br/><span>ColoCount</span></h2>
            <div className="box-shadow-1 box-model">
                <h1 className="text-center">Se connecter</h1>
                <form onSubmit={handleSubmit}>
                    <div className="fields-column">
                        <div className="fields-row">
                            <input id="loginEmail" className="form-control form-control-lg" placeholder="Adresse email"  name="username"  type="text"
              value={username}
              onChange={(e) => setUsername(e.target.value)} />
                        </div>
                        <div className="fields-row">
                            <input id="loginPassword" className="form-control form-control-lg" placeholder="Mot de passe"  name="password"  type="password"
              value={password}
              onChange={(e) => setPassword(e.target.value)}/>
                        </div>
                    </div>
                    <div className="bloc-btn">
                    {error && <p className="error">{error}</p>}
                        <button type="submit" >Je me connecte</button>
                    </div>
                </form>
            </div>
          <p className="para-16 medium text-center link-reg-log">Tu n'as pas encore de compte ? <Link className="link" to="/Register">Je m'inscris</Link></p>
        </div>
        )}
    </div>

  )
}

export default Login