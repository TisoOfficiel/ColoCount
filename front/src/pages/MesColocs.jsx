import React from 'react'
import Colocs from '../component/MesColocs-card'
import Navbar from '../component/Navbar'
import '../assets/css/pages/MesColocs.css';

const MesColocs = () => {
  return (
    <>
    <Navbar show={false}/>
    <div className="container">
    <h1>Mes colocs</h1>
    <div className="container-all-card">
      <Colocs/>
      <Colocs/>
      <Colocs/>
      <Colocs/>
    </div>
    <button className="btn">Ajouter une coloc +</button>
    </div>
    </>
  )
}

export default MesColocs