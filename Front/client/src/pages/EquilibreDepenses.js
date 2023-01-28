import React, { useEffect, useState } from 'react'
import NavBarToggle from "../components/navBar/NavBarToggle";
import ProfilPhoto from "../components/ProfilPhoto";
import '../assets/css/pages/page-equilibre.css';


const EquilibreDepenses = () => {
    const items = [
        {
            id: 1,
            pseudo: "Pseudo 1",
            price: "102",
        },
        {
            id: 2,
            pseudo: "Pseudo 2",
            price: "102.55",
        },
        {
            id: 3,
            pseudo: "Pseudo 3",
            price: "12",
        },
        {
            id: 4,
            pseudo: "Pseudo 4",
            price: "4.78",
        },
    ];

    return (

        <div className="vh-100 page page-equilibre">
            <NavBarToggle />
            <div className="equilibre-container">
                <h1>Équilibre des dépenses</h1>
                <h2 className="satoshi-reg">Nom de la coloc</h2>
                <div className="equilibre-bloc">
                    <div className="equilibre-participants">
                        {items.map((item) =>
                            <div className="box-model" key={item.id}>
                                <div className="participants-infos">
                                    <ProfilPhoto />
                                    <p className="para-18 medium">{item.pseudo}</p>
                                </div>
                                <p className="para-24 satoshi-bold red participants-price">{item.price}€</p>
                            </div>
                        )}
                    </div>
                    <div className="equilibre-remboursement box-model box-shadow-1">
                        <h2>Qui rembourser ?</h2>
                        <div className="equilibre-list">
                            {items.map((item) =>
                                <div className="rembourse-item" key={item.id}>
                                    <div className="rembourse-text">
                                        <p className="para-18 medium">{item.pseudo}</p>
                                        <p className="para-15">doit à</p>
                                        <p className="para-18 medium">{item.pseudo}</p>
                                    </div>
                                    <div className="rembourse-price">
                                        <p className="para-22 satoshi-bold">{item.price}€</p>
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
};
{/*onClick={() => handleOption(item.id)}*/}
export default EquilibreDepenses;