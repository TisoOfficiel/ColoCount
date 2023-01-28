import React, { useState, useEffect } from 'react'
import { useNavigate } from 'react-router-dom';
import {login} from "../../AuthContext/apiCalls";


const AddColoc = () => {
  const [titre, setTitre] = useState('');
  const [description, setDescription] = useState('');
//   const navigate = useNavigate();

  const handleSubmit = async (event) => {
    event.preventDefault();

    // Récupération du token stocké dans le localStorage
    const token = localStorage.getItem('token');

    // Création de l'en-tête avec le token d'authentification
    const headers = {
        "Content-type":  "application/x-www-form-urlencoded",
        'Authorization': `Bearer ${token}`
    };

    // Envoi de la requête pour ajouter une colocation
    try {
      const response = await fetch('http://localhost:1501/add_coloc', {
        method: 'POST',
        mode: "cors",
        credentials: "include",
        headers,
        body: new URLSearchParams({ titre, description })
      });
      const data = await response.json();
      console.log(data);
    } catch (error) {
      console.error(error);
    }
  };

    return (
        <div className='vh-100 modale modale-add-coloc flex-center'>
            <div className="box-shadow-modale box-model">
                <div className="box-model-scroll">
                    <div className="cross-modale"></div>
                    <h2 className="text-center">Ajouter une nouvelle coloc</h2>
                    <form onSubmit={handleSubmit}>
                        <div className="fields-column two-fields">
                            <div className="fields-row mb-4">
                                <input type="text" id="" className="form-control form-control-lg" placeholder="Titre" value={titre} onChange={e => setTitre(e.target.value)} />
                            </div>
                            <div className="fields-row mb-4">
                                <textarea type="text" id="" className="form-control form-control-lg" placeholder="Description" value={description} onChange={e => setDescription(e.target.value)}/>
                            </div>
                        </div>
                        {/* <div className="fields-column field-title">
                            <h3>Ajouter des participants</h3>
                            <div className="fields-row mb-4">
                                <input type="text" id="form3Example3" className="form-control form-control-lg" placeholder="Adresse mail des participants"/>
                            </div>
                        </div> */}
                        <div className="bloc-btn">
                            <button type="submit" >Ajouter la coloc</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    )
}
export default AddColoc