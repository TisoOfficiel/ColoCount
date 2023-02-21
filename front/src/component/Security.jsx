import "../assets/css/components/security.css"
import { Link } from 'react-router-dom'
import Login from "../pages/Security/Login"
const Security = (props) => {
    const Info = props.infoSecurity;
    const statusClass = `container-form ${Info.register ? 'register' : 'login'}`;
    return (
        <div className='container-component'>
            <p className="title">Bienvenue              sur<span>coloCount</span></p>
            <div className={statusClass}>
                <h2>{Info.formTitle}</h2>
                <form action="" method=''>
                    <input id="pseudoInput" type="text" placeholder='Pseudo' />
                    {Info.register &&(
                    <input id="emailInput" type="email" placeholder='Adresse email'/>)}
                    <input id="passwordId" type="password" placeholder='Mot de passe'/>
                    {(Info.register && <input id="confirmationPasswordId" type="password" placeholder='Confirmation mot de passe'/>)}
                </form>
                <button type='submit' className="submit">{Info.button}</button>
            </div>
                <p className="link">{Info.textLink}<Link to={Info.link}>{Info.linkText}</Link></p>
        </div>
  )
}

export default Security