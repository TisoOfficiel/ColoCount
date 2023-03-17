import React from 'react'
import Colocs from '../component/MesColocs-card'
import Navbar from '../component/Navbar'
import AddColoc from '../component/modal/AddColoc';
import '../assets/css/pages/mes-colocs.css';
import '../assets/css/components/modal/common-modal.css'
import { useState, useEffect } from 'react';
import Cookies from 'js-cookie';
const MesColocs = () => {
  
  const [colocData, setColocData] = useState([]);
  const [isModalOpen, setIsModalOpen] = useState(false);

  const handleOpenModal = () => {
    setIsModalOpen(true);
    document.body.classList.add("no-scroll");
  };

  const handleCloseModal = () => {
    setIsModalOpen(false);
    document.body.classList.remove("no-scroll");
  };

  useEffect(() => {
    let jwtToken = Cookies.get('token');
    fetch('http://localhost:1501/mes_colocs', {
      method: 'GET',
      headers: new Headers({
        "Authorization" : "Bearer "+ jwtToken,
      })
    })
    .then(data => data.json())
    .then(data => {
      setColocData(data[0]);
    })
  }, []);


  return (
    <>
    <Navbar show={false}/>
    <div className="container">
    <h1>Mes colocs</h1>
    <div className="container-all-card">    
    {colocData.map((data, index) => (
      <Colocs key={index} myProp={data} />
    ))}
    </div>
    
    {isModalOpen &&(
      <AddColoc onClose={handleCloseModal}/>
    )}
    <button onClick={handleOpenModal} className="btn">Ajouter une coloc +</button>
    </div>
    </>
  )
}

export default MesColocs