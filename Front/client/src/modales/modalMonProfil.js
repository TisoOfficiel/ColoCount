import React, { useState, useEffect } from 'react'
import iconModif from "../assets/images/icons/icon-modif.svg";
import ProfilPhoto from "../components/ProfilPhoto";
import '../assets/css/modales/modale-mon-profile.css';



const MonProfil = () => {
    const [confirm_password, setConfirm_password] = useState("");
    const [password, setPassword] = useState("");
    const [username, setUsername] = useState("");
    const [old_password, setOld_password] = useState("");
    const userName = "Joseph";
    const email = "Josephmenard@gmail.com";

    const [show_profil, setShow_profil] = useState(true);
    const [show_form, setShow_form] = useState(false);
    // setShow_form(false);

    const hideAndShow = async (event) => {
        event.preventDefault();
        setShow_profil(false);
        setShow_form(true);

    }
    const handleSubmit =  async (event) => {
        event.preventDefault();


        // Récupération du token stocké dans le localStorage
        const token = localStorage.getItem('token');
        console.log(token);

        // Création de l'en-tête avec le token d'authentification
        const headers = {
            "Content-type":  "application/x-www-form-urlencoded",
            'Authorization': `Bearer ${token}`
        };

        // Envoi de la requête pour ajouter une colocation
        try {
            const response = await fetch('http://localhost:1501/mes_colocs/mon_compte', {
                method: 'POST',
                mode: "cors",
                credentials: "include",
                headers,
                body: new URLSearchParams({ username, old_password, password, confirm_password })
            });
            const data = await response.json();
            console.log(data);
            setShow_profil(true);
            setShow_form(false);
        } catch (error) {
            console.error(error);

        }
    }

    // const componentDidMount = () => {
    //    fetch('http://localhost:1501/users').then((response) => {
    //        console.log(response.json());
    //    })
    // }




    return (
        <div className='vh-100 modale modale-profile flex-center'>
            <div className="box-shadow-modale box-model">
                <div className="box-model-scroll">
                    <div className="cross-modale"></div>
                    <h2 className="text-center">Mon profil</h2>
                        <div className="profil">
                            {show_profil ?
                                // <ProfilPhoto/>
                            <div className="overlay-photo" id="iconModifPseudo">
                                <div className="icon-modif-profil">
                                    <img src={iconModif}/>
                                </div>
                            </div>:""}
                            {show_profil ?
                                // <ProfilPhoto/>
                                <div className="userName" id="ModifPseudo">
                                    <h2 className="field-title pseudo">Votre pseudo</h2>
                                    <p className="field pseudo">{userName}</p>
                                </div>:""}
                            {show_profil ?
                            <div className="email" id="affiche-Email">
                                <h2 className="field-title email">Votre email</h2>
                                <p className="field email">{email}</p>
                            </div>:""}
                            {show_profil ?
                                <div className="password" id="affiche-password">
                                <h2 className="field-title password">Votre password</h2>
                                <p className="field password">*******</p>
                            </div>:""}
                            {show_profil ?
                            <button onClick={hideAndShow} className="link para-16 medium text-center" >Modifier mon profil</button>
                                :""}
                        </div>
                    {show_form ?
                        <form className="form-profil">
                            <div className="fields-row username">
                                <input type="text" id="username" className="form-control form-control-lg" placeholder="Choisir nouveau pseudo" onChange={(e) => setUsername(e.target.value)}/>
                            </div>
                            <div className="fields-row password">
                                <input type="text" id="ancienPassword" className="form-control form-control-lg" placeholder="Renseigner votre ancien mot de passe" onChange={(e) => setOld_password(e.target.value)}/>
                                <input type="text" id="nouveauPassword" className="form-control form-control-lg" placeholder="Choisir un nouveau mot de passe" onChange={(e) => setPassword(e.target.value)}/>
                                <input type="text" id="confirmPassword" className="form-control form-control-lg" placeholder="Confirmer votre nouveau  mot de passe" onChange={(e) => setConfirm_password(e.target.value)}/>
                            </div>
                            <button type="submit" onClick={handleSubmit} className="link para-16 medium text-center" >Modifier mon profil</button>
                        </form>:""
                    }
                </div>
            </div>
        </div>
    )
}
export default MonProfil