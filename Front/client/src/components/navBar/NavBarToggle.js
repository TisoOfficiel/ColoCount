import React, {useContext, useEffect, useState} from 'react';
import '../../assets/css/components/navbar-toggle.css';
import {Link} from "react-router-dom";
import iconParticipants from "../../assets/images/icons/icon-participants.svg"

export default function NavBarToggle() {
        return (
            <div className="navbar-toggle">
                <div className="menu-box box-shadow-1">
                    <ul className="menu">
                        <li><Link className="active" to="/NameColoc/:id">Les dépenses</Link></li>
                        <li><Link to="">L'équilibre</Link></li>
                    </ul>
                </div>
                <Link to="/participants" className="icon-participants box-shadow-1">
                    <img src={iconParticipants}/>
                </Link>
            </div>
        )
}
