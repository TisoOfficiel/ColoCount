import React from 'react'
import MySvg from '../assets/image/coloCount.svg';
import { Link } from 'react-router-dom';
import '../assets/css/components/navbar.css';
const Navbar = (props) => {
  const show = props.show
  return (
    <div className='navbar'>
        <Link to="/"><img src={MySvg} alt="Logo"/></Link>
        <div className="link-container">
          <div className="my-account">Mon Compte</div>
          {show &&(
          <Link to="/mesColocs" className="my-colocs" >Mes Colocs</Link>
          )}
        </div>
    </div>
  )
}

export default Navbar