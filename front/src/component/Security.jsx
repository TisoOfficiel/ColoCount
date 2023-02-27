import "../assets/css/components/security.css";
import { Link,useNavigate } from 'react-router-dom';
import  { useState } from 'react';

const Security = (props) => {
    const Info = props.infoSecurity;
    const statusClass = `container-form ${Info.register ? 'register' : 'login'}`;
    const [username, setUsername] = useState('');
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [confirmationPassword, setConfirmationPassword] = useState('');
    const navigate = useNavigate();

    const handleSubmit = async e => {
        e.preventDefault();
        if(!Info.register){
            const response = await fetch('http://localhost:1501/login', {
            method: 'POST',
            mode: "cors",
            credentials: "include",
            headers: new Headers({
                    "Authorization": "Basic amZnbWFpbC5jb206cGFzc3dvcmQ=",
                    "Content-type": "application/x-www-form-urlencoded"
                }),
                body: new URLSearchParams({
                    username,password
                }),
            });

            const data = await response.json();
            if(data.token){
                localStorage.setItem('token', data.token);
                navigate('/mesColocs');
            }

        }else{
            const response = await fetch('http://localhost:1501/register', {
            method: 'POST',
            headers: new Headers({
                "Authorization": "Basic amZnbWFpbC5jb206cGFzc3dvcmQ=",
                "Content-type": "application/x-www-form-urlencoded"
            }),
            body: new URLSearchParams({
                username, email, password, confirmationPassword 
            }),
        });
        
        const data = await response.json();
        if(data.token){
            localStorage.setItem('token', data.token);
            navigate('/mesColocs');
        }
        }        
    };
    
    return (
        <div className='container-component'>
            <p className="title">Bienvenue sur<span>coloCount</span></p>
            <div className={statusClass}>
                <h1>{Info.formTitle}</h1>
                <form onSubmit={handleSubmit}>
                    <input type="text" placeholder='username' name="username" value={username} onChange={e => setUsername(e.target.value)}/>
                    {Info.register &&(
                    <input type="email" placeholder='Adresse email' value={email} onChange={e => setEmail(e.target.value)}/> )}
                    <input type="password" placeholder='Mot de passe' name="password" value={password} onChange={e => setPassword(e.target.value)}/>
                    {(Info.register && <input type="password" placeholder='Confirmation mot de passe' value={confirmationPassword} onChange={e => setConfirmationPassword(e.target.value)}/>)}
                    <button className="btn submit">{Info.button}</button>
                </form>
            </div>
                <p className="link">{Info.textLink}<Link to={Info.link}>{Info.linkText}</Link></p>
        </div>
  )
}

export default Security