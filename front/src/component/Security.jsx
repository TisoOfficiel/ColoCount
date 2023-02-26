import "../assets/css/components/security.css"
import { Link } from 'react-router-dom'
const Security = (props) => {
    const Info = props.infoSecurity;
    const statusClass = `container-form ${Info.register ? 'register' : 'login'}`;
    return (
        <div className='container-component'>
            <p className="title">Bienvenue              sur<span>coloCount</span></p>
            <div className={statusClass}>
                <h1>{Info.formTitle}</h1>
                <form action="" method=''>
                    <input type="text" placeholder='Pseudo' />
                    {Info.register &&(
                    <input type="email" placeholder='Adresse email'/>)}
                    <input type="password" placeholder='Mot de passe'/>
                    {(Info.register && <input type="password" placeholder='Confirmation mot de passe'/>)}
                </form>
                <button type='submit' className="btn submit">{Info.button}</button>
            </div>
                <p className="link">{Info.textLink}<Link to={Info.link}>{Info.linkText}</Link></p>
        </div>
  )
}

export default Security