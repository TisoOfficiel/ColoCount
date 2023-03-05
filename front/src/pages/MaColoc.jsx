import '../assets/css/pages/ma-coloc.css'
import React, { useEffect,useState  } from 'react'
import Navbar from '../component/Navbar'
import Toggle from '../component/Toggle'
import Cookies from 'js-cookie'
import {faEllipsisV } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'

const MaColoc = () => {
  const [isChecked, setIsChecked] = useState(false);
  
  function handleToggle() {
    setIsChecked(!isChecked);
  }

  const [colocationInfo,setColocationInfo] = useState([]);
  const [userInfo,setUserInfo] = useState([]);
  const [chargeInfo,setChargeInfo] = useState([]);
  const [equilibreInfo,setEquilibreInfo] = useState([]);

  useEffect(() => {
    let jwtToken = Cookies.get('token');
    let id = window.location.pathname.split('/')[2];

    fetch(`http://localhost:1501/mes_colocs/${id}`, {
      method: 'GET',
      headers: new Headers({
        "Authorization" : "Bearer "+ jwtToken,
      })
    })
    .then(data => data.json())
    .then(data => {
      setColocationInfo(data.InfoColoc.colocation_info);
      setUserInfo(data.InfoColoc.user_info);
      setChargeInfo(data.InfoColoc.charge_info);
      setEquilibreInfo(data.InfoColoc.equilibre_info);
    })
  }, []);

  return (
    <>
    <Navbar show={true}/>
    <div className="macoloc-container">
    <Toggle isChecked={isChecked} onToggle={handleToggle} />  
    <h2>Nom coloc</h2>
    <button className="btn">Ajouter une dépense</button>

    {chargeInfo.map((charge) => (
      <div className="charge-container">
        <h4 className="title-charge" data-chargeId={charge[0].charge_id}>{charge[0].charge_name}</h4>
        <p className="paymaster-charge" data-paymasterId={charge[1].paymaster_id}>{charge[1].paymaster_name}</p>
        <div className="left">
          <p className="amount-charge">{charge[0].charge_amount}</p>
          <FontAwesomeIcon className="moreVertical" icon={faEllipsisV}/>
        </div>
      </div>
    ))}

    </div>
    </>
  )
}

export default MaColoc