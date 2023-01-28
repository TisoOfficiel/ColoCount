import React, { useState, useEffect } from 'react'
import {Link, useNavigate} from 'react-router-dom';
import iconArrow from "../assets/images/icons/button-arrow.svg";


const ModaleAddRemboursement = () => {
    const [participants, setParticipants] = useState([]);
    useEffect(() => {
        const token = localStorage.getItem('token');
        const headers = {
            "Content-type":  "application/x-www-form-urlencoded"
        };
        if (token) {
            headers.Authorization = `Bearer ${token}`;
        }
        fetch('http://localhost:1501/mes_colocs', { headers })
            .then(response => response.json())
            .then(data =>{setParticipants (data[0])
                console.log(data.data)
            })
            .catch(error => console.log(error))
            .finally(() => setLoading(false));
    }, []);


    const [titre, setTitre] = useState('');
    const [montant, setMontant] = useState('');
    const [payeur, setPayeur] = useState('');
    const [beneficiaire, setBeneficiaire] = useState('');
    const handleSubmit = async (event) => {
      event.preventDefault();

      // Récupération du token stocké dans le localStorage
      const token = localStorage.getItem('token');

      // Création de l'en-tête avec le token d'authentification
      const headers = {
          "Content-type":  "application/x-www-form-urlencoded",
          'Authorization': `Bearer ${token}`
      };

      // Envoi de la requête pour ajouter un remboursement
      try {
        const response = await fetch('http://localhost:1501/add_remboursement', {
          method: 'POST',
          mode: "cors",
          credentials: "include",
          headers,
          body: new URLSearchParams({ titre, montant, payeur, beneficiaire })
        });
        const data = await response.json();
        console.log(data);
      } catch (error) {
        console.error(error);
      }
    };

    return (
        <div className='vh-100 modale modale-remboursement-depense flex-center'>
            <div className="box-shadow-modale box-model">
                <div className="box-model-scroll">
                    <div className="cross-modale"></div>
                    <h2 className="text-center">Ajouter un remboursement</h2>
                    <form>
                        <div className="fields-column form-bloc">
                            <div className="fields-row two-fields">
                                <div className="fields-column">
                                    <h3>Titre</h3>
                                    <input type="text" id="" placeholder="Titre" value={titre} onChange={e => setTitre(e.target.value)}/>
                                </div>
                                <div className="fields-column">
                                    <h3>Montant</h3>
                                    <input type="number" id="" placeholder="Montant" value={montant} onChange={e => setMontant(e.target.value)}/>
                                </div>
                            </div>
                            <div className="fields-row two-fields">
                                <div className="fields-column">
                                    <h3>Qui rembourse ?</h3>
                                    <select value={this.state.value} onChange={e => setPayeur(e.target.value)}>
                                        {participants.map(participant => (
                                            <option value="{participant.name}" key={participant.id}>
                                                {participant.name}
                                            </option>
                                            ))}
                                    </select>
                                </div>
                                <div className="fields-column">
                                    <h3>Qui est remboursé ?</h3>
                                </div>
                            </div>
                        </div>
                        <div className="bloc-btn">
                            <button type="submit" >Ajouter le remboursement</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    )
}
export default ModaleAddRemboursement