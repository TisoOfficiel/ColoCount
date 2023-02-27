import React from 'react'
import Colocs from '../component/MesColocs-card'
import Navbar from '../component/Navbar'
import '../assets/css/pages/MesColocs.css';
import { useState, useEffect } from 'react';
import Cookies from 'js-cookie';
const MesColocs = () => {
  
  const [colocData, setColocData] = useState([]);
 

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
      {/* <Colocs/>
      <Colocs/>
      <Colocs/>
      <Colocs/> */}
    </div>
    <button className="btn">Ajouter une coloc +</button>
    </div>
    </>
  )
}

export default MesColocs