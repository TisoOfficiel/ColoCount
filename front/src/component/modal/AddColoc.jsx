import Cookies from 'js-cookie';
import { useState } from 'react';
import '../../assets/css/components/modal/add-coloc.css';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import {faXmark} from "@fortawesome/free-solid-svg-icons";

const AddColoc = (props) => {
  const [titre, setTitre] = useState('');
  const [description, setDescription] = useState('');
  const [status,setStatus] = useState('');
  const handleSubmit = async e => {
    e.preventDefault();
    let jwtToken = Cookies.get('token');

    await fetch('http://localhost:1501/add_coloc', {
    method: 'POST',
    headers: new Headers({
      "Authorization" : "Bearer "+ jwtToken,
    }),
    body: new URLSearchParams({
      titre, description
    })
  })
    .then(response => response.json())
    .then(data => {
      window.location.reload();
    })


    
  }
  return (
    <div className="modal-background">
      <div className="modal-container">
        <FontAwesomeIcon className="close-icon" icon={faXmark} onClick={props.onClose}></FontAwesomeIcon>
        <h2 className="title">Ajouter une <br/> nouvelle coloc</h2>
        <form onSubmit={handleSubmit} className='form-add-coloc'>
          <input type="text" name="titre" placeholder='Titre' value={titre} onChange={e => setTitre(e.target.value)} />
          <textarea placeholder='Description' name='description' value={description} onChange={e => setDescription(e.target.value)}></textarea>
          <button className="btn">Ajouter la coloc</button>
        </form>
      </div>
    </div>
  )
}

export default AddColoc