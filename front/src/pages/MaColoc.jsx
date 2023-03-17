import '../assets/css/pages/ma-coloc.css';
import React, { useEffect,useState  } from 'react';
import Navbar from '../component/Navbar';
import Toggle from '../component/Toggle';
import Cookies from 'js-cookie';
import Depense from '../component/Depense';
import Equilibre from '../component/Equilibre';
import jwt_decode from 'jwt-decode';
const MaColoc = () => {
  const [depenseChecked, setDepenseChecked] = useState(false);

  function handleToggle() {
    setDepenseChecked(!depenseChecked);
  }

  const [colocationInfo,setColocationInfo] = useState([]);
  const [userInfo,setUserInfo] = useState([]);
  const [chargeInfo,setChargeInfo] = useState([]);
  const [equilibreInfo,setEquilibreInfo] = useState([]);
  const [connectedId,setConnectedId] = useState('');
  useEffect(() => {
    let jwtToken = Cookies.get('token');
    const decodedToken = jwt_decode(jwtToken);
    setConnectedId(decodedToken.id);

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
    <Toggle depenseChecked={depenseChecked} onToggle={handleToggle} />
    {!depenseChecked && (
    <Depense colocationInfo={colocationInfo} chargeInfo={chargeInfo} userInfo={userInfo}/>
    )} 
    {depenseChecked && (
      <Equilibre colocationInfo={colocationInfo} userInfo={userInfo} equilibreInfo={equilibreInfo} connectedId={connectedId}/>
    )}
    
    </div>
    </>
  )
}

export default MaColoc