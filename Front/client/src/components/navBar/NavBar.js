import React, {useContext, useEffect, useState} from 'react';
import '../../assets/css/components/navbar.css';
import {Link} from "react-router-dom";
import { useLocation } from 'react-router-dom';


export default function NavBar() {
    const location = useLocation();
    const [isHome,setIsHome] = useState(true);

    useEffect(() =>{
        if(location.pathname == "/"){
            setIsHome(true)
        }else{
            setIsHome(false)
        }
    },[isHome]);

    if(location.pathname == "/login" || location.pathname == "/register"){

        return null;
    }else{

    return (
        <header className="navbar">
            <div className="logo">
                <Link to="/">coloCount</Link>
            </div>
            <ul className="menu">
                {isHome ?
                    "":<li><Link to="/Login">Mes Colocs</Link></li>
                }
                <li><Link to="/Login">Mon Compte</Link></li>
            </ul>
        </header>
    )
    }
}
