import React from "react";
import '../assets/css/modales/modale-depense.css';


const ModaleDepense = () => {
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

        <div className='vh-100 modale modale-depense flex-center'>
            <div className="box-shadow-modale box-model modale-depense-container">
                <div className="box-model-scroll">
                    <div className="cross-modale"></div>
                    <h1 className="text-center">Titre dépense</h1>
                    <p className="satoshi-bold category-depense para-15">Catégorie</p>
                    <div className="depense-bloc">
                        <div className="depense-total box-model">
                            <p className="satoshi-bold type-depense para-15">Type dépense</p>
                            <p className="depense-totel-price para-105 satoshi-bold">10€</p>
                        </div>
                        <div className="depense-participants box-model box-shadow-1">
                            <p className="satoshi-bold payeur-depense para-15 icon-participant">Payé par Pseudo</p>
                            <div className="participants-list">
                                {items.map((item) =>
                                    <div className="participant-item box-model" key={item.id}>
                                        <p className="para-16 medium">{item.pseudo}</p>
                                        <p className="prix-divise para-18 satoshi-bold">{item.price}€</p>
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
};
export default ModaleDepense;